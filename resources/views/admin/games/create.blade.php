@extends('layouts.admin')

@section('title', 'Tambah Game')
@section('page-title', 'Tambah Game')

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
                href="{{ route('admin.games.index') }}"
                class="hover:text-indigo-600"
            >Game</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="font-medium text-gray-900">Tambah Game</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Game Baru</h1>
                <p class="mt-2 text-gray-600">Lengkapi informasi game untuk menambah katalog</p>
            </div>
            <a
                href="{{ route('admin.games.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <form
            action="{{ route('admin.games.store') }}"
            method="POST"
            enctype="multipart/form-data"
            x-data="gameForm()"
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
                                        <p class="text-sm text-gray-600">Data utama game</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6 p-6">
                                <!-- Game Name -->
                                <div>
                                    <label
                                        for="name"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Nama Game <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative mt-2">
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="{{ old('name') }}"
                                            required
                                            maxlength="255"
                                            x-model="gameName"
                                            placeholder="Contoh: Mobile Legends: Bang Bang"
                                            class="@error('name') border-red-500 @enderror w-full rounded-lg border-2 border-gray-300 px-4 py-3 pr-16 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        >
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400"
                                            x-text="gameName.length + '/255'"
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
                                        Gunakan nama resmi game
                                    </p>
                                </div>

                                <!-- Category -->
                                <div>
                                    <label
                                        for="category"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Kategori Game <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="category"
                                        name="category"
                                        required
                                        x-model="gameCategory"
                                        class="@error('category') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >
                                        <option value="">-- Pilih Kategori --</option>
                                        <option
                                            value="moba"
                                            {{ old('category') == 'moba' ? 'selected' : '' }}
                                        >MOBA</option>
                                        <option
                                            value="battle-royale"
                                            {{ old('category') == 'battle-royale' ? 'selected' : '' }}
                                        >Battle Royale</option>
                                        <option
                                            value="mmorpg"
                                            {{ old('category') == 'mmorpg' ? 'selected' : '' }}
                                        >MMORPG</option>
                                        <option
                                            value="fps"
                                            {{ old('category') == 'fps' ? 'selected' : '' }}
                                        >FPS</option>
                                        <option
                                            value="sports"
                                            {{ old('category') == 'sports' ? 'selected' : '' }}
                                        >Sports</option>
                                        <option
                                            value="others"
                                            {{ old('category') == 'others' ? 'selected' : '' }}
                                        >Lainnya</option>
                                    </select>
                                    @error('category')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Publisher -->
                                <div>
                                    <label
                                        for="publisher"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Publisher
                                    </label>
                                    <input
                                        type="text"
                                        id="publisher"
                                        name="publisher"
                                        value="{{ old('publisher') }}"
                                        x-model="gamePublisher"
                                        placeholder="Contoh: Moonton"
                                        class="@error('publisher') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >
                                    @error('publisher')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label
                                        for="description"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        Deskripsi Game
                                    </label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="5"
                                        x-model="gameDescription"
                                        placeholder="Jelaskan tentang game ini..."
                                        class="@error('description') border-red-500 @enderror mt-2 w-full rounded-lg border-2 border-gray-300 px-4 py-3 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    >{{ old('description') }}</textarea>
                                    <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                                        <span>
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Deskripsi membantu pelanggan mengenal game
                                        </span>
                                        <span x-text="gameDescription.length + ' karakter'"></span>
                                    </div>
                                    @error('description')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload Card -->
                        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div class="border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50 p-6">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-white">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Gambar Game</h2>
                                        <p class="text-sm text-gray-600">Upload cover/icon game</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <div>
                                    <label
                                        for="image"
                                        class="block text-sm font-semibold text-gray-700"
                                    >
                                        File Gambar <span class="text-red-500">*</span>
                                    </label>
                                    <div
                                        class="mt-2 flex justify-center rounded-lg border-2 border-dashed border-gray-300 px-6 py-10 transition hover:border-indigo-500"
                                        @dragover.prevent
                                        @drop.prevent="handleFileDrop($event)"
                                    >
                                        <div class="text-center">
                                            <i class="fas fa-cloud-upload-alt mb-3 text-5xl text-gray-400"></i>
                                            <div class="flex text-sm text-gray-600">
                                                <label
                                                    for="image"
                                                    class="relative cursor-pointer rounded-md font-semibold text-indigo-600 hover:text-indigo-500"
                                                >
                                                    <span>Upload file</span>
                                                    <input
                                                        id="image"
                                                        name="image"
                                                        type="file"
                                                        accept="image/*"
                                                        required
                                                        class="sr-only"
                                                        @change="handleFileSelect($event)"
                                                    >
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="mt-2 flex items-center text-sm text-red-600">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <!-- Image Preview -->
                                    <div
                                        x-show="imagePreview"
                                        class="mt-4"
                                        x-cloak
                                    >
                                        <p class="mb-2 text-sm font-semibold text-gray-700">Preview:</p>
                                        <div class="relative overflow-hidden rounded-lg border-2 border-gray-200">
                                            <img
                                                :src="imagePreview"
                                                alt="Preview"
                                                class="w-full"
                                            >
                                            <button
                                                type="button"
                                                @click="removeImage()"
                                                class="absolute right-2 top-2 rounded-full bg-red-500 p-2 text-white transition hover:bg-red-600"
                                            >
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <p
                                            class="mt-2 text-xs text-gray-500"
                                            x-text="'File: ' + imageName"
                                        ></p>
                                    </div>
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
                                        <span class="block font-semibold text-gray-900">Aktifkan Game</span>
                                        <span class="text-xs text-gray-600">Game akan tampil di katalog</span>
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
                                    <span class="text-gray-600">Kategori:</span>
                                    <span
                                        class="capitalize text-gray-900"
                                        x-text="gameCategory || '-'"
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
                                Preview Game
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="rounded-lg border-2 border-dashed border-gray-200 p-4">
                                <div
                                    class="mb-3 flex aspect-square items-center justify-center rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100">
                                    <template x-if="imagePreview">
                                        <img
                                            :src="imagePreview"
                                            alt="Preview"
                                            class="h-full w-full rounded-lg object-cover"
                                        >
                                    </template>
                                    <template x-if="!imagePreview">
                                        <i class="fas fa-gamepad text-4xl text-indigo-300"></i>
                                    </template>
                                </div>
                                <h4
                                    class="mb-2 font-bold text-gray-900"
                                    x-text="gameName || 'Nama Game'"
                                ></h4>
                                <p
                                    class="mb-3 line-clamp-2 text-xs text-gray-600"
                                    x-text="gameDescription || 'Deskripsi game akan tampil di sini...'"
                                ></p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-xs text-gray-500"
                                        x-text="gameCategory ? 'Kategori: ' + gameCategory : 'Pilih kategori'"
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
                            Tips Menambah Game
                        </h3>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Gunakan nama resmi game</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Upload gambar cover berkualitas tinggi</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Pilih kategori yang sesuai</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                <span>Tulis deskripsi yang menarik</span>
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
                            Simpan Game
                        </button>
                        <a
                            href="{{ route('admin.games.index') }}"
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
            function gameForm() {
                return {
                    gameName: '{{ old('name') }}',
                    gameCategory: '{{ old('category') }}',
                    gamePublisher: '{{ old('publisher') }}',
                    gameDescription: '{{ old('description') }}',
                    isActive: {{ old('is_active', 'true') ? 'true' : 'false' }},
                    imagePreview: null,
                    imageName: '',

                    handleFileSelect(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.previewImage(file);
                        }
                    },

                    handleFileDrop(event) {
                        const file = event.dataTransfer.files[0];
                        if (file && file.type.startsWith('image/')) {
                            document.getElementById('image').files = event.dataTransfer.files;
                            this.previewImage(file);
                        }
                    },

                    previewImage(file) {
                        this.imageName = file.name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    },

                    removeImage() {
                        this.imagePreview = null;
                        this.imageName = '';
                        document.getElementById('image').value = '';
                    }
                }
            }
        </script>
    @endpush
@endsection
