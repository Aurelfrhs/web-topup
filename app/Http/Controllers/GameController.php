<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameController extends Controller
{
    // ==================== API ENDPOINTS ====================

    public function index()
    {
        $games = Game::where('is_active', true)->get();
        return response()->json(['data' => $games], 200);
    }

    public function show($id)
    {
        $game = Game::with('products')->find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        return response()->json(['data' => $game], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $game = Game::create($data);

        return response()->json([
            'message' => 'Game created successfully',
            'data' => $game
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'image' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        if ($request->has('is_active')) {
            $data['is_active'] = 1;
        } else {
            $data['is_active'] = 0;
        }

        $game->update($data);

        return response()->json([
            'message' => 'Game updated successfully',
            'data' => $game
        ], 200);
    }

    public function destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $game->delete();

        return response()->json(['message' => 'Game deleted successfully'], 200);
    }

    // ==================== ADMIN PANEL MANAGEMENT ====================

    public function games(Request $request)
    {
        $query = Game::withCount('products');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        $games = $query->latest()->paginate(20);

        return view('admin.games.index', compact('games'));
    }

    public function createGame()
    {
        return view('admin.games.create');
    }

    public function storeGame(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:games,slug',
            'category' => 'required|string|max:100',
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ]);

        // Auto-generate slug if not provided
        if (!$request->has('slug') || empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('games', 'public');
        }

        // PENTING: Set is_active berdasarkan checkbox (1 jika checked, 0 jika tidak)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Game::create($validated);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game berhasil ditambahkan');
    }

    public function editGame($id)
    {
        $game = Game::findOrFail($id);
        return view('admin.games.edit', compact('game'));
    }

    public function updateGame(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:games,slug,' . $id,
            'category' => 'required|string|max:100',
            'publisher' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Auto-generate slug if not provided or empty
        if (!$request->has('slug') || empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($game->image) {
                Storage::disk('public')->delete($game->image);
            }
            $validated['image'] = $request->file('image')->store('games', 'public');
        }

        // PENTING: Set is_active berdasarkan checkbox (1 jika checked, 0 jika tidak)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $game->update($validated);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game berhasil diupdate');
    }

    public function deleteGame($id)
    {
        $game = Game::findOrFail($id);

        // Check if game has products
        if ($game->hasProducts()) {
            return redirect()->route('admin.games.index')
                ->with('error', 'Game tidak dapat dihapus karena masih memiliki produk terkait');
        }

        // Delete image
        if ($game->image) {
            Storage::disk('public')->delete($game->image);
        }

        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', 'Game berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $game = Game::findOrFail($id);

        // Toggle status
        $game->is_active = !$game->is_active;
        $game->save();

        $status = $game->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.games.index')
            ->with('success', "Game berhasil {$status}");
    }

    // ==================== UTILITY METHODS ====================

    /**
     * Get games by category
     */
    public function getByCategory($category)
    {
        $games = Game::active()
            ->byCategory($category)
            ->get();

        return response()->json(['data' => $games], 200);
    }

    /**
     * Get popular games
     */
    public function getPopular($limit = 10)
    {
        $games = Game::active()
            ->popular()
            ->limit($limit)
            ->get();

        return response()->json(['data' => $games], 200);
    }

    /**
     * Search games
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $games = Game::active()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();

        return response()->json(['data' => $games], 200);
    }
}