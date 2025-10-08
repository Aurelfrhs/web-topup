@extends('layouts.admin')

@section('title', 'Kelola Flash Sale')
@section('page-title', 'Kelola Flash Sale')

@section('content')
    <div
        class="space-y-6"
        x-data="flashSaleManager()"
    >

        <!-- Header Actions -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Flash Sale</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua flash sale produk</p>
            </div>
            <a
                href="{{ route('admin.flash-sales.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-red-600 to-pink-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:from-red-700 hover:to-pink-700 hover:shadow-xl"
            >
                <i class="fas fa-bolt mr-2"></i>
                Tambah Flash Sale
            </a>
        </div>

        <!-- Stats Cards -->
        @php
            $now = \Carbon\Carbon::now('Asia/Jakarta');
            $activeCount = $flashSales
                ->filter(function ($fs) use ($now) {
                    return $fs->status === 'active' && $fs->start_time <= $now && $fs->end_time >= $now;
                })
                ->count();

            $upcomingCount = $flashSales
                ->filter(function ($fs) use ($now) {
                    return $fs->status === 'active' && $fs->start_time > $now;
                })
                ->count();

            $expiredCount = $flashSales
                ->filter(function ($fs) use ($now) {
                    return $fs->status === 'inactive' || $fs->end_time < $now;
                })
                ->count();
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Active Flash Sales -->
            <div class="rounded-xl border border-green-200 bg-gradient-to-br from-green-50 to-emerald-50 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Aktif</p>
                        <p class="mt-2 text-3xl font-bold text-green-900">
                            {{ $activeCount }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-500/20">
                        <i class="fas fa-bolt text-xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Upcoming Flash Sales -->
            <div class="rounded-xl border border-blue-200 bg-gradient-to-br from-blue-50 to-indigo-50 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Mendatang</p>
                        <p class="mt-2 text-3xl font-bold text-blue-900">
                            {{ $upcomingCount }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-500/20">
                        <i class="fas fa-clock text-xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Expired Flash Sales -->
            <div class="rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-slate-50 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Berakhir</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            {{ $expiredCount }}
                        </p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-500/20">
                        <i class="fas fa-times-circle text-xl text-gray-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total Flash Sales -->
            <div class="rounded-xl border border-red-200 bg-gradient-to-br from-red-50 to-pink-50 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-600">Total</p>
                        <p class="mt-2 text-3xl font-bold text-red-900">{{ $flashSales->total() }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-500/20">
                        <i class="fas fa-fire text-xl text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form
                method="GET"
                action="{{ route('admin.flash-sales.index') }}"
                class="flex flex-col gap-4 md:flex-row"
            >
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari flash sale berdasarkan produk..."
                        value="{{ request('search') }}"
                        class="w-full rounded-lg border-2 border-gray-200 py-2 pl-11 pr-4 transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                    >
                </div>
                <div class="w-full md:w-56">
                    <select
                        name="status"
                        class="w-full rounded-lg border-2 border-gray-200 px-4 py-2 transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                    >
                        <option value="">⚡ Semua Status</option>
                        <option
                            value="active"
                            {{ request('status') == 'active' ? 'selected' : '' }}
                        >Aktif</option>
                        <option
                            value="upcoming"
                            {{ request('status') == 'upcoming' ? 'selected' : '' }}
                        >Mendatang
                        </option>
                        <option
                            value="expired"
                            {{ request('status') == 'expired' ? 'selected' : '' }}
                        >Berakhir</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="rounded-lg bg-gray-900 px-6 py-2 font-semibold text-white transition hover:bg-gray-800"
                    >
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    @if (request('search') || request('status'))
                        <a
                            href="{{ route('admin.flash-sales.index') }}"
                            class="rounded-lg border-2 border-gray-300 bg-white px-6 py-2 font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            <i class="fas fa-undo mr-2"></i>Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Flash Sales Table -->
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-red-50 to-pink-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Diskon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Harga
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Stok
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Waktu
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($flashSales as $flashSale)
                            @php
                                $now = \Carbon\Carbon::now('Asia/Jakarta');
                                $isActive =
                                    $flashSale->status === 'active' &&
                                    $flashSale->start_time <= $now &&
                                    $flashSale->end_time >= $now;
                                $isUpcoming = $flashSale->status === 'active' && $flashSale->start_time > $now;
                                $isExpired = $flashSale->status === 'inactive' || $flashSale->end_time < $now;
                            @endphp
                            <tr class="transition hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">
                                    #{{ $flashSale->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-600">
                                            <i class="fas fa-bolt"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $flashSale->product->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $flashSale->product->game->name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div
                                        class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-800">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $flashSale->discount_percentage }}%
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-xs text-gray-500 line-through">
                                        Rp {{ number_format($flashSale->original_price ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm font-bold text-red-600">
                                        Rp {{ number_format($flashSale->discounted_price ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        Hemat Rp
                                        {{ number_format(($flashSale->original_price ?? 0) - ($flashSale->discounted_price ?? 0), 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <span class="font-semibold">{{ $flashSale->sold ?? 0 }}</span> /
                                        {{ $flashSale->stock ?? 0 }}
                                    </div>
                                    @php
                                        $percentage =
                                            $flashSale->stock > 0
                                                ? (($flashSale->sold ?? 0) / $flashSale->stock) * 100
                                                : 0;
                                    @endphp
                                    <div class="mt-2 h-2 w-20 overflow-hidden rounded-full bg-gray-200">
                                        <div
                                            class="h-full rounded-full bg-gradient-to-r from-red-500 to-pink-500 transition-all"
                                            style="width: {{ $percentage }}%"
                                        ></div>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">{{ number_format($percentage, 0) }}% terjual
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <div class="text-gray-900">
                                        <i class="fas fa-calendar-alt mr-1 text-xs text-gray-400"></i>
                                        {{ $flashSale->start_time->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $flashSale->start_time->format('H:i') }} -
                                        {{ $flashSale->end_time->format('H:i') }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($isActive)
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800"
                                        >
                                            <span class="mr-1 h-2 w-2 animate-pulse rounded-full bg-green-500"></span>
                                            Aktif
                                        </span>
                                    @elseif($isUpcoming)
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800"
                                        >
                                            <i class="fas fa-clock mr-1"></i>
                                            Mendatang
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-800"
                                        >
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Berakhir
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a
                                            href="{{ route('admin.flash-sales.edit', $flashSale->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600 transition hover:bg-blue-200"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            @click="confirmDelete({{ $flashSale->id }}, '{{ $flashSale->product->name ?? 'Flash Sale' }}')"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-red-100 text-red-600 transition hover:bg-red-200"
                                            title="Hapus"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
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
                                            class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-red-50">
                                            <i class="fas fa-bolt text-3xl text-red-300"></i>
                                        </div>
                                        <h3 class="mb-2 text-lg font-semibold text-gray-900">
                                            @if (request('search') || request('status'))
                                                Tidak ada hasil ditemukan
                                            @else
                                                Belum ada flash sale
                                            @endif
                                        </h3>
                                        <p class="mb-4 text-sm text-gray-500">
                                            @if (request('search') || request('status'))
                                                Coba ubah filter atau kata kunci pencarian
                                            @else
                                                Mulai tambahkan flash sale untuk meningkatkan penjualan
                                            @endif
                                        </p>
                                        @if (request('search') || request('status'))
                                            <a
                                                href="{{ route('admin.flash-sales.index') }}"
                                                class="inline-flex items-center rounded-lg border-2 border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                            >
                                                <i class="fas fa-undo mr-2"></i>
                                                Reset Filter
                                            </a>
                                        @else
                                            <a
                                                href="{{ route('admin.flash-sales.create') }}"
                                                class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                                            >
                                                <i class="fas fa-plus mr-2"></i>
                                                Tambah Flash Sale Pertama
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($flashSales->hasPages())
                <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                    {{ $flashSales->links() }}
                </div>
            @endif
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            x-show="deleteModal.open"
            x-cloak
            @click.self="deleteModal.open = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div
                class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                @click.stop
            >
                <!-- Header -->
                <div class="bg-gradient-to-r from-red-600 to-pink-600 p-6">
                    <div class="flex items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/20 backdrop-blur">
                            <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                        </div>
                        <div class="ml-4 text-white">
                            <h3 class="text-2xl font-bold">Konfirmasi Penghapusan</h3>
                            <p class="text-sm text-red-100">Tindakan ini tidak dapat dibatalkan</p>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                        <p class="mb-3 text-gray-900">
                            Anda akan menghapus flash sale:
                        </p>
                        <div class="rounded-lg border border-red-200 bg-white p-3">
                            <p
                                class="font-bold text-gray-900"
                                x-text="deleteModal.flashSaleName"
                            ></p>
                            <p class="text-sm text-gray-600">ID: #<span x-text="deleteModal.flashSaleId"></span></p>
                        </div>
                    </div>

                    <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4">
                        <div class="flex">
                            <i class="fas fa-info-circle mr-3 mt-0.5 text-yellow-600"></i>
                            <div>
                                <p class="font-semibold text-yellow-900">Perhatian</p>
                                <p class="text-sm text-yellow-800">Flash sale akan dihapus permanen dari sistem</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex gap-3 border-t border-gray-200 bg-gray-50 p-6">
                    <button
                        @click="deleteModal.open = false"
                        class="flex-1 rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50"
                    >
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button
                        @click="executeDelete()"
                        class="flex-1 rounded-lg bg-red-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-red-700"
                    >
                        <i class="fas fa-trash-alt mr-2"></i>
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>

        <!-- Hidden form for deletion -->
        <form
            :action="`{{ route('admin.flash-sales.index') }}/${deleteModal.flashSaleId}`"
            method="POST"
            x-ref="deleteForm"
        >
            @csrf
            @method('DELETE')
        </form>

    </div>

    @push('scripts')
        <script>
            function flashSaleManager() {
                return {
                    deleteModal: {
                        open: false,
                        flashSaleId: null,
                        flashSaleName: ''
                    },

                    confirmDelete(flashSaleId, flashSaleName) {
                        this.deleteModal.flashSaleId = flashSaleId;
                        this.deleteModal.flashSaleName = flashSaleName;
                        this.deleteModal.open = true;
                    },

                    executeDelete() {
                        this.$refs.deleteForm.submit();
                    }
                }
            }
        </script>
    @endpush
@endsection
