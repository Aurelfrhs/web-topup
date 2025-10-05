@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')
    <div
        class="space-y-6"
        x-data="bannerManager()"
    >

        <!-- Header Actions -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Produk</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola semua produk game yang tersedia</p>
            </div>
            <a
                href="{{ route('admin.banners.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl"
            >
                <i class="fas fa-plus mr-2"></i>
                Tambah Produk
            </a>
        </div>

        <!-- Filter & Search -->
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form
                method="GET"
                action="{{ route('admin.banners.index') }}"
                class="flex flex-col gap-4 md:flex-row"
            >
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari produk berdasarkan nama..."
                        value="{{ request('search') }}"
                        class="w-full rounded-lg border-2 border-gray-200 py-2 pl-11 pr-4 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                </div>
                <div class="w-full md:w-56">
                    <select
                        name="game_id"
                        class="w-full rounded-lg border-2 border-gray-200 px-4 py-2 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                        <option value="">🎮 Semua Game</option>
                        @foreach (\App\Models\Game::where('is_active', true)->get() as $game)
                            <option
                                value="{{ $game->id }}"
                                {{ request('game_id') == $game->id ? 'selected' : '' }}
                            >
                                {{ $game->name }}
                            </option>
                        @endforeach
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

        <!-- banners Table -->
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Game
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Nama Produk
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Harga
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Stok
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($banners as $banner)
                            <tr class="transition hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">
                                    #{{ $banner->id }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                            <i class="fas fa-gamepad"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $banner->game->name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $banner->name }}</div>
                                    @if ($banner->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($banner->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-bold text-indigo-600">
                                        Rp {{ number_format($banner->price, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($banner->stock)
                                        <span
                                            class="{{ $banner->stock < 10 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                                        >
                                            <i class="fas fa-box mr-1"></i>
                                            {{ $banner->stock }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800"
                                        >
                                            <i class="fas fa-infinity mr-1"></i>
                                            Unlimited
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($banner->is_active)
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800"
                                        >
                                            <span class="mr-1 h-2 w-2 rounded-full bg-green-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-800"
                                        >
                                            <span class="mr-1 h-2 w-2 rounded-full bg-gray-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a
                                            href="{{ route('admin.banners.edit', $banner->id) }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition hover:bg-indigo-200"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            @click="confirmDelete({{ $banner->id }}, '{{ $banner->name }}')"
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
                                    colspan="7"
                                    class="px-6 py-16 text-center"
                                >
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                                            <i class="fas fa-box-open text-3xl text-gray-300"></i>
                                        </div>
                                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Belum ada produk</h3>
                                        <p class="mb-4 text-sm text-gray-500">Mulai tambahkan produk untuk menjual game</p>
                                        <a
                                            href="{{ route('admin.banners.create') }}"
                                            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        >
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Produk Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($banners->hasPages())
                <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                    {{ $banners->links() }}
                </div>
            @endif
        </div>

        <!-- Modern Delete Confirmation Modal -->
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
                            Anda akan menghapus produk:
                        </p>
                        <div class="rounded-lg border border-red-200 bg-white p-3">
                            <p
                                class="font-bold text-gray-900"
                                x-text="deleteModal.bannerName"
                            ></p>
                            <p class="text-sm text-gray-600">ID: #<span x-text="deleteModal.bannerId"></span></p>
                        </div>
                    </div>

                    <div class="mb-6 space-y-3">
                        <p class="font-semibold text-gray-900">Yang akan terhapus:</p>
                        <div class="space-y-2">
                            <div class="flex items-start rounded-lg bg-gray-50 p-3">
                                <i class="fas fa-times-circle mr-3 mt-0.5 text-red-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Data Produk</p>
                                    <p class="text-sm text-gray-600">Semua informasi produk akan hilang</p>
                                </div>
                            </div>
                            <div class="flex items-start rounded-lg bg-gray-50 p-3">
                                <i class="fas fa-times-circle mr-3 mt-0.5 text-red-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Riwayat Transaksi</p>
                                    <p class="text-sm text-gray-600">History terkait produk ini</p>
                                </div>
                            </div>
                            <div class="flex items-start rounded-lg bg-gray-50 p-3">
                                <i class="fas fa-times-circle mr-3 mt-0.5 text-red-600"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Media & Gambar</p>
                                    <p class="text-sm text-gray-600">File terkait akan dihapus</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4">
                        <div class="flex">
                            <i class="fas fa-lightbulb mr-3 mt-0.5 text-yellow-600"></i>
                            <div>
                                <p class="font-semibold text-yellow-900">Saran</p>
                                <p class="text-sm text-yellow-800">Pertimbangkan menonaktifkan produk daripada menghapusnya
                                </p>
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
            :action="`{{ route('admin.banners.index') }}/${deleteModal.bannerId}`"
            method="POST"
            x-ref="deleteForm"
        >
            @csrf
            @method('DELETE')
        </form>

    </div>

    @push('scripts')
        <script>
            function bannerManager() {
                return {
                    deleteModal: {
                        open: false,
                        bannerId: null,
                        bannerName: ''
                    },

                    confirmDelete(bannerId, bannerName) {
                        this.deleteModal.bannerId = bannerId;
                        this.deleteModal.bannerName = bannerName;
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
