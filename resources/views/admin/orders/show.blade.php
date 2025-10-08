@extends('layouts.admin')

@section('title', 'Detail Order #' . $order->id)
@section('page-title', 'Detail Order')

@section('content')
    <div class="space-y-6" x-data="orderDetail()">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="transition hover:text-indigo-600">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('admin.orders.index') }}" class="transition hover:text-indigo-600">Orders</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="font-medium text-gray-900">Detail #{{ $order->id }}</span>
        </nav>

        <!-- Header Section -->
        <div class="rounded-xl border border-indigo-100 bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <div class="mb-2 inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-sm backdrop-blur">
                        <i class="fas fa-receipt mr-2"></i>
                        Order Detail
                    </div>
                    <h1 class="mb-2 text-3xl font-bold">Order #{{ $order->id }}</h1>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span><i class="fas fa-calendar mr-1"></i>{{ $order->created_at->format('d M Y H:i') }}</span>
                        <span><i class="fas fa-user mr-1"></i>{{ $order->user->name }}</span>
                    </div>
                </div>
                <a
                    href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border-2 border-white bg-white/10 px-6 py-3 font-semibold backdrop-blur transition hover:bg-white/20"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

            <!-- Main Content -->
            <div class="space-y-6 xl:col-span-8">

                <!-- Order Information -->
                <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                    <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                        <h2 class="flex items-center text-lg font-semibold text-gray-900">
                            <span class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                <i class="fas fa-info-circle text-sm"></i>
                            </span>
                            Informasi Order
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <p class="mb-2 text-sm font-medium text-gray-600">Order Number</p>
                                <p class="text-lg font-bold text-gray-900">{{ $order->order_number ?? 'N/A' }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <p class="mb-2 text-sm font-medium text-gray-600">Status</p>
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'fa-clock'],
                                        'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-sync'],
                                        'success' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle'],
                                        'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-times-circle'],
                                        'refunded' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-undo'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                @endphp
                                <span class="inline-flex items-center rounded-full {{ $config['bg'] }} {{ $config['text'] }} px-4 py-2 text-sm font-bold">
                                    <i class="fas {{ $config['icon'] }} mr-2"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <p class="mb-2 text-sm font-medium text-gray-600">Game User ID</p>
                                <p class="font-mono text-lg font-bold text-gray-900">{{ $order->game_user_id }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <p class="mb-2 text-sm font-medium text-gray-600">Server ID</p>
                                <p class="font-mono text-lg font-bold text-gray-900">{{ $order->server_id ?? '-' }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <p class="mb-2 text-sm font-medium text-gray-600">Payment Method</p>
                                <p class="text-lg font-bold text-gray-900">{{ $order->payment_method }}</p>
                            </div>
                            <div class="rounded-lg border border-indigo-200 bg-indigo-50 p-4">
                                <p class="mb-2 text-sm font-medium text-indigo-600">Total Amount</p>
                                <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        @if($order->canBeRefunded())
                            <button
                                @click="showRefundModal = true"
                                class="flex w-full items-center justify-center rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                <i class="fas fa-undo mr-2"></i>
                                Refund
                            </button>
                        @endif

                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="flex w-full items-center justify-center rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                    <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                        <h3 class="font-semibold text-gray-900">
                            <i class="fas fa-history mr-2 text-purple-600"></i>
                            Timeline Order
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                                        <i class="fas fa-plus text-sm text-green-600"></i>
                                    </div>
                                    <div class="h-full w-0.5 bg-gray-200"></div>
                                </div>
                                <div class="flex-1 pb-4">
                                    <p class="font-semibold text-gray-900">Order Created</p>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            @if($order->status !== 'pending')
                                <div class="flex gap-3">
                                    <div class="flex flex-col items-center">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
                                            <i class="fas fa-sync text-sm text-blue-600"></i>
                                        </div>
                                        @if($order->status !== 'processing')
                                            <div class="h-full w-0.5 bg-gray-200"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 pb-4">
                                        <p class="font-semibold text-gray-900">Processing</p>
                                        <p class="text-sm text-gray-600">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if(in_array($order->status, ['success', 'failed', 'refunded']))
                                <div class="flex gap-3">
                                    <div class="flex flex-col items-center">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full 
                                            {{ $order->status === 'success' ? 'bg-green-100' : 'bg-red-100' }}">
                                            <i class="fas {{ $order->status === 'success' ? 'fa-check' : 'fa-times' }} text-sm 
                                                {{ $order->status === 'success' ? 'text-green-600' : 'text-red-600' }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ ucfirst($order->status) }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                    <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                        <h3 class="font-semibold text-gray-900">
                            <i class="fas fa-file-invoice mr-2 text-orange-600"></i>
                            Ringkasan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Biaya Admin</span>
                                <span class="font-semibold text-gray-900">Rp 0</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Update Status Modal (Success) -->
        <div
            x-show="showUpdateModal"
            x-cloak
            @click.self="showUpdateModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm"
        >
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl" @click.stop>
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6">
                    <div class="flex items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/20 backdrop-blur">
                            <i class="fas fa-check-circle text-2xl text-white"></i>
                        </div>
                        <div class="ml-4 text-white">
                            <h3 class="text-2xl font-bold">Konfirmasi Sukses</h3>
                            <p class="text-sm text-green-100">Tandai order sebagai sukses</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="success">

                    <div class="mb-6">
                        <label for="note_success" class="mb-2 block text-sm font-semibold text-gray-700">
                            Catatan (Opsional)
                        </label>
                        <textarea
                            id="note_success"
                            name="note"
                            rows="3"
                            placeholder="Tambahkan catatan jika diperlukan..."
                            class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 transition focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"
                        ></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="button"
                            @click="showUpdateModal = false"
                            class="flex-1 rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="flex-1 rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700"
                        >
                            <i class="fas fa-check mr-2"></i>
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Fail Status Modal -->
        <div
            x-show="showFailModal"
            x-cloak
            @click.self="showFailModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm"
        >
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl" @click.stop>
                <div class="bg-gradient-to-r from-red-600 to-pink-600 p-6">
                    <div class="flex items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/20 backdrop-blur">
                            <i class="fas fa-times-circle text-2xl text-white"></i>
                        </div>
                        <div class="ml-4 text-white">
                            <h3 class="text-2xl font-bold">Konfirmasi Gagal</h3>
                            <p class="text-sm text-red-100">Tandai order sebagai gagal</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="failed">

                    <div class="mb-6">
                        <label for="note_fail" class="mb-2 block text-sm font-semibold text-gray-700">
                            Alasan Gagal <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="note_fail"
                            name="note"
                            rows="3"
                            required
                            placeholder="Jelaskan alasan order gagal..."
                            class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                        ></textarea>
                    </div>

                    <div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 p-4">
                        <div class="flex">
                            <i class="fas fa-info-circle mr-3 mt-0.5 text-yellow-600"></i>
                            <div>
                                <p class="text-sm font-semibold text-yellow-900">Informasi</p>
                                <p class="mt-1 text-xs text-yellow-800">Saldo pelanggan akan dikembalikan secara otomatis</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="button"
                            @click="showFailModal = false"
                            class="flex-1 rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="flex-1 rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Refund Modal -->
        <div
            x-show="showRefundModal"
            x-cloak
            @click.self="showRefundModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm"
        >
            <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl" @click.stop>
                <div class="bg-gradient-to-r from-gray-600 to-slate-600 p-6">
                    <div class="flex items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/20 backdrop-blur">
                            <i class="fas fa-undo text-2xl text-white"></i>
                        </div>
                        <div class="ml-4 text-white">
                            <h3 class="text-2xl font-bold">Konfirmasi Refund</h3>
                            <p class="text-sm text-gray-100">Kembalikan dana ke pelanggan</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="refunded">

                    <div class="mb-6">
                        <label for="note_refund" class="mb-2 block text-sm font-semibold text-gray-700">
                            Alasan Refund <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="note_refund"
                            name="note"
                            rows="3"
                            required
                            placeholder="Jelaskan alasan refund..."
                            class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 transition focus:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-100"
                        ></textarea>
                    </div>

                    <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <div class="flex">
                            <i class="fas fa-info-circle mr-3 mt-0.5 text-blue-600"></i>
                            <div>
                                <p class="text-sm font-semibold text-blue-900">Informasi Refund</p>
                                <p class="mt-1 text-xs text-blue-800">Dana Rp {{ number_format($order->amount, 0, ',', '.') }} akan dikembalikan ke saldo pelanggan</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button
                            type="button"
                            @click="showRefundModal = false"
                            class="flex-1 rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="flex-1 rounded-lg bg-gray-600 px-6 py-3 font-semibold text-white transition hover:bg-gray-700"
                        >
                            <i class="fas fa-undo mr-2"></i>
                            Proses Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function orderDetail() {
                return {
                    showUpdateModal: false,
                    showFailModal: false,
                    showRefundModal: false
                }
            }
        </script>
    @endpush
@endsection