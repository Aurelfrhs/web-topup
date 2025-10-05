<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::where('status', 'active')->get();
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
            'status' => 'sometimes|in:active,inactive',
        ]);

        $game = Game::create($request->all());

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
            'status' => 'sometimes|in:active,inactive',
        ]);

        $game->update($request->all());

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

    // ==================== GAMES MANAGEMENT ====================
    public function games()
    {
        $games = Game::withCount('products')->latest()->paginate(20);
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if (!$request->has('slug') || empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('games', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

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
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if (!$request->has('slug') || empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            if ($game->image) {
                Storage::disk('public')->delete($game->image);
            }
            $validated['image'] = $request->file('image')->store('games', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $game->update($validated);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game berhasil diupdate');
    }

    public function deleteGame($id)
    {
        $game = Game::findOrFail($id);

        if ($game->image) {
            Storage::disk('public')->delete($game->image);
        }

        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', 'Game berhasil dihapus');
    }
}
