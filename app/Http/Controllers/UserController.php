<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'username' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'membership' => 'sometimes|in:basic,gold,platinum',
        ]);

        $user->update($request->only(['username', 'email', 'phone', 'membership']));

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }

    public function updateBalance(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:add,subtract',
        ]);

        if ($request->type === 'add') {
            $user->balance += $request->amount;
        } else {
            if ($user->balance < $request->amount) {
                return response()->json(['message' => 'Insufficient balance'], 400);
            }
            $user->balance -= $request->amount;
        }

        $user->save();

        return response()->json([
            'message' => 'Balance updated successfully',
            'balance' => $user->balance
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // ==================== USERS MANAGEMENT ====================
    public function users()
    {
        $users = User::where('role', 'user')
            ->withCount('orders')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:20',
            'balance' => 'nullable|numeric|min:0',
            'membership' => 'required|in:basic,gold,platinum',
            'role' => 'required|in:user,admin',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['balance'] = $validated['balance'] ?? 0;

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'phone' => 'nullable|string|max:20',
            'balance' => 'nullable|numeric|min:0',
            'membership' => 'required|in:basic,gold,platinum',
            'role' => 'required|in:user,admin',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus admin');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    // public function updateBalance(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $validated = $request->validate([
    //         'amount' => 'required|numeric',
    //         'type' => 'required|in:add,subtract',
    //     ]);

    //     if ($validated['type'] === 'add') {
    //         $user->balance += $validated['amount'];
    //     } else {
    //         $user->balance -= $validated['amount'];
    //     }

    //     $user->save();

    //     return back()->with('success', 'Balance berhasil diupdate');
    // }
}