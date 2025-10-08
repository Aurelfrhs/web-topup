@extends('layouts.admin')

@section('title', 'Tambah Flash Sale')
@section('page-title', 'Tambah Flash Sale')

@section('content')
    <div class="space-y-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a
                href="{{ route('admin.dashboard') }}"
                class="hover:text-red-600"
            >
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a
                href="{{ route('admin.flash-sales.index') }}"
                class="hover:text-red-600"
            >Flash Sale</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="font-medium text-gray-900">Tambah Flash Sale</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Flash Sale Baru</h1>
                <p class="mt-2 text-gray-600">Buat promo flash sale untuk meningkatkan penjualan</p>
            </div>
            <a
                href="{{ route('admin.flash-sales.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <form
            action="{{ route('admin.flash-sales.store') }}"
            method="POST"
            x-data="flashSaleForm()"
        >
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">

                        <!-- Product Selection Card -->
                        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-red-50 to-pink-50 p-6">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-600 text-white">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Pilih Produk</h2>
                                        <p class="text-sm text-gray-600">Produk yang akan diberi flash sale</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6 p-6">
                                <!-- Product Selection -->
                                <div>
                                    <label
                                        for="product_id"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Produk <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="product_id"
                                        name="product_id"
                                        required
                                        x-model="selectedProduct"
                                        @change="updateProductInfo()"
                                        class="@error('product_id') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    >
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($products as $product)
                                            <option
                                                value="{{ $product->id }}"
                                                data-price="{{ $product->price }}"
                                                data-name="{{ $product->name }}"
                                                data-game="{{ $product->game->name ?? 'N/A' }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                                            >
                                                {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Product Info Preview -->
                                    <div
                                        x-show="productInfo.name"
                                        class="mt-3 rounded-lg border border-gray-200 bg-gray-50 p-4"
                                    >
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600">Produk Terpilih</p>
                                                <p
                                                    class="mt-1 font-bold text-gray-900"
                                                    x-text="productInfo.name"
                                                ></p>
                                                <p
                                                    class="text-sm text-gray-500"
                                                    x-text="productInfo.game"
                                                ></p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">Harga Normal</p>
                                                <p
                                                    class="mt-1 text-lg font-bold text-gray-900"
                                                    x-text="formatCurrency(productInfo.price)"
                                                ></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Discount & Stock Settings Card -->
                        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-orange-50 to-red-50 p-6">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-600 text-white">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Pengaturan Diskon & Stok</h2>
                                        <p class="text-sm text-gray-600">Tentukan diskon dan stok flash sale</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6 p-6">
                                <!-- Discount Percentage -->
                                <div>
                                    <label
                                        for="discount_percentage"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Persentase Diskon <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative mt-2">
                                        <input
                                            type="number"
                                            id="discount_percentage"
                                            name="discount_percentage"
                                            value="{{ old('discount_percentage') }}"
                                            required
                                            min="1"
                                            max="99"
                                            x-model="discountPercentage"
                                            @input="calculateDiscount()"
                                            placeholder="0"
                                            class="@error('discount_percentage') border-red-500 @enderror w-full rounded-lg border-2 border-gray-300 py-3 pl-4 pr-12 font-semibold transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        >
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 font-bold text-gray-600">%</span>
                                    </div>
                                    @error('discount_percentage')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Discount Calculator -->
                                    <div
                                        x-show="discountPercentage > 0 && productInfo.price > 0"
                                        class="mt-4 rounded-xl border-2 border-red-200 bg-gradient-to-r from-red-50 to-pink-50 p-6"
                                    >
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-700">Harga Normal:</span>
                                                <span
                                                    class="text-lg font-semibold text-gray-900 line-through"
                                                    x-text="formatCurrency(productInfo.price)"
                                                ></span>
                                            </div>
                                            <div class="flex items-center justify-between border-t border-red-200 pt-4">
                                                <span class="text-gray-700">Potongan Harga:</span>
                                                <span
                                                    class="text-lg font-semibold text-red-600"
                                                    x-text="'-' + formatCurrency(discountAmount)"
                                                ></span>
                                            </div>
                                            <div class="flex items-center justify-between border-t-2 border-red-300 pt-4">
                                                <span class="font-bold text-gray-900">Harga Flash Sale:</span>
                                                <span
                                                    class="text-2xl font-bold text-red-600"
                                                    x-text="formatCurrency(discountedPrice)"
                                                ></span>
                                            </div>
                                            <div class="mt-4 rounded-lg bg-white p-3">
                                                <p class="text-center text-sm font-semibold text-green-700">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    Pelanggan Hemat <span x-text="formatCurrency(discountAmount)"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label
                                        for="stock"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Stok Flash Sale <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative mt-2">
                                        <input
                                            type="number"
                                            id="stock"
                                            name="stock"
                                            value="{{ old('stock') }}"
                                            required
                                            min="1"
                                            placeholder="0"
                                            class="@error('stock') border-red-500 @enderror w-full rounded-lg border-2 border-gray-300 py-3 pl-4 pr-16 font-semibold transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        >
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-600"
                                        >Unit</span>
                                    </div>
                                    @error('stock')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Jumlah produk yang tersedia untuk flash sale
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Time Schedule Card -->
                        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 p-6">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-white">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Jadwal Flash Sale</h2>
                                        <p class="text-sm text-gray-600">Tentukan waktu mulai dan berakhir</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6 p-6">
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <!-- Start Time -->
                                    <div>
                                        <label
                                            for="start_time"
                                            class="block text-sm font-semibold text-gray-700"
                                        >
                                            Waktu Mulai <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="datetime-local"
                                            id="start_time"
                                            name="start_time"
                                            value="{{ old('start_time') }}"
                                            required
                                            x-model="startTime"
                                            class="@error('start_time') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                        @error('start_time')
                                            <div class="mt-2 flex items-center text-sm text-red-600">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- End Time -->
                                    <div>
                                        <label
                                            for="end_time"
                                            class="block text-sm font-semibold text-gray-700"
                                        >
                                            Waktu Berakhir <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="datetime-local"
                                            id="end_time"
                                            name="end_time"
                                            value="{{ old('end_time') }}"
                                            required
                                            x-model="endTime"
                                            class="@error('end_time') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        >
                                        @error('end_time')
                                            <div class="mt-2 flex items-center text-sm text-red-600">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Duration Info -->
                                <div
                                    x-show="startTime && endTime"
                                    class="rounded-lg border border-blue-200 bg-blue-50 p-4"
                                >
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                                        <div>
                                            <p class="font-semibold text-blue-900">Durasi Flash Sale</p>
                                            <p
                                                class="text-sm text-blue-700"
                                                x-text="calculateDuration()"
                                            ></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Status Card -->
                    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 p-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-toggle-on mr-2 text-red-600"></i>
                                Status Publikasi
                            </h3>
                        </div>
                        <div class="space-y-4 p-4">
                            <div class="rounded-lg bg-gradient-to-br from-red-50 to-pink-50 p-4">
                                <label class="flex cursor-pointer items-start space-x-3">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        x-model="isActive"
                                        {{ old('is_active', 1) ? 'checked' : '' }}
                                        class="mt-1 h-5 w-5 rounded border-gray-300 text-red-600 focus:ring-2 focus:ring-red-500"
                                    >
                                    <div class="flex-1">
                                        <span class="block font-semibold text-gray-900">Aktifkan Flash Sale</span>
                                        <span class="text-xs text-gray-600">Flash sale akan berjalan sesuai jadwal</span>
                                    </div>
                                </label>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                        x-text="isActive ? 'Aktif' : 'Nonaktif'"
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
                                Preview Flash Sale
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="rounded-lg border-2 border-dashed border-gray-200 p-4">
                                <div class="mb-3 rounded-lg bg-gradient-to-br from-red-500 to-pink-500 p-3">
                                    <div class="flex items-center justify-between text-white">
                                        <span class="text-xs font-semibold">FLASH SALE</span>
                                        <span
                                            class="rounded bg-white/20 px-2 py-1 text-xs font-bold backdrop-blur"
                                            x-text="discountPercentage ? discountPercentage + '%' : '0%'"
                                        ></span>
                                    </div>
                                </div>
                                <h4
                                    class="mb-2 font-bold text-gray-900"
                                    x-text="productInfo.name || 'Nama Produk'"
                                ></h4>
                                <div class="mb-3 flex items-center gap-2">
                                    <span
                                        class="text-sm text-gray-500 line-through"
                                        x-text="productInfo.price ? formatCurrency(productInfo.price) : 'Rp 0'"
                                    ></span>
                                    <span
                                        class="text-lg font-bold text-red-600"
                                        x-text="discountedPrice ? formatCurrency(discountedPrice) : 'Rp 0'"
                                    ></span>
                                </div>
                                <div
                                    class="flex items-center justify-between border-t border-gray-200 pt-3 text-xs text-gray-500">
                                    <span x-show="startTime">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span x-text="formatDate(startTime)"></span>
                                    </span>
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
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                        <h3 class="mb-3 flex items-center font-semibold text-red-900">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Tips Flash Sale Efektif
                        </h3>
                        <ul class="space-y-2 text-sm text-red-800">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-red-600"></i>
                                <span>Diskon 30-70% lebih menarik perhatian</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-red-600"></i>
                                <span>Durasi 1-24 jam paling optimal</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-red-600"></i>
                                <span>Jadwalkan di jam prime time</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-red-600"></i>
                                <span>Promosikan sebelum dimulai</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-red-600 to-pink-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:from-red-700 hover:to-pink-700 hover:shadow-xl"
                        >
                            <i class="fas fa-bolt mr-2"></i>
                            Buat Flash Sale
                        </button>
                        <a
                            href="{{ route('admin.flash-sales.index') }}"
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
            function flashSaleForm() {
                return {
                    selectedProduct: '{{ old('product_id') }}',
                    discountPercentage: {{ old('discount_percentage', 0) }},
                    startTime: '{{ old('start_time') }}',
                    endTime: '{{ old('end_time') }}',
                    isActive: {{ old('is_active', 1) ? 'true' : 'false' }},

                    productInfo: {
                        name: '',
                        price: 0,
                        game: ''
                    },

                    discountAmount: 0,
                    discountedPrice: 0,

                    init() {
                        if (this.selectedProduct) {
                            this.updateProductInfo();
                        }
                    },

                    updateProductInfo() {
                        const select = document.getElementById('product_id');
                        const option = select.options[select.selectedIndex];

                        if (option && option.value) {
                            this.productInfo.name = option.dataset.name;
                            this.productInfo.price = parseFloat(option.dataset.price);
                            this.productInfo.game = option.dataset.game;
                            this.calculateDiscount();
                        } else {
                            this.productInfo = {
                                name: '',
                                price: 0,
                                game: ''
                            };
                            this.discountAmount = 0;
                            this.discountedPrice = 0;
                        }
                    },

                    calculateDiscount() {
                        if (this.productInfo.price > 0 && this.discountPercentage > 0) {
                            this.discountAmount = (this.productInfo.price * this.discountPercentage) / 100;
                            this.discountedPrice = this.productInfo.price - this.discountAmount;
                        } else {
                            this.discountAmount = 0;
                            this.discountedPrice = this.productInfo.price;
                        }
                    },

                    calculateDuration() {
                        if (!this.startTime || !this.endTime) return '';

                        const start = new Date(this.startTime);
                        const end = new Date(this.endTime);
                        const diff = end - start;

                        if (diff < 0) return 'Waktu berakhir harus setelah waktu mulai';

                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

                        if (hours > 0) {
                            return `Durasi: ${hours} jam ${minutes} menit`;
                        }
                        return `Durasi: ${minutes} menit`;
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
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                }
            }
        </script>
    @endpush
@endsection
