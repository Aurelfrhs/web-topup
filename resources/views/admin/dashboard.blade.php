@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">

        <!-- Welcome Section -->
        <div class="rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="mb-2 text-2xl font-bold">Selamat Datang, {{ auth()->user()->username ?? 'Admin' }}! 👋</h2>
                    <p class="text-indigo-100">Berikut adalah ringkasan aktivitas toko Anda hari ini</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-chart-line text-6xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Pendapatan -->
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-medium text-gray-600">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold text-gray-900">Rp
                            {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</h3>
                        <p class="mt-2 text-sm text-green-600">
                            <i class="fas fa-arrow-up"></i> Hari ini
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                        <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-medium text-gray-600">Total Transaksi</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ number_format($stats['total_orders'] ?? 0, 0, ',', '.') }}</h3>
                        <p class="mt-2 text-sm text-blue-600">
                            <i class="fas fa-shopping-cart"></i> Semua waktu
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                        <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total Pengguna -->
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-medium text-gray-600">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ number_format($stats['total_users'] ?? 0, 0, ',', '.') }}</h3>
                        <p class="mt-2 text-sm text-purple-600">
                            <i class="fas fa-users"></i> User terdaftar
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100">
                        <i class="fas fa-users text-2xl text-purple-600"></i>
                    </div>
                </div>
            </div>

            <!-- Transaksi Pending -->
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-medium text-gray-600">Transaksi Pending</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ number_format($stats['pending_orders'] ?? 0, 0, ',', '.') }}</h3>
                        <p class="mt-2 text-sm text-orange-600">
                            <i class="fas fa-clock"></i> Perlu ditinjau
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100">
                        <i class="fas fa-hourglass-half text-2xl text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Tables Row -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Revenue Chart -->
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Grafik Pendapatan</h3>
                    <select
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <option>7 Hari Terakhir</option>
                        <option>30 Hari Terakhir</option>
                        <option>3 Bulan Terakhir</option>
                    </select>
                </div>
                <div class="flex h-64 items-end justify-between space-x-2">
                    @php
                        $chartData = [65, 45, 78, 52, 88, 95, 72];
                        $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                    @endphp
                    @foreach ($chartData as $index => $value)
                        <div class="group flex flex-1 flex-col items-center">
                            <div
                                class="relative w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-indigo-400 transition-all duration-300 hover:from-indigo-700 hover:to-indigo-500"
                                style="height: {{ $value }}%"
                            >
                                <span
                                    class="absolute -top-6 left-1/2 -translate-x-1/2 transform text-xs font-semibold text-gray-700 opacity-0 transition group-hover:opacity-100"
                                >
                                    {{ $value }}%
                                </span>
                            </div>
                            <span class="mt-2 text-xs text-gray-600">{{ $days[$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Status -->
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h3 class="mb-6 text-lg font-semibold text-gray-900">Status Produk</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between rounded-lg bg-green-50 p-3">
                        <div class="flex items-center space-x-3">
                            <div class="h-2 w-2 rounded-full bg-green-500"></div>
                            <span class="text-sm font-medium text-gray-700">Aktif</span>
                        </div>
                        <span class="text-lg font-bold text-green-600">{{ $stats['total_products'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-orange-50 p-3">
                        <div class="flex items-center space-x-3">
                            <div class="h-2 w-2 rounded-full bg-orange-500"></div>
                            <span class="text-sm font-medium text-gray-700">Total Games</span>
                        </div>
                        <span class="text-lg font-bold text-orange-600">{{ $stats['total_games'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-blue-50 p-3">
                        <div class="flex items-center space-x-3">
                            <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                            <span class="text-sm font-medium text-gray-700">Deposit Pending</span>
                        </div>
                        <span class="text-lg font-bold text-blue-600">{{ $stats['pending_deposits'] ?? 0 }}</span>
                    </div>
                </div>
                <a
                    href="{{ route('admin.products.index') }}"
                    class="mt-4 block text-center text-sm font-medium text-indigo-600 hover:text-indigo-700"
                >
                    Kelola Produk <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Recent Transactions & Top Products -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <!-- Recent Transactions -->
            <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                        >
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentOrders ?? [] as $order)
                        <div class="p-4 transition hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $order->product->name ?? 'N/A' }}</p>
                                    <p class="mt-1 text-sm text-gray-500">{{ $order->user->username ?? 'Guest' }}</p>
                                </div>
                                <div class="ml-4 text-right">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($order->amount, 0, ',', '.') }}</p>
                                    @if ($order->status === 'success')
                                        <span
                                            class="mt-1 inline-block rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700"
                                        >
                                            Sukses
                                        </span>
                                    @elseif($order->status === 'pending')
                                        <span
                                            class="mt-1 inline-block rounded-full bg-orange-100 px-2 py-1 text-xs font-medium text-orange-700"
                                        >
                                            Pending
                                        </span>
                                    @elseif($order->status === 'processing')
                                        <span
                                            class="mt-1 inline-block rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700"
                                        >
                                            Diproses
                                        </span>
                                    @else
                                        <span
                                            class="mt-1 inline-block rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700"
                                        >
                                            Gagal
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-inbox mb-3 text-4xl text-gray-300"></i>
                            <p>Belum ada transaksi</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Deposits -->
            <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Deposit Terbaru</h3>
                        <a
                            href="{{ route('admin.deposits.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                        >
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentDeposits ?? [] as $deposit)
                        <div class="p-4 transition hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $deposit->user->username ?? 'N/A' }}</p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $deposit->payment_method ?? 'Transfer Bank' }}</p>
                                </div>
                                <div class="ml-4 text-right">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($deposit->amount, 0, ',', '.') }}</p>
                                    @if ($deposit->status === 'approved')
                                        <span
                                            class="mt-1 inline-block rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700"
                                        >
                                            Approved
                                        </span>
                                    @elseif($deposit->status === 'pending')
                                        <span
                                            class="mt-1 inline-block rounded-full bg-orange-100 px-2 py-1 text-xs font-medium text-orange-700"
                                        >
                                            Pending
                                        </span>
                                    @else
                                        <span
                                            class="mt-1 inline-block rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700"
                                        >
                                            Rejected
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-wallet mb-3 text-4xl text-gray-300"></i>
                            <p>Belum ada deposit</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <a
                    href="{{ route('admin.products.create') }}"
                    class="group flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-4 transition hover:border-indigo-500 hover:bg-indigo-50"
                >
                    <div
                        class="mb-3 flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 transition group-hover:bg-indigo-200">
                        <i class="fas fa-plus text-xl text-indigo-600"></i>
                    </div>
                    <span class="text-center text-sm font-medium text-gray-700">Tambah Produk</span>
                </a>

                <a
                    href="{{ route('admin.flash-sales.create') }}"
                    class="group flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-4 transition hover:border-orange-500 hover:bg-orange-50"
                >
                    <div
                        class="mb-3 flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100 transition group-hover:bg-orange-200">
                        <i class="fas fa-bolt text-xl text-orange-600"></i>
                    </div>
                    <span class="text-center text-sm font-medium text-gray-700">Buat Flash Sale</span>
                </a>

                <a
                    href="{{ route('admin.news.create') }}"
                    class="group flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-4 transition hover:border-green-500 hover:bg-green-50"
                >
                    <div
                        class="mb-3 flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 transition group-hover:bg-green-200">
                        <i class="fas fa-newspaper text-xl text-green-600"></i>
                    </div>
                    <span class="text-center text-sm font-medium text-gray-700">Tulis Berita</span>
                </a>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="group flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-4 transition hover:border-purple-500 hover:bg-purple-50"
                >
                    <div
                        class="mb-3 flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 transition group-hover:bg-purple-200">
                        <i class="fas fa-eye text-xl text-purple-600"></i>
                    </div>
                    <span class="text-center text-sm font-medium text-gray-700">Lihat Transaksi</span>
                </a>
            </div>
        </div>

    </div>
@endsection
