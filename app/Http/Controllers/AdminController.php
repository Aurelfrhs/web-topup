<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Models\Product;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\News;
use App\Models\Banner;
use App\Models\FlashSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ==================== DASHBOARD ====================
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'success')->sum('total_price'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_games' => Game::count(),
            'total_products' => Product::count(),
            'pending_deposits' => Deposit::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with(['user', 'product.game'])
            ->latest()
            ->take(10)
            ->get();

        $recentDeposits = Deposit::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentDeposits'));
    }

    // // ==================== REPORTS & ANALYTICS ====================
    // public function salesReport(Request $request)
    // {
    //     $startDate = $request->get('start_date', now()->startOfMonth());
    //     $endDate = $request->get('end_date', now()->endOfMonth());

    //     $orders = Order::where('status', 'success')
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->with(['product.game', 'user'])
    //         ->get();

    //     $stats = [
    //         'total_orders' => $orders->count(),
    //         'total_revenue' => $orders->sum('total_price'),
    //         'average_order' => $orders->avg('total_price'),
    //     ];

    //     return view('admin.reports.sales', compact('orders', 'stats', 'startDate', 'endDate'));
    // }

    // public function revenueReport(Request $request)
    // {
    //     $startDate = $request->get('start_date', now()->startOfMonth());
    //     $endDate = $request->get('end_date', now()->endOfMonth());

    //     $revenue = Order::where('status', 'success')
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->selectRaw('DATE(created_at) as date, SUM(total_price) as total, COUNT(*) as count')
    //         ->groupBy('date')
    //         ->orderBy('date', 'asc')
    //         ->get();

    //     return view('admin.reports.revenue', compact('revenue', 'startDate', 'endDate'));
    // }

    // public function usersReport(Request $request)
    // {
    //     $startDate = $request->get('start_date', now()->startOfMonth());
    //     $endDate = $request->get('end_date', now()->endOfMonth());

    //     $newUsers = User::whereBetween('created_at', [$startDate, $endDate])
    //         ->where('role', 'user')
    //         ->get();

    //     $stats = [
    //         'new_users' => $newUsers->count(),
    //         'total_users' => User::where('role', 'user')->count(),
    //         'users_with_orders' => User::whereHas('orders')->count(),
    //     ];

    //     return view('admin.reports.users', compact('newUsers', 'stats', 'startDate', 'endDate'));
    // }

    // public function exportReport(Request $request)
    // {
    //     // Implement export logic (CSV/Excel)
    //     // You can use Laravel Excel package for this

    //     return back()->with('success', 'Report berhasil diexport');
    // }
}