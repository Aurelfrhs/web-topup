<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Game;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('game')->where('status', 'active');

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
            'type' => 'sometimes|in:auto,manual',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $product = Product::create($request->all());

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
            'type' => 'sometimes|in:auto,manual',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $product->update($request->all());

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
    public function products()
    {
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
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

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
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

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
}