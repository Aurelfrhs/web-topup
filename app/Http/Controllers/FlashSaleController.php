<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index(Request $request)
    {
        $query = FlashSale::with('product.game');

        // Search by product name
        if ($request->filled('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'expired':
                    $query->expired();
                    break;
            }
        }

        $flashSales = $query->latest()->paginate(20);

        return view('admin.flash-sales.index', compact('flashSales'));
    }

    public function create()
    {
        $products = Product::with('game')->where('is_active', true)->get();
        return view('admin.flash-sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'stock' => 'required|integer|min:1',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
        ], [
            'product_id.required' => 'Produk harus dipilih',
            'product_id.exists' => 'Produk tidak ditemukan',
            'discount_percentage.required' => 'Persentase diskon harus diisi',
            'discount_percentage.min' => 'Persentase diskon minimal 1%',
            'discount_percentage.max' => 'Persentase diskon maksimal 99%',
            'stock.required' => 'Stok harus diisi',
            'stock.min' => 'Stok minimal 1',
            'start_time.required' => 'Waktu mulai harus diisi',
            'start_time.after_or_equal' => 'Waktu mulai harus setelah atau sama dengan waktu sekarang',
            'end_time.required' => 'Waktu berakhir harus diisi',
            'end_time.after' => 'Waktu berakhir harus setelah waktu mulai',
        ]);

        // Get product
        $product = Product::findOrFail($validated['product_id']);

        // Calculate prices
        $originalPrice = $product->price;
        $discountAmount = ($originalPrice * $validated['discount_percentage']) / 100;
        $discountedPrice = $originalPrice - $discountAmount;

        // Create flash sale
        FlashSale::create([
            'product_id' => $validated['product_id'],
            'original_price' => $originalPrice,
            'discounted_price' => $discountedPrice,
            'discount_percentage' => $validated['discount_percentage'],
            'stock' => $validated['stock'],
            'sold' => 0,
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale berhasil ditambahkan');
    }

    public function edit($id)
    {
        $flashSale = FlashSale::with('product.game')->findOrFail($id);
        $products = Product::with('game')->where('is_active', true)->get();
        return view('admin.flash-sales.edit', compact('flashSale', 'products'));
    }

    public function update(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'stock' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Get product
        $product = Product::findOrFail($validated['product_id']);

        // Calculate prices
        $originalPrice = $product->price;
        $discountAmount = ($originalPrice * $validated['discount_percentage']) / 100;
        $discountedPrice = $originalPrice - $discountAmount;

        // Update flash sale
        $flashSale->update([
            'product_id' => $validated['product_id'],
            'original_price' => $originalPrice,
            'discounted_price' => $discountedPrice,
            'discount_percentage' => $validated['discount_percentage'],
            'stock' => $validated['stock'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale berhasil diupdate');
    }

    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale berhasil dihapus');
    }

    // ==================== API ENDPOINTS ====================

    public function apiIndex()
    {
        $flashSales = FlashSale::with('product.game')
            ->active()
            ->get();

        return response()->json(['data' => $flashSales], 200);
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'stock' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $originalPrice = $product->price;
        $discountAmount = ($originalPrice * $validated['discount_percentage']) / 100;
        $discountedPrice = $originalPrice - $discountAmount;

        $flashSale = FlashSale::create([
            'product_id' => $validated['product_id'],
            'original_price' => $originalPrice,
            'discounted_price' => $discountedPrice,
            'discount_percentage' => $validated['discount_percentage'],
            'stock' => $validated['stock'],
            'sold' => 0,
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'message' => 'Flash sale created successfully',
            'data' => $flashSale
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $flashSale = FlashSale::find($id);

        if (!$flashSale) {
            return response()->json(['message' => 'Flash sale not found'], 404);
        }

        $validated = $request->validate([
            'product_id' => 'sometimes|exists:products,id',
            'discount_percentage' => 'sometimes|numeric|min:1|max:99',
            'stock' => 'sometimes|integer|min:1',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after:start_time',
            'is_active' => 'sometimes|boolean',
        ]);

        if (isset($validated['product_id']) || isset($validated['discount_percentage'])) {
            $product = Product::findOrFail($validated['product_id'] ?? $flashSale->product_id);
            $discountPercentage = $validated['discount_percentage'] ?? $flashSale->discount_percentage;

            $originalPrice = $product->price;
            $discountAmount = ($originalPrice * $discountPercentage) / 100;
            $discountedPrice = $originalPrice - $discountAmount;

            $validated['original_price'] = $originalPrice;
            $validated['discounted_price'] = $discountedPrice;
            $validated['discount_percentage'] = $discountPercentage;
        }

        $flashSale->update($validated);

        return response()->json([
            'message' => 'Flash sale updated successfully',
            'data' => $flashSale
        ], 200);
    }

    public function apiDestroy($id)
    {
        $flashSale = FlashSale::find($id);

        if (!$flashSale) {
            return response()->json(['message' => 'Flash sale not found'], 404);
        }

        $flashSale->delete();

        return response()->json(['message' => 'Flash sale deleted successfully'], 200);
    }
}