@extends('layouts.admin')

@section('title', 'Kelola Banner')
@section('page-title', 'Kelola Banner')

@section('content')
    <div
        class="space-y-6"
        x-data="bannerManager()"
    >

        <!-- Header Actions -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Banner</h2>
                <p class="mt-1 text-sm text-gray-600">Kelola banner promosi dan tampilan visual</p>
            </div>
            <a
                href="{{ route('admin.banners.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl"
            >
                <i class="fas fa-plus mr-2"></i>
                Tambah Banner
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
                        placeholder="Cari banner berdasarkan judul..."
                        value="{{ request('search') }}"
                        class="w-full rounded-lg border-2 border-gray-200 py-2 pl-11 pr-4 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                </div>
                <div class="w-full md:w-56">
                    <select
                        name="position"
                        class="w-full rounded-lg border-2 border-gray-200 px-4 py-2 transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100"
                    >
                        <option value="">📍 Semua Posisi</option>
                        <option
                            value="home"
                            {{ request('position') == 'home' ? 'selected' : '' }}
                        >Home</option>
                        <option
                            value="games"
                            {{ request('position') == 'games' ? 'selected' : '' }}
                        >Games</option>
                        <option
                            value="flash-sale"
                            {{ request('position') == 'flash-sale' ? 'selected' : '' }}
                        >Flash Sale</option>
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

        <!-- Banners Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($banners as $banner)
                <div
                    class="group overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition hover:shadow-lg">
                    <!-- Banner Image -->
                    <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100">
                        @if ($banner->image)
                            <img
                                src="{{ asset('storage/' . $banner->image) }}"
                                alt="{{ $banner->title }}"
                                class="h-full w-full object-cover transition group-hover:scale-105"
                            >
                        @else
                            <div class="flex h-full items-center justify-center">
                                <i class="fas fa-image text-5xl text-indigo-300"></i>
                            </div>
                        @endif

                        <!-- Position Badge -->
                        <div class="absolute left-3 top-3">
                            <span
                                class="rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-gray-900 shadow backdrop-blur"
                            >
                                {{ ucfirst($banner->position) }}
                            </span>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute right-3 top-3">
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
                        </div>
                    </div>

                    <!-- Banner Info -->
                    <div class="p-4">
                        <h3 class="mb-2 font-bold text-gray-900">{{ $banner->title }}</h3>
                        @if ($banner->description)
                            <p class="mb-3 line-clamp-2 text-sm text-gray-600">{{ $banner->description }}</p>
                        @endif

                        @if ($banner->link)
                            <div class="mb-3 flex items-center text-xs text-indigo-600">
                                <i class="fas fa-link mr-1"></i>
                                <span class="truncate">{{ Str::limit($banner->link, 30) }}</span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $banner->created_at->format('d M Y') }}
                            </span>
                            <span>#{{ $banner->id }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex border-t border-gray-100 bg-gray-50">
                        <a
                            href="{{ route('admin.banners.edit', $banner->id) }}"
                            class="flex flex-1 items-center justify-center py-3 font-semibold text-indigo-600 transition hover:bg-indigo-50"
                        >
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        <button
                            @click="confirmDelete({{ $banner->id }}, '{{ $banner->title }}')"
                            class="flex flex-1 items-center justify-center border-l border-gray-100 py-3 font-semibold text-red-600 transition hover:bg-red-50"
                        >
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-xl border border-gray-100 bg-white p-16 text-center shadow-sm">
                    <div class="flex flex-col items-center justify-center">
                        <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                            <i class="fas fa-images text-3xl text-gray-300"></i>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900">Belum ada banner</h3>
                        <p class="mb-4 text-sm text-gray-500">Mulai tambahkan banner untuk promosi</p>
                        <a
                            href="{{ route('admin.banners.create') }}"
                            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                        >
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Banner Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($banners->hasPages())
            <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                {{ $banners->links() }}
            </div>
        @endif

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
                        <p class="mb-3 text-gray-900">Anda akan menghapus banner:</p>
                        <div class="rounded-lg border border-red-200 bg-white p-3">
                            <p
                                class="font-bold text-gray-900"
                                x-text="deleteModal.bannerTitle"
                            ></p>
                            <p class="text-sm text-gray-600">ID: #<span x-text="deleteModal.bannerId"></span></p>
                        </div>
                    </div>

                    <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4">
                        <div class="flex">
                            <i class="fas fa-lightbulb mr-3 mt-0.5 text-yellow-600"></i>
                            <div>
                                <p class="font-semibold text-yellow-900">Perhatian</p>
                                <p class="text-sm text-yellow-800">Banner dan gambar terkait akan dihapus permanen</p>
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
                        bannerTitle: ''
                    },

                    confirmDelete(bannerId, bannerTitle) {
                        this.deleteModal.bannerId = bannerId;
                        this.deleteModal.bannerTitle = bannerTitle;
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
