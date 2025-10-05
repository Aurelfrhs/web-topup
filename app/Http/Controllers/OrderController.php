<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'product']);

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['data' => $orders], 200);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'product'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Check authorization
        if (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $order], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'game_user_id' => 'required|string|max:100',
            'server_id' => 'nullable|string|max:100',
            'payment_method' => 'required|string|max:50',
        ]);

        $product = Product::find($request->product_id);
        $user = Auth::user();

        // Check balance
        if ($user->balance < $product->price) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'game_user_id' => $request->game_user_id,
                'server_id' => $request->server_id,
                'payment_method' => $request->payment_method,
                'amount' => $product->price,
                'status' => 'pending',
            ]);

            // Deduct balance
            $user->balance -= $product->price;
            $user->save();

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,success,failed,refunded',
            'note' => 'nullable|string|max:255',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        DB::beginTransaction();
        try {
            $order->status = $request->status;
            $order->note = $request->note;
            $order->save();

            // Refund if failed or refunded
            if (in_array($request->status, ['failed', 'refunded'])) {
                $user = User::find($order->user_id);
                $user->balance += $order->amount;
                $user->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Order status updated successfully',
                'data' => $order
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Update failed', 'error' => $e->getMessage()], 500);
        }
    }

    // ==================== ORDERS MANAGEMENT ====================
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'product.game']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::with(['user', 'product.game'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);

    //     $validated = $request->validate([
    //         'status' => 'required|in:pending,processing,success,failed',
    //     ]);

    //     $order->update($validated);

    //     return back()->with('success', 'Status order berhasil diupdate');
    // }

    public function processOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order sudah diproses');
        }

        $order->update(['status' => 'processing']);

        // Add your payment processing logic here

        return back()->with('success', 'Order sedang diproses');
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
