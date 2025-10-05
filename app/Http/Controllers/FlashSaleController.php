<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::with('product')
            ->where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->get();

        return response()->json(['data' => $flashSales], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|integer|min:1|max:100',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $flashSale = FlashSale::create($request->all());

        return response()->json([
            'message' => 'Flash sale created successfully',
            'data' => $flashSale
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $flashSale = FlashSale::find($id);

        if (!$flashSale) {
            return response()->json(['message' => 'Flash sale not found'], 404);
        }

        $request->validate([
            'product_id' => 'sometimes|exists:products,id',
            'discount_percent' => 'sometimes|integer|min:1|max:100',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after:start_time',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $flashSale->update($request->all());

        return response()->json([
            'message' => 'Flash sale updated successfully',
            'data' => $flashSale
        ], 200);
    }

    public function destroy($id)
    {
        $flashSale = FlashSale::find($id);

        if (!$flashSale) {
            return response()->json(['message' => 'Flash sale not found'], 404);
        }

        $flashSale->delete();

        return response()->json(['message' => 'Flash sale deleted successfully'], 200);
    }

    // ==================== FLASH SALES MANAGEMENT ====================
    public function flashSales()
    {
        $flashSales = FlashSale::with('product.game')->latest()->paginate(20);
        return view('admin.flash-sales.index', compact('flashSales'));
    }

    public function createFlashSale()
    {
        $products = Product::with('game')->where('is_active', true)->get();
        return view('admin.flash-sales.create', compact('products'));
    }

    public function storeFlashSale(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'stock' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'is_active' => 'boolean',
        ]);

        $product = Product::find($validated['product_id']);
        $validated['original_price'] = $product->price;
        $validated['discounted_price'] = $product->price * (1 - $validated['discount_percentage'] / 100);
        $validated['is_active'] = $request->has('is_active');

        FlashSale::create($validated);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale berhasil ditambahkan');
    }

    public function editFlashSale($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $products = Product::with('game')->where('is_active', true)->get();
        return view('admin.flash-sales.edit', compact('flashSale', 'products'));
    }

    public function updateFlashSale(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'stock' => 'required|integer|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'is_active' => 'boolean',
        ]);

        $product = Product::find($validated['product_id']);
        $validated['original_price'] = $product->price;
        $validated['discounted_price'] = $product->price * (1 - $validated['discount_percentage'] / 100);
        $validated['is_active'] = $request->has('is_active');

        $flashSale->update($validated);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale berhasil diupdate');
    }

    public function deleteFlashSale($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale berhasil dihapus');
    }

}
