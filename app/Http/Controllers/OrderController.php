<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ==================== ADMIN ORDERS MANAGEMENT ====================

    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'product.game']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('game_user_id', 'like', "%{$search}%")
                    ->orWhere('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by game
        if ($request->has('game_id') && $request->game_id) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('game_id', $request->game_id);
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with(['user', 'product.game'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,success,failed,refunded',
            'note' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($id);

        DB::beginTransaction();
        try {
            // Store old status
            $oldStatus = $order->status;

            // Update order
            $order->status = $validated['status'];
            if (isset($validated['note'])) {
                $order->note = $validated['note'];
            }
            $order->save();

            // Handle refund for failed or refunded orders
            if (
                in_array($validated['status'], ['failed', 'refunded']) &&
                !in_array($oldStatus, ['failed', 'refunded'])
            ) {
                $user = User::find($order->user_id);
                $user->balance += $order->amount;
                $user->save();
            }

            DB::commit();

            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('success', 'Status order berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    /**
     * Process order (change status to processing)
     */
    public function process($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order sudah diproses sebelumnya');
        }

        $order->update(['status' => 'processing']);

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Order sedang diproses');
    }

    /**
     * Export orders data
     */
    public function export(Request $request)
    {
        // Implement export logic here (CSV, Excel, PDF)
        // This is a placeholder
        return back()->with('info', 'Fitur export akan segera hadir');
    }

    // ==================== API ENDPOINTS (for customer) ====================

    /**
     * Get orders list (API)
     */
    public function apiIndex(Request $request)
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

    /**
     * Get single order (API)
     */
    public function apiShow($id)
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

    /**
     * Create new order (API)
     */
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

        // Check if product is active
        if (!$product->is_active) {
            return response()->json(['message' => 'Produk tidak tersedia'], 400);
        }

        // Check stock
        if ($product->stock !== null && $product->stock < 1) {
            return response()->json(['message' => 'Stok produk habis'], 400);
        }

        // Check balance
        if ($user->balance < $product->price) {
            return response()->json(['message' => 'Saldo tidak mencukupi'], 400);
        }

        DB::beginTransaction();
        try {
            // Generate order number
            $orderNumber = 'ORD-' . date('YmdHis') . '-' . strtoupper(substr(uniqid(), -4));

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'order_number' => $orderNumber,
                'game_user_id' => $request->game_user_id,
                'server_id' => $request->server_id,
                'payment_method' => $request->payment_method,
                'amount' => $product->price,
                'status' => 'pending',
            ]);

            // Deduct balance
            $user->balance -= $product->price;
            $user->save();

            // Reduce stock if limited
            if ($product->stock !== null) {
                $product->stock -= 1;
                $product->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Order berhasil dibuat',
                'data' => $order->load(['user', 'product'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}