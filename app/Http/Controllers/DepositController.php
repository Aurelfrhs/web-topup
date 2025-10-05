<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function index()
    {
        $query = Deposit::with('user');

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $deposits = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['data' => $deposits], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'method' => 'required|string|max:50',
            'amount' => 'required|numeric|min:10000',
        ]);

        $deposit = Deposit::create([
            'user_id' => Auth::id(),
            // 'method' => $request->method,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Deposit request created successfully',
            'data' => $deposit
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,success,failed',
        ]);

        $deposit = Deposit::find($id);

        if (!$deposit) {
            return response()->json(['message' => 'Deposit not found'], 404);
        }

        DB::beginTransaction();
        try {
            $deposit->status = $request->status;
            $deposit->save();

            // Add balance if success
            if ($request->status === 'success') {
                $user = User::find($deposit->user_id);
                $user->balance += $deposit->amount;
                $user->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Deposit status updated successfully',
                'data' => $deposit
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Update failed', 'error' => $e->getMessage()], 500);
        }
    }

    // ==================== DEPOSITS MANAGEMENT ====================
    public function deposits(Request $request)
    {
        $query = Deposit::with('user');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $deposits = $query->latest()->paginate(20);

        return view('admin.deposits.index', compact('deposits'));
    }

    public function depositDetail($id)
    {
        $deposit = Deposit::with('user')->findOrFail($id);
        return view('admin.deposits.show', compact('deposit'));
    }

    public function approveDeposit(Request $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'Deposit sudah diproses');
        }

        $deposit->update(['status' => 'approved']);

        // Add balance to user
        $user = $deposit->user;
        $user->balance += $deposit->amount;
        $user->save();

        return back()->with('success', 'Deposit berhasil diapprove dan balance ditambahkan');
    }

    public function rejectDeposit(Request $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'Deposit sudah diproses');
        }

        $validated = $request->validate([
            'rejection_reason' => 'nullable|string',
        ]);

        $deposit->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        return back()->with('success', 'Deposit berhasil ditolak');
    }
}
