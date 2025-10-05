<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::where('status', 'active');

        if ($request->has('position')) {
            $query->where('position', $request->position);
        }

        $banners = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['data' => $banners], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'sometimes|in:home,promo',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $banner = Banner::create($request->all());

        return response()->json([
            'message' => 'Banner created successfully',
            'data' => $banner
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        $request->validate([
            'title' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'sometimes|in:home,promo',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $banner->update($request->all());

        return response()->json([
            'message' => 'Banner updated successfully',
            'data' => $banner
        ], 200);
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully'], 200);
    }

    // ==================== BANNERS MANAGEMENT ====================
    public function banners()
    {
        $banners = Banner::latest()->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }

    public function createBanner()
    {
        return view('admin.banners.create');
    }

    public function storeBanner(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'link' => 'nullable|url',
            'position' => 'required|in:home,games,flash-sale',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan');
    }

    public function editBanner($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'position' => 'required|in:home,games,flash-sale',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diupdate');
    }

    public function deleteBanner($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus');
    }
}
