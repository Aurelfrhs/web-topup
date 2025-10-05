<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'phone.required' => 'No. WhatsApp wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::create([
            'username' => $request->name, // Gunakan name sebagai username
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'balance' => 0,
            'membership' => 'basic',
            'role' => 'user',
        ]);

        // Auto login setelah register
        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Selamat datang.'
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_admin' => $user->role === 'admin'
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah'
        ], 401);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logout berhasil');
    }

    // Get Profile
    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
}