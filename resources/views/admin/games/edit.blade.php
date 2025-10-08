@extends('layouts.admin')

@section('title', 'Edit Game')
@section('page-title', 'Edit Game')

@section('content')
    <div
        class="space-y-6"
        x-data="gameEditForm()"
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
                href="{{ route('admin.games.index') }}"
                class="transition hover:text-indigo-600"
            >Game</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="font-medium text-gray-900">Edit Game #{{ $game->id }}</span>
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
                    <h1 class="mb-2 text-3xl font-bold">{{ $game->name }}</h1>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span><i class="fas fa-hashtag mr-1"></i>ID: {{ $game->id }}</span>
                        <span><i class="fas fa-tag mr-1"></i>{{ ucfirst(str_replace('-', ' ', $game->category)) }}</span>
                        <span><i class="fas fa-calendar mr-1"></i>{{ $game->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <a
                    href="{{ route('admin.games.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border-2 border-white bg-white/10 px-6 py-3 font-semibold backdrop-blur transition hover:bg-white/20"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <form
            action="{{ route('admin.games.update', $game->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

                <!-- Main Content (8 columns) -->
                <div class="space-y-6 xl:col-span-8">

                    <!-- Game Information -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600"
                                >
                                    <i class="fas fa-gamepad text-sm"></i>
                                </span>
                                Informasi Game
                            </h2>
                        </div>

                        <div class="space-y-6 p-6">
                            <!-- Game Name -->
                            <div>
                                <label
                                    for="name"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Nama Game <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $game->name) }}"
                                        required
                                        maxlength="255"
                                        x-model="form.name"
                                        placeholder="Contoh: Mobile Legends: Bang Bang"
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

                            <!-- Category -->
                            <div>
                                <label
                                    for="category"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Kategori Game <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select
                                        id="category"
                                        name="category"
                                        required
                                        x-model="form.category"
                                        class="@error('category') border-red-300 @enderror w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-3 pr-10 font-medium transition focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                    >
                                        <option value="">-- Pilih Kategori --</option>
                                        <option
                                            value="moba"
                                            {{ old('category', $game->category) == 'moba' ? 'selected' : '' }}
                                        >MOBA</option>
                                        <option
                                            value="battle-royale"
                                            {{ old('category', $game->category) == 'battle-royale' ? 'selected' : '' }}
                                        >Battle Royale</option>
                                        <option
                                            value="mmorpg"
                                            {{ old('category', $game->category) == 'mmorpg' ? 'selected' : '' }}
                                        >MMORPG</option>
                                        <option
                                            value="fps"
                                            {{ old('category', $game->category) == 'fps' ? 'selected' : '' }}
                                        >FPS</option>
                                        <option
                                            value="sports"
                                            {{ old('category', $game->category) == 'sports' ? 'selected' : '' }}
                                        >Sports</option>
                                        <option
                                            value="others"
                                            {{ old('category', $game->category) == 'others' ? 'selected' : '' }}
                                        >Lainnya</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                @error('category')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div
                                    class="mt-2 rounded-lg bg-blue-50 px-3 py-2 text-sm text-blue-700"
                                    x-show="form.category != '{{ $game->category }}'"
                                >
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Kategori akan diubah dari
                                    <strong>{{ ucfirst(str_replace('-', ' ', $game->category)) }}</strong>
                                </div>
                            </div>

                            <!-- Publisher -->
                            <div>
                                <label
                                    for="publisher"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Publisher
                                </label>
                                <input
                                    type="text"
                                    id="publisher"
                                    name="publisher"
                                    value="{{ old('publisher', $game->publisher) }}"
                                    x-model="form.publisher"
                                    placeholder="Contoh: Moonton"
                                    class="@error('publisher') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 px-4 py-3 font-medium transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                >
                                @error('publisher')
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
                                    Deskripsi Game
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="6"
                                    x-model="form.description"
                                    placeholder="Tulis deskripsi lengkap tentang game ini..."
                                    class="@error('description') border-red-300 @enderror w-full rounded-lg border-2 border-gray-200 px-4 py-3 font-medium transition placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-50"
                                >{{ old('description', $game->description) }}</textarea>
                                <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                                    <span><i class="fas fa-info-circle mr-1"></i>Deskripsi yang detail membantu
                                        pelanggan</span>
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

                    <!-- Image Upload -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h2 class="flex items-center text-lg font-semibold text-gray-900">
                                <span
                                    class="mr-3 flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600"
                                >
                                    <i class="fas fa-image text-sm"></i>
                                </span>
                                Gambar Game
                            </h2>
                        </div>

                        <div class="space-y-6 p-6">
                            <!-- Current Image -->
                            @if ($game->image)
                                <div
                                    class="rounded-xl border-2 border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 p-4">
                                    <p class="mb-3 text-sm font-semibold text-gray-700">
                                        <i class="fas fa-image mr-2"></i>Gambar Saat Ini:
                                    </p>
                                    <div class="overflow-hidden rounded-lg border-2 border-gray-300">
                                        <img
                                            src="{{ Storage::url($game->image) }}"
                                            alt="{{ $game->name }}"
                                            class="w-full"
                                        >
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Kosongkan upload baru jika ingin mempertahankan gambar ini
                                    </p>
                                </div>
                            @endif

                            <!-- Upload New Image -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Upload Gambar Baru
                                </label>
                                <div
                                    class="flex justify-center rounded-lg border-2 border-dashed border-gray-300 px-6 py-10 transition hover:border-indigo-500"
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
                                                <span>Upload gambar baru</span>
                                                <input
                                                    id="image"
                                                    name="image"
                                                    type="file"
                                                    accept="image/*"
                                                    class="sr-only"
                                                    @change="handleFileSelect($event)"
                                                >
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                        <p class="mt-1 text-xs text-indigo-600">Rekomendasi: 512x512px untuk hasil terbaik
                                        </p>
                                    </div>
                                </div>
                                @error('image')
                                    <p class="mt-2 flex items-center text-sm text-red-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror

                                <!-- New Image Preview -->
                                <div
                                    x-show="imagePreview"
                                    class="mt-4"
                                    x-cloak
                                >
                                    <p class="mb-2 text-sm font-semibold text-gray-700">
                                        <i class="fas fa-eye mr-2"></i>Preview Gambar Baru:
                                    </p>
                                    <div class="relative overflow-hidden rounded-lg border-2 border-indigo-300">
                                        <img
                                            :src="imagePreview"
                                            alt="Preview"
                                            class="w-full"
                                        >
                                        <button
                                            type="button"
                                            @click="removeImage()"
                                            class="absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-full bg-red-500 text-white transition hover:bg-red-600"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2 rounded-lg bg-blue-50 p-2 text-xs text-blue-700">
                                        <i class="fas fa-file mr-1"></i>
                                        <span x-text="imageName"></span>
                                    </div>
                                </div>
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
                                    x-show="form.name !== '{{ $game->name }}'"
                                    class="flex items-center justify-between rounded-lg border border-purple-200 bg-purple-50 px-4 py-3"
                                >
                                    <span class="font-medium text-purple-900"><i class="fas fa-gamepad mr-2"></i>Nama
                                        Game</span>
                                    <span
                                        class="rounded-full bg-purple-200 px-3 py-1 text-xs font-bold text-purple-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.category !== '{{ $game->category }}'"
                                    class="flex items-center justify-between rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3"
                                >
                                    <span class="font-medium text-indigo-900"><i
                                            class="fas fa-tag mr-2"></i>Kategori</span>
                                    <span
                                        class="rounded-full bg-indigo-200 px-3 py-1 text-xs font-bold text-indigo-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.publisher !== '{{ $game->publisher }}'"
                                    class="flex items-center justify-between rounded-lg border border-blue-200 bg-blue-50 px-4 py-3"
                                >
                                    <span class="font-medium text-blue-900"><i
                                            class="fas fa-building mr-2"></i>Publisher</span>
                                    <span
                                        class="rounded-full bg-blue-200 px-3 py-1 text-xs font-bold text-blue-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="form.description !== '{{ $game->description }}'"
                                    class="flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3"
                                >
                                    <span class="font-medium text-green-900"><i
                                            class="fas fa-align-left mr-2"></i>Deskripsi</span>
                                    <span
                                        class="rounded-full bg-green-200 px-3 py-1 text-xs font-bold text-green-900">DIUBAH</span>
                                </div>
                                <div
                                    x-show="imagePreview"
                                    class="flex items-center justify-between rounded-lg border border-orange-200 bg-orange-50 px-4 py-3"
                                >
                                    <span class="font-medium text-orange-900"><i
                                            class="fas fa-image mr-2"></i>Gambar</span>
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
                                        {{ old('is_active', $game->is_active) ? 'checked' : '' }}
                                        class="mt-1 h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500"
                                    >
                                    <div class="ml-3 flex-1">
                                        <span class="block font-bold text-gray-900">Publikasikan Game</span>
                                        <span class="text-sm text-gray-600">Game akan tampil di katalog</span>
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
                                    <span class="text-gray-600">Kategori:</span>
                                    <span
                                        class="font-semibold capitalize text-gray-900"
                                        x-text="form.category"
                                    ></span>
                                </div>
                            </div>

                            <!-- Warning if deactivating -->
                            <div
                                x-show="!form.isActive && '{{ $game->is_active }}' == '1'"
                                class="rounded-lg border border-yellow-200 bg-yellow-50 p-3"
                            >
                                <div class="flex">
                                    <i class="fas fa-exclamation-triangle mr-2 mt-0.5 text-yellow-600"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-yellow-900">Game akan dinonaktifkan</p>
                                        <p class="mt-1 text-xs text-yellow-700">Game tidak akan tampil di katalog setelah
                                            disimpan</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="space-y-2 text-xs text-gray-500">
                                    <div class="flex justify-between">
                                        <span>Dibuat:</span>
                                        <span
                                            class="font-medium text-gray-700">{{ $game->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Terakhir diupdate:</span>
                                        <span
                                            class="font-medium text-gray-700">{{ $game->updated_at->format('d M Y') }}</span>
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
                                    class="flex aspect-square items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400">
                                    <template x-if="imagePreview">
                                        <img
                                            :src="imagePreview"
                                            alt="Preview"
                                            class="h-full w-full object-cover"
                                        >
                                    </template>
                                    <template x-if="!imagePreview">
                                        @if ($game->image)
                                            <img
                                                src="{{ Storage::url($game->image) }}"
                                                alt="{{ $game->name }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            <i class="fas fa-gamepad text-5xl text-white/50"></i>
                                        @endif
                                    </template>
                                </div>
                                <div class="p-4">
                                    <div class="mb-2 flex items-start justify-between">
                                        <h4
                                            class="line-clamp-2 flex-1 font-bold text-gray-900"
                                            x-text="form.name || 'Nama Game'"
                                        ></h4>
                                        <span
                                            class="ml-2 rounded-full px-2 py-1 text-xs font-bold"
                                            :class="form.isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                            x-text="form.isActive ? 'Aktif' : 'Draft'"
                                        ></span>
                                    </div>
                                    <p
                                        class="mb-3 line-clamp-2 text-sm text-gray-600"
                                        x-text="form.description || 'Deskripsi game...'"
                                    ></p>
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-tag mr-1"></i>
                                            <span
                                                class="capitalize"
                                                x-text="form.category"
                                            ></span>
                                        </span>
                                        <span
                                            class="text-xs text-gray-400"
                                            x-show="form.publisher"
                                        >
                                            <i class="fas fa-building mr-1"></i>
                                            <span x-text="form.publisher"></span>
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
                            href="{{ route('admin.games.index') }}"
                            class="flex w-full items-center justify-center rounded-xl border-2 border-gray-300 bg-white px-6 py-4 text-lg font-bold text-gray-700 transition hover:bg-gray-50"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>

                    <!-- Game Statistics -->
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <h3 class="font-semibold text-gray-900">
                                <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                                Statistik Game
                            </h3>
                        </div>
                        <div class="space-y-3 p-6">
                            <div class="flex items-center justify-between rounded-lg bg-blue-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                        <i class="fas fa-box text-blue-600"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Total Produk</span>
                                </div>
                                <span class="text-xl font-bold text-blue-600">{{ $game->products->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-green-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                                        <i class="fas fa-shopping-cart text-green-600"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Total Transaksi</span>
                                </div>
                                <span class="text-xl font-bold text-green-600">0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-purple-50 p-3">
                                <div class="flex items-center">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100">
                                        <i class="fas fa-star text-purple-600"></i>
                                    </div>
                                    <span class="ml-3 font-medium text-gray-700">Popularitas</span>
                                </div>
                                <span class="text-xl font-bold text-purple-600">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="overflow-hidden rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                        <div class="bg-blue-100 px-4 py-3">
                            <h3 class="flex items-center font-semibold text-blue-900">
                                <i class="fas fa-lightbulb mr-2"></i>
                                Tips Edit Game
                            </h3>
                        </div>
                        <div class="p-4">
                            <ul class="space-y-2 text-sm text-blue-800">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                    <span>Pastikan nama game tetap konsisten</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                    <span>Update gambar jika ada versi baru</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                    <span>Perbarui deskripsi secara berkala</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                                    <span>Periksa produk terkait sebelum menonaktifkan</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function gameEditForm() {
                return {
                    form: {
                        name: '{{ old('name', $game->name) }}',
                        category: '{{ old('category', $game->category) }}',
                        publisher: '{{ old('publisher', $game->publisher) }}',
                        description: '{{ old('description', $game->description) }}',
                        isActive: {{ old('is_active', $game->is_active) ? 'true' : 'false' }}
                    },

                    original: {
                        name: '{{ $game->name }}',
                        category: '{{ $game->category }}',
                        publisher: '{{ $game->publisher }}',
                        description: '{{ $game->description }}',
                        isActive: {{ $game->is_active ? 'true' : 'false' }}
                    },

                    imagePreview: null,
                    imageName: '',

                    init() {
                        // Initialization code if needed
                    },

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
                    },

                    hasChanges() {
                        return this.form.name !== this.original.name ||
                            this.form.category !== this.original.category ||
                            this.form.publisher !== this.original.publisher ||
                            this.form.description !== this.original.description ||
                            this.form.isActive !== this.original.isActive ||
                            this.imagePreview !== null;
                    }
                }
            }
        </script>
    @endpush
@endsection
