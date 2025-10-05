<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return response()->json(['data' => $settings], 200);
    }

    public function show($name)
    {
        $setting = Setting::where('name', $name)->first();

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return response()->json(['data' => $setting], 200);
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        $request->validate([
            'value' => 'required|string',
        ]);

        $setting->value = $request->value;
        $setting->save();

        return response()->json([
            'message' => 'Setting updated successfully',
            'data' => $setting
        ], 200);
    }

    // ==================== SETTINGS MANAGEMENT ====================
    public function settings()
    {
        // Implement settings logic based on your requirements
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        // Implement settings update logic
        return back()->with('success', 'Settings berhasil diupdate');
    }
}