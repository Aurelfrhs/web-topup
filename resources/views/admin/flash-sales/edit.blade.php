@extends('layouts.admin')

@section('title', 'Edit Flash Sale')
@section('page-title', 'Edit Flash Sale')

@section('content')
    <div
        class="space-y-6"
        x-data="flashSaleEditForm()"
    >

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a
                href="{{ route('admin.dashboard') }}"
                class="transition hover:text-red-600"
            >
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a
                href="{{ route('admin.flash-sales.index') }}"
                class="transition hover:text-red-600"
            >Flash Sale</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="font-medium text-gray-900">Edit Flash Sale #{{ $flashSale->id }}</span>
        </nav>

        <!-- Header Section -->
        <div class="rounded-xl border border-red-100 bg-gradient-to-r from-red-600 to-pink-600 p-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <div class="mb-2 inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-sm backdrop-blur">
                        <i class="fas fa-edit mr-2"></i>
                        Mode Edit
                    </div>
                    <h1 class="mb-2 text-3xl font-bold">{{ $flashSale->product->name ?? 'Flash Sale' }}</h1>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span><i class="fas fa-hashtag mr-1"></i>ID: {{ $flashSale->id }}</span>
                        <span><i class="fas fa-percent mr-1"></i>Diskon: {{ $flashSale->discount_percentage }}%</span>
                        <span>
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $flashSale->start_time->format('d M Y') }}
                        </span>
                    </div>
                </div>
                <a
                    href="{{ route('admin.flash-sales.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border-2 border-white bg-white/10 px-6 py-3 font-semibold backdrop-blur transition hover:bg-white/20"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <form
            action="{{ route('admin.flash-sales.update', $flashSale->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

                <!-- Main Content (8 columns) -->
                <div class="space-y-6 xl:col-span-8">

                    <!-- Product Selection -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600"
                                >
                                    <i class="fas fa-box text-sm"></i>
                                </span>
                                Informasi Produk
                            </h2>
                        </div>

                        <div class="space-y-6 p-6">
                            <!-- Current Product Info -->
                            <div class="rounded-xl border-2 border-red-200 bg-gradient-to-r from-red-50 to-pink-50 p-4">
                                <div class="mb-2 flex items-center">
                                    <span class="rounded-full bg-red-500 px-2 py-1 text-xs font-bold text-white">PRODUK SAAT
                                        INI</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="mb-1 text-lg font-bold text-gray-900">{{ $flashSale->product->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $flashSale->product->game->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="mb-1 text-sm text-gray-600">Harga Normal</p>
                                        <p class="text-xl font-bold text-gray-900">
                                            Rp {{ number_format($flashSale->product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Selection -->
                            <div>
                                <label
                                    for="product_id"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Pilih Produk Baru <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select
                                        id="product_id"
                                        name="product_id"
                                        required
                                        x-model="form.product_id"
                                        @change="updateProductInfo()"
                                        class="@error('product_id') border-red-300 @enderror w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-3 pr-10 font-medium transition focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-50"
                                    >
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($products as $product)
                                            <option
                                                value="{{ $product->id }}"
                                                data-price="{{ $product->price }}"
                                                data-name="{{ $product->name }}"
                                                data-game="{{ $product->game->name ?? 'N/A' }}"
                                                {{ old('product_id', $flashSale->product_id) == $product->id ? 'selected' : '' }}
                                            >
                                                {{ $product->name }} - Rp
                                                {{ number_format($product->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                @error('product_id')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Pilih produk yang sama untuk hanya mengubah pengaturan lainnya
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Discount & Stock Settings -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-orange-100 text-orange-600"
                                >
                                    <i class="fas fa-percent text-sm"></i>
                                </span>
                                Pengaturan Diskon & Stok
                            </h2>
                        </div>

                        <div class="space-y-6 p-6">
                            <!-- Current Stats -->
                            <div class="rounded-xl border border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-4">
                                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-600">DATA SAAT INI
                                </p>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div class="text-center">
                                        <div
                                            class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                            <i class="fas fa-tag text-red-600"></i>
                                        </div>
                                        <p class="text-2xl font-bold text-red-600">{{ $flashSale->discount_percentage }}%
                                        </p>
                                        <p class="text-xs text-gray-600">Diskon</p>
                                    </div>
                                    <div class="text-center">
                                        <div
                                            class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                            <i class="fas fa-dollar-sign text-green-600"></i>
                                        </div>
                                        <p class="text-lg font-bold text-green-600">
                                            Rp {{ number_format($flashSale->discounted_price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-gray-600">Harga Flash Sale</p>
                                    </div>
                                    <div class="text-center">
                                        <div
                                            class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                                            <i class="fas fa-boxes text-blue-600"></i>
                                        </div>
                                        <p class="text-lg font-bold text-blue-600">{{ $flashSale->stock }} Unit</p>
                                        <p class="text-xs text-gray-600">Stok Tersedia</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- New Discount -->
                                <div>
                                    <label
                                        for="discount_percentage"
                                        class="mb-2 block text-sm font-semibold text-gray-700"
                                    >
                                        Persentase Diskon <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input
                                            type="number"
                                            id="discount_percentage"
                                            name="discount_percentage"
                                            value="{{ old('discount_percentage', $flashSale->discount_percentage) }}"
                                            required
                                            min="1"
                                            max="99"
                                            x-model="form.discount_percentage"
                                            @input="calculateDiscount()"
                                            placeholder="0"
                                            class="@error('discount_percentage') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 py-3 pl-4 pr-12 text-lg font-bold transition placeholder:text-gray-400 focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-50"
                                        >
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-xl font-bold text-gray-600"
                                        >%</span>
                                    </div>
                                    @error('discount_percentage')
                                        <p class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label
                                        for="stock"
                                        class="mb-2 block text-sm font-semibold text-gray-700"
                                    >
                                        Stok Flash Sale <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input
                                            type="number"
                                            id="stock"
                                            name="stock"
                                            value="{{ old('stock', $flashSale->stock) }}"
                                            required
                                            min="1"
                                            placeholder="0"
                                            class="@error('stock') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 py-3 pl-4 pr-16 text-lg font-bold transition placeholder:text-gray-400 focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-50"
                                        >
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 font-semibold text-gray-600">Unit</span>
                                    </div>
                                    @error('stock')
                                        <p class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <div class="mt-2 flex items-center justify-between text-xs">
                                        <span class="text-gray-500">
                                            <i class="fas fa-shopping-cart mr-1"></i>
                                            Terjual: <span
                                                class="font-semibold text-gray-900">{{ $flashSale->sold }}</span>
                                        </span>
                                        <span class="text-gray-500">
                                            Sisa: <span
                                                class="font-semibold text-blue-600">{{ $flashSale->stock - $flashSale->sold }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Discount Change Indicator -->
                            <div
                                x-show="discountChange.changed"
                                class="mt-4"
                            >
                                <div
                                    class="rounded-xl border-2 p-4"
                                    :class="discountChange.increased ?
                                        'bg-gradient-to-br from-green-50 to-emerald-50 border-green-300' :
                                        'bg-gradient-to-br from-red-50 to-pink-50 border-red-300'"
                                >
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-full"
                                                :class="discountChange.increased ? 'bg-green-500' : 'bg-red-500'"
                                            >
                                                <i
                                                    class="fas text-xl text-white"
                                                    :class="discountChange.increased ? 'fa-arrow-up' :
                                                        'fa-arrow-down'"
                                                ></i>
                                            </div>
                                            <div class="ml-4">
                                                <p
                                                    class="font-bold"
                                                    :class="discountChange.increased ? 'text-green-900' : 'text-red-900'"
                                                    x-text="discountChange.increased ? 'Diskon Ditingkatkan!' : 'Diskon Dikurangi'"
                                                >
                                                </p>
                                                <p
                                                    class="text-sm"
                                                    :class="discountChange.increased ? 'text-green-700' : 'text-red-700'"
                                                    x-text="(discountChange.increased ? '+' : '') + discountChange.amount + '% dari sebelumnya'"
                                                >
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-600">Harga Baru</p>
                                            <p
                                                class="text-2xl font-bold"
                                                :class="discountChange.increased ? 'text-green-900' : 'text-red-900'"
                                                x-text="formatCurrency(form.discountedPrice)"
                                            ></p>
                                            <p class="text-xs text-gray-500">
                                                Hemat <span x-text="formatCurrency(form.discountAmount)"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Schedule -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600"
                                >
                                    <i class="fas fa-clock text-sm"></i>
                                </span>
                                Jadwal Flash Sale
                            </h2>
                        </div>

                        <div class="space-y-6 p-6">
                            <!-- Current Schedule -->
                            <div class="rounded-xl border border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-4">
                                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-600">JADWAL SAAT INI
                                </p>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <div class="mb-2 flex items-center text-sm text-gray-600">
                                            <i class="fas fa-play-circle mr-2"></i>
                                            Waktu Mulai
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $flashSale->start_time->format('d M Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $flashSale->start_time->format('H:i') }} WIB
                                        </p>
                                    </div>
                                    <div>
                                        <div class="mb-2 flex items-center text-sm text-gray-600">
                                            <i class="fas fa-stop-circle mr-2"></i>
                                            Waktu Berakhir
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ $flashSale->end_time->format('d M Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $flashSale->end_time->format('H:i') }} WIB
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Start Time -->
                                <div>
                                    <label
                                        for="start_time"
                                        class="mb-2 block text-sm font-semibold text-gray-700"
                                    >
                                        Waktu Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="datetime-local"
                                        id="start_time"
                                        name="start_time"
                                        value="{{ old('start_time', $flashSale->start_time->format('Y-m-d\TH:i')) }}"
                                        required
                                        x-model="form.start_time"
                                        class="@error('start_time') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 px-4 py-3 font-medium transition focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-50"
                                    >
                                    @error('start_time')
                                        <p class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- End Time -->
                                <div>
                                    <label
                                        for="end_time"
                                        class="mb-2 block text-sm font-semibold text-gray-700"
                                    >
                                        Waktu Berakhir <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="datetime-local"
                                        id="end_time"
                                        name="end_time"
                                        value="{{ old('end_time', $flashSale->end_time->format('Y-m-d\TH:i')) }}"
                                        required
                                        x-model="form.end_time"
                                        class="@error('end_time') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 px-4 py-3 font-medium transition focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-50"
                                    >
                                    @error('end_time')
                                        <p class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duration Info -->
                            <div
                                x-show="form.start_time && form.end_time"
                                class="rounded-xl border-2 border-purple-200 bg-gradient-to-r from-purple-50 to-pink-50 p-4"
                            >
                                <div class="flex items-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-500">
                                        <i class="fas fa-hourglass-half text-white"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-bold text-purple-900">Durasi Flash Sale</p>
                                        <p
                                            class="text-lg font-bold text-purple-600"
                                            x-text="calculateDuration()"
                                        ></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Summary -->
                    <div
                        class="overflow-hidden rounded-xl border border-yellow-200 bg-white shadow-sm"
                        x-show="hasChanges()"
                    >
                        <div class="border-b border-yellow-200 bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-500 text-white"
                                >
                                    <i class="fas fa-exclamation-triangle text-sm"></i>
                                </span>
                                Ringkasan Perubahan
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div
                                    x-show="form.product_id != '{{ $flashSale->product_id }}'"
                                    class="flex items-center justify-between rounded-lg border-2 border-blue-200 bg-blue-50 px-4 py-3"
                                >
                                    <div class="flex items-center">
                                        <i class="fas fa-box mr-3 text-blue-600"></i>
                                        <span class="font-semibold text-blue-900">Produk</span>
                                    </div>
                                    <span
                                        class="rounded-full bg-blue-600 px-3 py-1 text-xs font-bold text-white">DIUBAH</span>
                                </div>
                                <div
                                    x-show="discountChange.changed"
                                    class="flex items-center justify-between rounded-lg border-2 border-orange-200 bg-orange-50 px-4 py-3"
                                >
                                    <div class="flex items-center">
                                        <i class="fas fa-percent mr-3 text-orange-600"></i>
                                        <span class="font-semibold text-orange-900">Persentase Diskon</span>
                                    </div>
                                    <span
                                        class="rounded-full bg-orange-600 px-3 py-1 text-xs font-bold text-white">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.start_time !== '{{ $flashSale->start_time->format('Y-m-d\TH:i') }}'"
                                    class="flex items-center justify-between rounded-lg border-2 border-green-200 bg-green-50 px-4 py-3"
                                >
                                    <div class="flex items-center">
                                        <i class="fas fa-play-circle mr-3 text-green-600"></i>
                                        <span class="font-semibold text-green-900">Waktu Mulai</span>
                                    </div>
                                    <span
                                        class="rounded-full bg-green-600 px-3 py-1 text-xs font-bold text-white">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.end_time !== '{{ $flashSale->end_time->format('Y-m-d\TH:i') }}'"
                                    class="flex items-center justify-between rounded-lg border-2 border-purple-200 bg-purple-50 px-4 py-3"
                                >
                                    <div class="flex items-center">
                                        <i class="fas fa-stop-circle mr-3 text-purple-600"></i>
                                        <span class="font-semibold text-purple-900">Waktu Berakhir</span>
                                    </div>
                                    <span
                                        class="rounded-full bg-purple-600 px-3 py-1 text-xs font-bold text-white">DIUBAH</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar (4 columns) -->
                <div class="space-y-6 xl:col-span-4">

                    <!-- Status Settings -->
                    <div class="sticky top-6 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-toggle-on mr-2 text-red-600"></i>
                                Status Flash Sale
                            </h3>
                        </div>
                        <div class="space-y-4 p-6">
                            <div
                                class="rounded-xl border-2 p-4"
                                :class="form.status === 'active' ?
                                    'bg-gradient-to-br from-green-50 to-emerald-50 border-green-300' :
                                    'bg-gradient-to-br from-gray-50 to-slate-50 border-gray-300'"
                            >
                                <label class="flex cursor-pointer items-start">
                                    <input
                                        type="checkbox"
                                        name="status"
                                        value="active"
                                        x-model="form.status"
                                        {{ old('status', $flashSale->status) == 'active' ? 'checked' : '' }}
                                        class="mt-1 h-5 w-5 rounded border-gray-300 text-red-600 focus:ring-2 focus:ring-red-500"
                                    >
                                    <div class="ml-3 flex-1">
                                        <span class="block font-bold text-gray-900">Aktifkan Flash Sale</span>
                                        <span class="text-sm text-gray-600">Flash sale akan berjalan sesuai jadwal</span>
                                    </div>
                                </label>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3">
                                    <span class="text-sm font-medium text-gray-600">Status:</span>
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-bold"
                                        :class="form.status === 'active' ? 'bg-green-500 text-white' :
                                            'bg-gray-400 text-white'"
                                        x-text="form.status === 'active' ? 'AKTIF' : 'NONAKTIF'"
                                    ></span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-3">
                                    <span class="text-sm font-medium text-gray-600">Kondisi:</span>
                                    <span
                                        class="font-bold text-gray-900"
                                        x-text="getStatusText()"
                                    ></span>
                                </div>
                            </div>

                            <!-- Warning if deactivating -->
                            <div
                                x-show="form.status !== 'active' && '{{ $flashSale->status }}' == 'active'"
                                class="rounded-lg border-2 border-yellow-300 bg-yellow-50 p-4"
                            >
                                <div class="flex">
                                    <i class="fas fa-exclamation-triangle mr-3 mt-0.5 text-yellow-600"></i>
                                    <div>
                                        <p class="font-bold text-yellow-900">Peringatan!</p>
                                        <p class="mt-1 text-sm text-yellow-800">Flash sale akan dinonaktifkan setelah
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
                                class="overflow-hidden rounded-xl border-2 border-gray-200 bg-white shadow-lg transition hover:shadow-xl">
                                <div class="bg-gradient-to-br from-red-500 to-pink-500 p-4">
                                    <div class="flex items-center justify-between text-white">
                                        <div class="flex items-center">
                                            <i class="fas fa-bolt mr-2"></i>
                                            <span class="text-sm font-bold">FLASH SALE</span>
                                        </div>
                                        <span
                                            class="rounded-full bg-white/30 px-3 py-1 text-sm font-bold backdrop-blur"
                                            x-text="form.discount_percentage + '% OFF'"
                                        ></span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="mb-3 flex items-start justify-between">
                                        <h4
                                            class="line-clamp-2 flex-1 text-lg font-bold text-gray-900"
                                            x-text="productInfo.name"
                                        ></h4>
                                        <span
                                            class="ml-2 rounded-full px-2 py-1 text-xs font-bold"
                                            :class="form.status === 'active' ? 'bg-green-100 text-green-800' :
                                                'bg-gray-100 text-gray-800'"
                                            x-text="form.status === 'active' ? 'Aktif' : 'Draft'"
                                        ></span>
                                    </div>
                                    <p
                                        class="mb-4 text-sm text-gray-600"
                                        x-text="productInfo.game"
                                    ></p>
                                    <div class="mb-4 flex items-baseline gap-2">
                                        <span
                                            class="text-sm text-gray-500 line-through"
                                            x-text="formatCurrency(productInfo.price)"
                                        ></span>
                                        <span
                                            class="text-2xl font-bold text-red-600"
                                            x-text="formatCurrency(form.discountedPrice)"
                                        ></span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-t border-gray-100 pt-3 text-xs text-gray-500">
                                        <span x-show="form.start_time">
                                            <i class="fas fa-calendar mr-1"></i>
                                            <span x-text="formatDate(form.start_time)"></span>
                                        </span>
                                        <span class="font-bold text-green-600">
                                            Hemat <span x-text="formatCurrency(form.discountAmount)"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-center text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Preview tampilan di website
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4 text-lg font-bold text-white shadow-lg transition hover:from-red-700 hover:to-pink-700 hover:shadow-xl"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                        <a
                            href="{{ route('admin.flash-sales.index') }}"
                            class="flex w-full items-center justify-center rounded-xl border-2 border-gray-300 bg-white px-6 py-4 text-lg font-bold text-gray-700 transition hover:bg-gray-50"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>

                    <!-- Statistics -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                                Statistik Flash Sale
                            </h3>
                        </div>
                        <div class="space-y-3 p-6">
                            <div class="flex items-center justify-between rounded-lg bg-blue-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500">
                                        <i class="fas fa-shopping-cart text-white"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Terjual</span>
                                </div>
                                <span class="text-xl font-bold text-blue-600">{{ $flashSale->sold }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-green-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-500">
                                        <i class="fas fa-dollar-sign text-white"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Revenue</span>
                                </div>
                                <span class="text-xl font-bold text-green-600">
                                    Rp {{ number_format($flashSale->sold * $flashSale->discounted_price, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-purple-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-500">
                                        <i class="fas fa-percentage text-white"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Conversion</span>
                                </div>
                                <span class="text-xl font-bold text-purple-600">
                                    {{ $flashSale->stock > 0 ? number_format(($flashSale->sold / $flashSale->stock) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-info-circle mr-2 text-gray-600"></i>
                                Informasi
                            </h3>
                        </div>
                        <div class="space-y-2 p-6 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created:</span>
                                <span
                                    class="font-semibold text-gray-900">{{ $flashSale->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Updated:</span>
                                <span
                                    class="font-semibold text-gray-900">{{ $flashSale->updated_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Flash Sale:</span>
                                <span class="font-mono font-semibold text-gray-900">#{{ $flashSale->id }}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function flashSaleEditForm() {
                return {
                    form: {
                        product_id: '{{ old('product_id', $flashSale->product_id) }}',
                        discount_percentage: {{ old('discount_percentage', $flashSale->discount_percentage) }},
                        start_time: '{{ old('start_time', $flashSale->start_time->format('Y-m-d\TH:i')) }}',
                        end_time: '{{ old('end_time', $flashSale->end_time->format('Y-m-d\TH:i')) }}',
                        status: '{{ old('status', $flashSale->status) }}',
                        discountAmount: 0,
                        discountedPrice: 0
                    },

                    original: {
                        product_id: '{{ $flashSale->product_id }}',
                        discount_percentage: {{ $flashSale->discount_percentage }},
                        start_time: '{{ $flashSale->start_time->format('Y-m-d\TH:i') }}',
                        end_time: '{{ $flashSale->end_time->format('Y-m-d\TH:i') }}',
                        status: '{{ $flashSale->status }}'
                    },

                    productInfo: {
                        name: '{{ $flashSale->product->name }}',
                        price: {{ $flashSale->product->price }},
                        game: '{{ $flashSale->product->game->name ?? 'N/A' }}'
                    },

                    discountChange: {
                        changed: false,
                        increased: false,
                        amount: 0
                    },

                    init() {
                        this.calculateDiscount();
                    },

                    updateProductInfo() {
                        const select = document.getElementById('product_id');
                        const option = select.options[select.selectedIndex];

                        if (option && option.value) {
                            this.productInfo.name = option.dataset.name;
                            this.productInfo.price = parseFloat(option.dataset.price);
                            this.productInfo.game = option.dataset.game;
                            this.calculateDiscount();
                        }
                    },

                    calculateDiscount() {
                        if (this.productInfo.price > 0 && this.form.discount_percentage > 0) {
                            this.form.discountAmount = (this.productInfo.price * this.form.discount_percentage) / 100;
                            this.form.discountedPrice = this.productInfo.price - this.form.discountAmount;
                        } else {
                            this.form.discountAmount = 0;
                            this.form.discountedPrice = this.productInfo.price;
                        }

                        // Calculate discount change
                        const newDiscount = parseFloat(this.form.discount_percentage);
                        const oldDiscount = parseFloat(this.original.discount_percentage);

                        this.discountChange.amount = newDiscount - oldDiscount;
                        this.discountChange.changed = this.discountChange.amount !== 0;
                        this.discountChange.increased = this.discountChange.amount > 0;
                    },

                    calculateDuration() {
                        if (!this.form.start_time || !this.form.end_time) return '';

                        const start = new Date(this.form.start_time);
                        const end = new Date(this.form.end_time);
                        const diff = end - start;

                        if (diff < 0) return 'Waktu berakhir harus setelah waktu mulai';

                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

                        let duration = '';
                        if (days > 0) duration += `${days} hari `;
                        if (hours > 0) duration += `${hours} jam `;
                        if (minutes > 0) duration += `${minutes} menit`;

                        return duration.trim() || '0 menit';
                    },

                    getStatusText() {
                        const now = new Date();
                        const start = new Date(this.form.start_time);
                        const end = new Date(this.form.end_time);

                        if (this.form.status !== 'active') return 'Nonaktif';
                        if (now < start) return 'Mendatang';
                        if (now > end) return 'Berakhir';
                        return 'Sedang Berjalan';
                    },

                    hasChanges() {
                        return this.form.product_id != this.original.product_id ||
                            this.discountChange.changed ||
                            this.form.start_time !== this.original.start_time ||
                            this.form.end_time !== this.original.end_time ||
                            this.form.status !== this.original.status;
                    },

                    formatCurrency(value) {
                        return 'Rp ' + parseInt(value).toLocaleString('id-ID');
                    },

                    formatDate(datetime) {
                        if (!datetime) return '';
                        const date = new Date(datetime);
                        return date.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                }
            }
        </script>
    @endpush
@endsection
