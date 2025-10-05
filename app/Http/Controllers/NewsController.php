<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $news], 200);
    }

    public function show($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        return response()->json(['data' => $news], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $news = News::create($request->all());

        return response()->json([
            'message' => 'News created successfully',
            'data' => $news
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|string|max:150',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $news->update($request->all());

        return response()->json([
            'message' => 'News updated successfully',
            'data' => $news
        ], 200);
    }

    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        $news->delete();

        return response()->json(['message' => 'News deleted successfully'], 200);
    }

    // ==================== NEWS MANAGEMENT ====================
    public function newsList()
    {
        $news = News::latest()->paginate(20);
        return view('admin.news.index', compact('news'));
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:news,slug',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if (!$request->has('slug') || empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News berhasil ditambahkan');
    }

    public function editNews($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function updateNews(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:news,slug,' . $id,
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if (!$request->has('slug') || empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News berhasil diupdate');
    }

    public function deleteNews($id)
    {
        $news = News::findOrFail($id);

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News berhasil dihapus');
    }
}
