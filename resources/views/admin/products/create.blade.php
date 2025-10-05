@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
    <div class="space-y-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a
                href="{{ route('admin.dashboard') }}"
                class="hover:text-indigo-600"
            >
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a
                href="{{ route('admin.products.index') }}"
                class="hover:text-indigo-600"
            >Produk</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="font-medium text-gray-900">Tambah Produk</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Produk Baru</h1>
                <p class="mt-2 text-gray-600">Lengkapi informasi produk dengan detail untuk meningkatkan penjualan</p>
            </div>
            <a
                href="{{ route('admin.products.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <form
            action="{{ route('admin.products.store') }}"
            method="POST"
            x-data="productForm()"
        >
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">

                        <!-- Basic Information Card -->
                        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50 p-6">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600 text-white">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Informasi Dasar</h2>
                                        <p class="text-sm text-gray-600">Data utama produk yang akan dijual</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6 p-6">
                                <!-- Game Selection with Preview -->
                                <div>
                                    <label
                                        for="game_id"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Pilih Game <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="game_id"
                                        name="game_id"
                                        required
                                        x-model="selectedGame"
                                        class="@error('game_id') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >
                                        <option value="">-- Pilih Game --</option>
                                        @foreach ($games as $game)
                                            <option
                                                value="{{ $game->id }}"
                                                {{ old('game_id') == $game->id ? 'selected' : '' }}
                                            >
                                                {{ $game->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('game_id')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        Pilih game yang sesuai dengan produk yang akan dijual
                                    </p>
                                </div>

                                <!-- Product Name with Character Counter -->
                                <div>
                                    <label
                                        for="name"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Nama Produk <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative mt-2">
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="{{ old('name') }}"
                                            required
                                            maxlength="255"
                                            x-model="productName"
                                            placeholder="Contoh: 100 Diamond Mobile Legends"
                                            class="@error('name') border-red-500 @enderror w-full rounded-lg border-2 border-gray-300 px-4 py-3 pr-16 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        >
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400"
                                            x-text="productName.length + '/255'"
                                        ></span>
                                    </div>
                                    @error('name')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        Gunakan nama yang jelas dan mudah dipahami pelanggan
                                    </p>
                                </div>

                                <!-- Description with Rich Features -->
                                <div>
                                    <label
                                        for="description"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Deskripsi Produk
                                    </label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="5"
                                        x-model="productDescription"
                                        placeholder="Jelaskan detail produk, benefit, cara penggunaan, dll..."
                                        class="@error('description') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >{{ old('description') }}</textarea>
                                    <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                                        <span>
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Deskripsi membantu pelanggan memahami produk lebih baik
                                        </span>
                                        <span x-text="productDescription.length + ' karakter'"></span>
                                    </div>
                                    @error('description')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Stock Card -->
                        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50 p-6">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-600 text-white">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Harga & Stok</h2>
                                        <p class="text-sm text-gray-600">Tentukan harga jual dan ketersediaan</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6 p-6">
                                <!-- Price Input -->
                                <div>
                                    <label
                                        for="price"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Harga Jual <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative mt-2">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                            <span class="font-semibold text-gray-600">Rp</span>
                                        </div>
                                        <input
                                            type="number"
                                            id="price"
                                            name="price"
                                            value="{{ old('price') }}"
                                            required
                                            min="0"
                                            step="1"
                                            x-model="productPrice"
                                            @input="calculateProfit"
                                            placeholder="0"
                                            class="@error('price') border-red-500 @enderror w-full rounded-lg border-2 border-gray-300 py-3 pl-12 pr-4 font-semibold transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        >
                                    </div>
                                    <div
                                        class="mt-2 rounded-lg bg-blue-50 p-3"
                                        x-show="productPrice > 0"
                                    >
                                        <p class="text-sm text-blue-900">
                                            <i class="fas fa-calculator mr-1"></i>
                                            Harga yang ditampilkan: <span
                                                class="font-bold"
                                                x-text="formatCurrency(productPrice)"
                                            ></span>
                                        </p>
                                    </div>
                                    @error('price')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Stock Management -->
                                <div>
                                    <label
                                        for="stock"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Kelola Stok
                                    </label>
                                    <div class="mt-2 space-y-3">
                                        <div class="flex items-center space-x-3">
                                            <input
                                                type="radio"
                                                id="stock_unlimited"
                                                name="stock_type"
                                                value="unlimited"
                                                x-model="stockType"
                                                checked
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500"
                                            >
                                            <label
                                                for="stock_unlimited"
                                                class="text-sm text-gray-700"
                                            >
                                                <i class="fas fa-infinity mr-1 text-indigo-600"></i>
                                                Stok Unlimited (Tidak Terbatas)
                                            </label>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <input
                                                type="radio"
                                                id="stock_limited"
                                                name="stock_type"
                                                value="limited"
                                                x-model="stockType"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500"
                                            >
                                            <label
                                                for="stock_limited"
                                                class="text-sm text-gray-700"
                                            >
                                                <i class="fas fa-box mr-1 text-orange-600"></i>
                                                Stok Terbatas
                                            </label>
                                        </div>
                                    </div>

                                    <div
                                        x-show="stockType === 'limited'"
                                        class="mt-4"
                                        x-cloak
                                    >
                                        <input
                                            type="number"
                                            id="stock"
                                            name="stock"
                                            value="{{ old('stock') }}"
                                            min="0"
                                            x-model="stockAmount"
                                            placeholder="Masukkan jumlah stok"
                                            class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        >
                                        <div
                                            class="mt-2 rounded-lg p-3"
                                            :class="stockAmount < 10 ? 'bg-red-50' : 'bg-green-50'"
                                            x-show="stockAmount > 0"
                                        >
                                            <p
                                                class="text-sm"
                                                :class="stockAmount < 10 ? 'text-red-900' : 'text-green-900'"
                                            >
                                                <i
                                                    class="fas mr-1"
                                                    :class="stockAmount < 10 ? 'fa-exclamation-triangle' : 'fa-check-circle'"
                                                ></i>
                                                <span x-show="stockAmount < 10">Stok rendah! Segera restock</span>
                                                <span x-show="stockAmount >= 10">Stok mencukupi</span>
                                            </p>
                                        </div>
                                    </div>
                                    @error('stock')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Publish Card -->
                    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 p-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-paper-plane mr-2 text-indigo-600"></i>
                                Publikasi
                            </h3>
                        </div>
                        <div class="space-y-4 p-4">
                            <div class="rounded-lg bg-gradient-to-br from-indigo-50 to-purple-50 p-4">
                                <label class="flex cursor-pointer items-start space-x-3">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        x-model="isActive"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="mt-1 h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500"
                                    >
                                    <div class="flex-1">
                                        <span class="block font-semibold text-gray-900">Aktifkan Produk</span>
                                        <span class="text-xs text-gray-600">Produk akan langsung tampil di toko</span>
                                    </div>
                                </label>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                        x-text="isActive ? 'Aktif' : 'Draft'"
                                    ></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Visibilitas:</span>
                                    <span
                                        class="text-gray-900"
                                        x-text="isActive ? 'Publik' : 'Private'"
                                    ></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 p-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-eye mr-2 text-purple-600"></i>
                                Preview Produk
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="rounded-lg border-2 border-dashed border-gray-200 p-4">
                                <div
                                    class="mb-3 flex aspect-video items-center justify-center rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100">
                                    <i class="fas fa-image text-4xl text-indigo-300"></i>
                                </div>
                                <h4
                                    class="mb-2 font-bold text-gray-900"
                                    x-text="productName || 'Nama Produk'"
                                ></h4>
                                <p
                                    class="mb-3 line-clamp-2 text-xs text-gray-600"
                                    x-text="productDescription || 'Deskripsi produk akan tampil di sini...'"
                                ></p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-lg font-bold text-indigo-600"
                                        x-text="productPrice ? formatCurrency(productPrice) : 'Rp 0'"
                                    ></span>
                                    <span
                                        class="rounded-full px-2 py-1 text-xs font-semibold"
                                        :class="isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                        x-text="isActive ? 'Aktif' : 'Draft'"
                                    ></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                        <h3 class="mb-3 flex items-center font-semibold text-blue-900">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Tips Produk Laris
                        </h3>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Gunakan nama produk yang jelas dan deskriptif</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Tulis deskripsi lengkap dengan detail benefit</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Set harga kompetitif sesuai pasaran</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Pantau stok secara berkala</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Simpan Produk
                        </button>
                        <a
                            href="{{ route('admin.products.index') }}"
                            class="flex w-full items-center justify-center rounded-lg border-2 border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </form>

    </div>

    @push('scripts')
        <script>
            function productForm() {
                return {
                    productName: '{{ old('name') }}',
                    productDescription: '{{ old('description') }}',
                    productPrice: {{ old('price', 0) }},
                    stockType: 'unlimited',
                    stockAmount: {{ old('stock', 0) }},
                    isActive: {{ old('is_active', 'true') ? 'true' : 'false' }},
                    selectedGame: '{{ old('game_id') }}',

                    formatCurrency(value) {
                        return 'Rp ' + parseInt(value).toLocaleString('id-ID');
                    },

                    calculateProfit() {
                        // Add profit calculation logic here if needed
                    }
                }
            }
        </script>
    @endpush
@endsection
