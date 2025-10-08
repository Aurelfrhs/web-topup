<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Game;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('game')->where('is_active', true);

        if ($request->has('game_id')) {
            $query->where('game_id', $request->game_id);
        }

        $products = $query->get();

        return response()->json(['data' => $products], 200);
    }

    public function show($id)
    {
        $product = Product::with('game')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['data' => $product], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'game_id' => 'sometimes|exists:games,id',
            'name' => 'sometimes|string|max:100',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $data = $request->all();
        if ($request->has('is_active')) {
            $data['is_active'] = 1;
        } else {
            $data['is_active'] = 0;
        }

        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    // ==================== PRODUCTS MANAGEMENT ====================
    public function products(Request $request)
    {
        $query = Product::with('game');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by game
        if ($request->filled('game_id')) {
            $query->where('game_id', $request->game_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        $products = Product::with('game')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $games = Game::where('is_active', true)->get();
        return view('admin.products.create', compact('games'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        // PENTING: Set is_active berdasarkan checkbox (1 jika checked, 0 jika tidak)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle stock: jika unlimited, set null
        if ($request->input('stock_type') === 'unlimited') {
            $validated['stock'] = null;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product berhasil ditambahkan');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $games = Game::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'games'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        // PENTING: Set is_active berdasarkan checkbox (1 jika checked, 0 jika tidak)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle stock: jika unlimited, set null
        if ($request->input('stock_type') === 'unlimited') {
            $validated['stock'] = null;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product berhasil diupdate');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        // Toggle status
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.products.index')
            ->with('success', "Product berhasil {$status}");
    }
}