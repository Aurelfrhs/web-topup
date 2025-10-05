@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
    <div
        class="space-y-6"
        x-data="productEditForm()"
    >

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a
                href="{{ route('admin.dashboard') }}"
                class="transition hover:text-indigo-600"
            >
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a
                href="{{ route('admin.products.index') }}"
                class="transition hover:text-indigo-600"
            >Produk</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="font-medium text-gray-900">Edit Produk #{{ $product->id }}</span>
        </nav>

        <!-- Header Section -->
        <div
            class="rounded-xl border border-indigo-100 bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <div class="mb-2 inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-sm backdrop-blur">
                        <i class="fas fa-edit mr-2"></i>
                        Mode Edit
                    </div>
                    <h1 class="mb-2 text-3xl font-bold">{{ $product->name }}</h1>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span><i class="fas fa-hashtag mr-1"></i>ID: {{ $product->id }}</span>
                        <span><i class="fas fa-gamepad mr-1"></i>{{ $product->game->name ?? 'N/A' }}</span>
                        <span><i class="fas fa-calendar mr-1"></i>{{ $product->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <a
                    href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border-2 border-white bg-white/10 px-6 py-3 font-semibold backdrop-blur transition hover:bg-white/20"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <form
            action="{{ route('admin.products.update', $product->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

                <!-- Main Content (8 columns) -->
                <div class="space-y-6 xl:col-span-8">

                    <!-- Product Information -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600"
                                >
                                    <i class="fas fa-box text-sm"></i>
                                </span>
                                Informasi Produk
                            </h2>
                        </div>

                        <div class="space-y-6 p-6">
                            <!-- Game Selection -->
                            <div>
                                <label
                                    for="game_id"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Game <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select
                                        id="game_id"
                                        name="game_id"
                                        required
                                        x-model="form.game_id"
                                        class="@error('game_id') border-red-300 @enderror w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-3 pr-10 font-medium transition focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                    >
                                        <option value="">-- Pilih Game --</option>
                                        @foreach ($games as $game)
                                            <option
                                                value="{{ $game->id }}"
                                                {{ old('game_id', $product->game_id) == $game->id ? 'selected' : '' }}
                                            >
                                                {{ $game->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                @error('game_id')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div
                                    class="mt-2 rounded-lg bg-blue-50 px-3 py-2 text-sm text-blue-700"
                                    x-show="form.game_id != '{{ $product->game_id }}'"
                                >
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Game akan diubah dari <strong>{{ $product->game->name }}</strong>
                                </div>
                            </div>

                            <!-- Product Name -->
                            <div>
                                <label
                                    for="name"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $product->name) }}"
                                        required
                                        maxlength="255"
                                        x-model="form.name"
                                        placeholder="Contoh: 100 Diamond Mobile Legends"
                                        class="@error('name') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 px-4 py-3 pr-20 font-medium transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                    >
                                    <span
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-400"
                                        x-text="form.name.length + '/255'"
                                    ></span>
                                </div>
                                @error('name')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label
                                    for="description"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Deskripsi Produk
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="6"
                                    x-model="form.description"
                                    placeholder="Tulis deskripsi lengkap tentang produk ini untuk membantu pelanggan memahami benefit dan keunggulannya..."
                                    class="@error('description') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 px-4 py-3 font-medium transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                >{{ old('description', $product->description) }}</textarea>
                                <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                                    <span><i class="fas fa-info-circle mr-1"></i>Deskripsi yang detail meningkatkan konversi
                                        penjualan</span>
                                    <span x-text="form.description.length + ' karakter'"></span>
                                </div>
                                @error('description')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 text-green-600"
                                >
                                    <i class="fas fa-dollar-sign text-sm"></i>
                                </span>
                                Harga & Stok
                            </h2>
                        </div>

                        <div class="space-y-6 p-6">
                            <!-- Current Price Info -->
                            <div class="rounded-xl border border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="mb-1 text-sm text-gray-600">Harga Saat Ini</p>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ number_format($product->price, 0, ',', '.') }} IDR</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="mb-1 text-sm text-gray-600">Stok Saat Ini</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $product->stock ?? '∞' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- New Price -->
                            <div>
                                <label
                                    for="price"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Harga Baru <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-500">Rp</span>
                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        value="{{ old('price', $product->price) }}"
                                        required
                                        min="0"
                                        step="1"
                                        x-model="form.price"
                                        @input="calculatePriceChange()"
                                        placeholder="0"
                                        class="@error('price') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 py-3 pl-14 pr-4 text-lg font-bold transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                    >
                                </div>
                                @error('price')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror

                                <!-- Price Change Indicator -->
                                <div
                                    x-show="priceChange.changed"
                                    class="mt-3"
                                >
                                    <div
                                        class="rounded-lg p-4"
                                        :class="priceChange.increased ? 'bg-red-50 border border-red-200' :
                                            'bg-green-50 border border-green-200'"
                                    >
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex h-10 w-10 items-center justify-center rounded-full"
                                                    :class="priceChange.increased ? 'bg-red-100' : 'bg-green-100'"
                                                >
                                                    <i
                                                        class="fas text-lg"
                                                        :class="priceChange.increased ? 'fa-arrow-up text-red-600' :
                                                            'fa-arrow-down text-green-600'"
                                                    ></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p
                                                        class="font-semibold"
                                                        :class="priceChange.increased ? 'text-red-900' : 'text-green-900'"
                                                        x-text="priceChange.increased ? 'Kenaikan Harga' : 'Penurunan Harga'"
                                                    ></p>
                                                    <p
                                                        class="text-sm"
                                                        :class="priceChange.increased ? 'text-red-700' : 'text-green-700'"
                                                        x-text="formatCurrency(Math.abs(priceChange.amount))"
                                                    ></p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p
                                                    class="text-sm font-medium"
                                                    :class="priceChange.increased ? 'text-red-700' : 'text-green-700'"
                                                >Perubahan</p>
                                                <p
                                                    class="text-xl font-bold"
                                                    :class="priceChange.increased ? 'text-red-900' : 'text-green-900'"
                                                    x-text="priceChange.percentage.toFixed(1) + '%'"
                                                ></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Management -->
                            <div>
                                <label class="mb-3 block text-sm font-semibold text-gray-700">
                                    Manajemen Stok
                                </label>

                                <div class="space-y-3">
                                    <label
                                        class="flex cursor-pointer items-center rounded-lg border-2 p-4 transition"
                                        :class="form.stockType === 'unlimited' ? 'border-indigo-500 bg-indigo-50' :
                                            'border-gray-200 hover:border-gray-300'"
                                    >
                                        <input
                                            type="radio"
                                            name="stock_type"
                                            value="unlimited"
                                            x-model="form.stockType"
                                            class="h-5 w-5 border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500"
                                        >
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-infinity mr-2 text-indigo-600"></i>
                                                <span class="font-semibold text-gray-900">Stok Unlimited</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">Produk selalu tersedia tanpa batas</p>
                                        </div>
                                    </label>

                                    <label
                                        class="flex cursor-pointer items-center rounded-lg border-2 p-4 transition"
                                        :class="form.stockType === 'limited' ? 'border-indigo-500 bg-indigo-50' :
                                            'border-gray-200 hover:border-gray-300'"
                                    >
                                        <input
                                            type="radio"
                                            name="stock_type"
                                            value="limited"
                                            x-model="form.stockType"
                                            class="h-5 w-5 border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500"
                                        >
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-box-open mr-2 text-orange-600"></i>
                                                <span class="font-semibold text-gray-900">Stok Terbatas</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">Kelola jumlah stok produk</p>
                                        </div>
                                    </label>
                                </div>

                                <!-- Limited Stock Input -->
                                <div
                                    x-show="form.stockType === 'limited'"
                                    x-cloak
                                    class="mt-4"
                                >
                                    <input
                                        type="number"
                                        id="stock"
                                        name="stock"
                                        value="{{ old('stock', $product->stock) }}"
                                        min="0"
                                        x-model="form.stock"
                                        placeholder="Masukkan jumlah stok"
                                        class="w-full rounded-lg border-2 border-gray-200 px-4 py-3 font-bold transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                    >

                                    <!-- Stock Status -->
                                    <div
                                        x-show="form.stock > 0"
                                        class="mt-3 rounded-lg p-3"
                                        :class="form.stock < 10 ? 'bg-red-50 border border-red-200' : form.stock < 50 ?
                                            'bg-yellow-50 border border-yellow-200' :
                                            'bg-green-50 border border-green-200'"
                                    >
                                        <div class="flex items-center">
                                            <i
                                                class="fas mr-3 text-lg"
                                                :class="form.stock < 10 ? 'fa-exclamation-triangle text-red-600' : form.stock <
                                                    50 ? 'fa-exclamation-circle text-yellow-600' :
                                                    'fa-check-circle text-green-600'"
                                            ></i>
                                            <div>
                                                <p
                                                    class="font-semibold"
                                                    :class="form.stock < 10 ? 'text-red-900' : form.stock < 50 ?
                                                        'text-yellow-900' : 'text-green-900'"
                                                >
                                                    <span x-show="form.stock < 10">Stok Kritis - Segera Restock!</span>
                                                    <span x-show="form.stock >= 10 && form.stock < 50">Stok Menipis</span>
                                                    <span x-show="form.stock >= 50">Stok Aman</span>
                                                </p>
                                                <p
                                                    class="text-sm"
                                                    :class="form.stock < 10 ? 'text-red-700' : form.stock < 50 ?
                                                        'text-yellow-700' : 'text-green-700'"
                                                    x-text="form.stock + ' unit tersedia'"
                                                ></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @error('stock')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Change Summary -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm"
                        x-show="hasChanges()"
                    >
                        <div class="border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-500 text-white"
                                >
                                    <i class="fas fa-edit text-sm"></i>
                                </span>
                                Ringkasan Perubahan
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-2">
                                <div
                                    x-show="form.game_id != '{{ $product->game_id }}'"
                                    class="flex items-center justify-between rounded-lg border border-blue-200 bg-blue-50 px-4 py-3"
                                >
                                    <span class="font-medium text-blue-900"><i class="fas fa-gamepad mr-2"></i>Game</span>
                                    <span
                                        class="rounded-full bg-blue-200 px-3 py-1 text-xs font-bold text-blue-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.name !== '{{ $product->name }}'"
                                    class="flex items-center justify-between rounded-lg border border-purple-200 bg-purple-50 px-4 py-3"
                                >
                                    <span class="font-medium text-purple-900"><i class="fas fa-tag mr-2"></i>Nama
                                        Produk</span>
                                    <span
                                        class="rounded-full bg-purple-200 px-3 py-1 text-xs font-bold text-purple-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.description !== '{{ $product->description }}'"
                                    class="flex items-center justify-between rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3"
                                >
                                    <span class="font-medium text-indigo-900"><i
                                            class="fas fa-align-left mr-2"></i>Deskripsi</span>
                                    <span
                                        class="rounded-full bg-indigo-200 px-3 py-1 text-xs font-bold text-indigo-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="priceChange.changed"
                                    class="flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3"
                                >
                                    <span class="font-medium text-green-900"><i
                                            class="fas fa-dollar-sign mr-2"></i>Harga</span>
                                    <span
                                        class="rounded-full bg-green-200 px-3 py-1 text-xs font-bold text-green-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.stock != '{{ $product->stock }}' || form.stockType !== '{{ $product->stock ? 'limited' : 'unlimited' }}'"
                                    class="flex items-center justify-between rounded-lg border border-orange-200 bg-orange-50 px-4 py-3"
                                >
                                    <span class="font-medium text-orange-900"><i class="fas fa-boxes mr-2"></i>Stok</span>
                                    <span
                                        class="rounded-full bg-orange-200 px-3 py-1 text-xs font-bold text-orange-900">DIUBAH</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar (4 columns) -->
                <div class="space-y-6 xl:col-span-4">

                    <!-- Publish Settings -->
                    <div class="sticky top-6 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-toggle-on mr-2 text-indigo-600"></i>
                                Status Publikasi
                            </h3>
                        </div>
                        <div class="space-y-4 p-6">
                            <div
                                class="rounded-xl p-4"
                                :class="form.isActive ?
                                    'bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200' :
                                    'bg-gradient-to-br from-gray-50 to-slate-50 border-2 border-gray-200'"
                            >
                                <label class="flex cursor-pointer items-start">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        x-model="form.isActive"
                                        {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                        class="mt-1 h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500"
                                    >
                                    <div class="ml-3 flex-1">
                                        <span class="block font-bold text-gray-900">Publikasikan Produk</span>
                                        <span class="text-sm text-gray-600">Produk akan ditampilkan di toko</span>
                                    </div>
                                </label>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between rounded bg-gray-50 p-2">
                                    <span class="text-gray-600">Status:</span>
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-bold"
                                        :class="form.isActive ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800'"
                                        x-text="form.isActive ? 'AKTIF' : 'NONAKTIF'"
                                    ></span>
                                </div>
                                <div class="flex items-center justify-between rounded bg-gray-50 p-2">
                                    <span class="text-gray-600">Visibilitas:</span>
                                    <span
                                        class="font-semibold text-gray-900"
                                        x-text="form.isActive ? 'Publik' : 'Private'"
                                    ></span>
                                </div>
                            </div>

                            <!-- Warning if deactivating -->
                            <div
                                x-show="!form.isActive && '{{ $product->is_active }}' == '1'"
                                class="rounded-lg border border-yellow-200 bg-yellow-50 p-3"
                            >
                                <div class="flex">
                                    <i class="fas fa-exclamation-triangle mr-2 mt-0.5 text-yellow-600"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-yellow-900">Produk akan dinonaktifkan</p>
                                        <p class="mt-1 text-xs text-yellow-700">Produk tidak akan tampil di toko setelah
                                            disimpan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Preview -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-eye mr-2 text-purple-600"></i>
                                Preview Live
                            </h3>
                        </div>
                        <div class="p-6">
                            <div
                                class="overflow-hidden rounded-xl border-2 border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                                <div
                                    class="flex aspect-video items-center justify-center bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400">
                                    <i class="fas fa-image text-5xl text-white/50"></i>
                                </div>
                                <div class="p-4">
                                    <div class="mb-2 flex items-start justify-between">
                                        <h4
                                            class="line-clamp-2 flex-1 font-bold text-gray-900"
                                            x-text="form.name || 'Nama Produk'"
                                        ></h4>
                                        <span
                                            class="ml-2 rounded-full px-2 py-1 text-xs font-bold"
                                            :class="form.isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                            x-text="form.isActive ? 'Aktif' : 'Draft'"
                                        ></span>
                                    </div>
                                    <p
                                        class="mb-3 line-clamp-2 text-sm text-gray-600"
                                        x-text="form.description || 'Deskripsi produk...'"
                                    ></p>
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                                        <span
                                            class="text-xl font-bold text-indigo-600"
                                            x-text="formatCurrency(form.price)"
                                        ></span>
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-box mr-1"></i>
                                            <span x-text="form.stockType === 'unlimited' ? '∞' : form.stock"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 text-lg font-bold text-white shadow-lg transition hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                        <a
                            href="{{ route('admin.products.index') }}"
                            class="flex w-full items-center justify-center rounded-xl border-2 border-gray-300 bg-white px-6 py-4 text-lg font-bold text-gray-700 transition hover:bg-gray-50"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>

                    <!-- Product Statistics -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                                Statistik Produk
                            </h3>
                        </div>
                        <div class="space-y-3 p-6">
                            <div class="flex items-center justify-between rounded-lg bg-blue-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                        <i class="fas fa-shopping-cart text-blue-600"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Total Terjual</span>
                                </div>
                                <span class="text-xl font-bold text-blue-600">0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-green-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                                        <i class="fas fa-dollar-sign text-green-600"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Pendapatan</span>
                                </div>
                                <span class="text-xl font-bold text-green-600">Rp 0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-purple-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100">
                                        <i class="fas fa-eye text-purple-600"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Dilihat</span>
                                </div>
                                <span class="text-xl font-bold text-purple-600">0</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function productEditForm() {
                return {
                    form: {
                        game_id: '{{ old('game_id', $product->game_id) }}',
                        name: '{{ old('name', $product->name) }}',
                        description: '{{ old('description', $product->description) }}',
                        price: {{ old('price', $product->price) }},
                        stockType: '{{ $product->stock ? 'limited' : 'unlimited' }}',
                        stock: {{ old('stock', $product->stock ?? 0) }},
                        isActive: {{ old('is_active', $product->is_active) ? 'true' : 'false' }}
                    },

                    original: {
                        game_id: '{{ $product->game_id }}',
                        name: '{{ $product->name }}',
                        description: '{{ $product->description }}',
                        price: {{ $product->price }},
                        stock: {{ $product->stock ?? 0 }},
                        isActive: {{ $product->is_active ? 'true' : 'false' }}
                    },

                    priceChange: {
                        changed: false,
                        increased: false,
                        amount: 0,
                        percentage: 0
                    },

                    init() {
                        this.calculatePriceChange();
                    },

                    formatCurrency(value) {
                        return 'Rp ' + parseInt(value).toLocaleString('id-ID');
                    },

                    calculatePriceChange() {
                        const newPrice = parseFloat(this.form.price);
                        const oldPrice = parseFloat(this.original.price);

                        this.priceChange.amount = newPrice - oldPrice;
                        this.priceChange.changed = this.priceChange.amount !== 0;
                        this.priceChange.increased = this.priceChange.amount > 0;
                        this.priceChange.percentage = oldPrice > 0 ? (this.priceChange.amount / oldPrice) * 100 : 0;
                    },

                    hasChanges() {
                        return this.form.game_id != this.original.game_id ||
                            this.form.name !== this.original.name ||
                            this.form.description !== this.original.description ||
                            this.priceChange.changed ||
                            this.form.stock != this.original.stock ||
                            this.form.stockType !== '{{ $product->stock ? 'limited' : 'unlimited' }}' ||
                            this.form.isActive !== this.original.isActive;
                    }
                }
            }
        </script>
    @endpush
@endsection
