@extends('layouts.admin')

@section('title', 'Manajemen Orders')
@section('page-title', 'Manajemen Orders')

@section('content')
    <div
        class="space-y-6"
        x-data="orderManager()"
    >

        <!-- Header Section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Transaksi</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua pesanan pelanggan</p>
            </div>
            <div class="flex gap-3">
                <button
                    @click="exportData()"
                    class="inline-flex items-center justify-center rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                >
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Orders</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $orders->total() }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                        <i class="fas fa-shopping-cart text-xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="mt-2 text-3xl font-bold text-yellow-600">
                            {{ $orders->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100">
                        <i class="fas fa-clock text-xl text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Processing</p>
                        <p class="mt-2 text-3xl font-bold text-blue-600">
                            {{ $orders->where('status', 'processing')->count() }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                        <i class="fas fa-sync text-xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Success</p>
                        <p class="mt-2 text-3xl font-bold text-green-600">{{ $orders->where('status', 'success')->count() }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <i class="fas fa-check-circle text-xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Failed</p>
                        <p class="mt-2 text-3xl font-bold text-red-600">{{ $orders->where('status', 'failed')->count() }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                        <i class="fas fa-times-circle text-xl text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form
                method="GET"
                action="{{ route('admin.orders.index') }}"
                class="flex flex-col gap-4 md:flex-row"
            >
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari berdasarkan order number, game user ID..."
                        value="{{ request('search') }}"
                        class="w-full rounded-lg border-2 border-gray-200 py-2 pl-11 pr-4 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                </div>
                <div class="w-full md:w-48">
                    <select
                        name="status"
                        class="w-full rounded-lg border-2 border-gray-200 px-4 py-2 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                        <option value="">🎯 Semua Status</option>
                        <option
                            value="pending"
                            {{ request('status') == 'pending' ? 'selected' : '' }}
                        >Pending</option>
                        <option
                            value="processing"
                            {{ request('status') == 'processing' ? 'selected' : '' }}
                        >Processing</option>
                        <option
                            value="success"
                            {{ request('status') == 'success' ? 'selected' : '' }}
                        >Success</option>
                        <option
                            value="failed"
                            {{ request('status') == 'failed' ? 'selected' : '' }}
                        >Failed</option>
                        <option
                            value="refunded"
                            {{ request('status') == 'refunded' ? 'selected' : '' }}
                        >Refunded</option>
                    </select>
                </div>
                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-6 py-2 font-semibold text-white transition hover:bg-gray-800"
                >
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Order ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Pelanggan
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Produk
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Game User ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Harga
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($orders as $order)
                            <tr class="transition hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">#{{ $order->id }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->order_number ?? 'N/A' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900">{{ $order->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $order->product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->product->game->name ?? 'N/A' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-mono text-sm font-semibold text-gray-900">{{ $order->game_user_id }}
                                    </div>
                                    @if ($order->server_id)
                                        <div class="text-xs text-gray-500">Server: {{ $order->server_id }}</div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-bold text-indigo-600">
                                        Rp {{ number_format($order->amount, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $order->payment_method }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-800',
                                                'icon' => 'fa-clock',
                                            ],
                                            'processing' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'icon' => 'fa-sync',
                                            ],
                                            'success' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-800',
                                                'icon' => 'fa-check-circle',
                                            ],
                                            'failed' => [
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-800',
                                                'icon' => 'fa-times-circle',
                                            ],
                                            'refunded' => [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-800',
                                                'icon' => 'fa-undo',
                                            ],
                                        ];
                                        $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span
                                        class="{{ $config['bg'] }} {{ $config['text'] }} inline-flex items-center rounded-full px-3 py-1 text-xs font-bold"
                                    >
                                        <i class="fas {{ $config['icon'] }} mr-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    <div>{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a
                                            href="{{ route('admin.orders.show', $order->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600 transition hover:bg-blue-200"
                                            title="Detail"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($order->status === 'pending')
                                            <button
                                                @click="processOrder({{ $order->id }})"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-green-100 text-green-600 transition hover:bg-green-200"
                                                title="Process"
                                            >
                                                <i class="fas fa-play"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="8"
                                    class="px-6 py-16 text-center"
                                >
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                                            <i class="fas fa-shopping-cart text-3xl text-gray-300"></i>
                                        </div>
                                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Belum ada transaksi</h3>
                                        <p class="text-sm text-gray-500">Transaksi pelanggan akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
        <script>
            function orderManager() {
                return {
                    processOrder(orderId) {
                        if (confirm('Proses order ini?')) {
                            window.location.href = `/admin/orders/${orderId}/process`;
                        }
                    },

                    exportData() {
                        window.location.href = '{{ route('admin.orders.export') }}';
                    }
                }
            }
        </script>
    @endpush
@endsection
