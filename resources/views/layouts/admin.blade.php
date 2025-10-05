<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js untuk interaktivitas -->
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

    <!-- Font Awesome untuk icon -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body
    class="bg-gray-100"
    x-data="{ sidebarOpen: true, mobileMenuOpen: false }"
>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 transform bg-gradient-to-b from-indigo-900 to-indigo-700 text-white transition-transform duration-300 ease-in-out lg:translate-x-0"
        :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        x-cloak
    >
        <!-- Logo -->
        <div class="flex h-16 items-center justify-between border-b border-indigo-600 px-6">
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center space-x-2"
            >
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white">
                    <i class="fas fa-gamepad text-indigo-700"></i>
                </div>
                <span class="text-xl font-bold">TopUp Admin</span>
            </a>
            <button
                @click="mobileMenuOpen = false"
                class="lg:hidden"
            >
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="h-[calc(100vh-4rem)] space-y-2 overflow-y-auto px-4 py-6">
            <!-- Dashboard -->
            <a
                href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>

            <!-- Banners -->
            <a
                href="{{ route('admin.banners.index') }}"
                class="{{ request()->routeIs('admin.banners*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-flag w-5"></i>
                <span>Banner</span>
            </a>

            <!-- Products -->
            <a
                href="{{ route('admin.products.index') }}"
                class="{{ request()->routeIs('admin.products*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-box w-5"></i>
                <span>Produk</span>
            </a>

            <!-- Games -->
            <a
                href="{{ route('admin.games.index') }}"
                class="{{ request()->routeIs('admin.games*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-gamepad w-5"></i>
                <span>Game</span>
            </a>

            <!-- Flash Sales -->
            <a
                href="{{ route('admin.flash-sales.index') }}"
                class="{{ request()->routeIs('admin.flash-sales*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-bolt w-5"></i>
                <span>Flash Sale</span>
            </a>

            <!-- Transactions -->
            <a
                href="{{ route('admin.orders.index') }}"
                class="{{ request()->routeIs('admin.orders*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-receipt w-5"></i>
                <span>Transaksi</span>
            </a>

            <!-- Payments -->
            <a
                href="{{ route('admin.payments.index') }}"
                class="{{ request()->routeIs('admin.payments*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-credit-card w-5"></i>
                <span>Metode Pembayaran</span>
            </a>

            <!-- Users -->
            <a
                href="{{ route('admin.users.index') }}"
                class="{{ request()->routeIs('admin.users*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-users w-5"></i>
                <span>Pengguna</span>
            </a>

            <!-- News -->
            <a
                href="{{ route('admin.news.index') }}"
                class="{{ request()->routeIs('admin.news*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-newspaper w-5"></i>
                <span>Berita</span>
            </a>

            <!-- Settings -->
            <a
                href="{{ route('admin.settings.index') }}"
                class="{{ request()->routeIs('admin.settings*') ? 'bg-indigo-600' : '' }} flex items-center space-x-3 rounded-lg px-4 py-3 transition hover:bg-indigo-600"
            >
                <i class="fas fa-cog w-5"></i>
                <span>Pengaturan</span>
            </a>

            <!-- Divider -->
            <div class="my-4 border-t border-indigo-600"></div>

            <!-- Logout -->
            <form
                action="{{ route('logout') }}"
                method="POST"
            >
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center space-x-3 rounded-lg px-4 py-3 text-left transition hover:bg-red-600"
                >
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-64">
        <!-- Top Navigation -->
        <header class="sticky top-0 z-40 bg-white shadow-sm">
            <div class="flex h-16 items-center justify-between px-4 lg:px-8">
                <!-- Mobile Menu Button -->
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden"
                >
                    <i class="fas fa-bars text-xl text-gray-600"></i>
                </button>

                <!-- Page Title -->
                <h1 class="hidden text-xl font-semibold text-gray-800 lg:block">
                    @yield('page-title', 'Dashboard')
                </h1>

                <!-- Right Section -->
                <div
                    class="flex items-center space-x-4"
                    x-data="{ notificationOpen: false, profileOpen: false }"
                >
                    <!-- Notification -->
                    <div class="relative">
                        <button
                            @click="notificationOpen = !notificationOpen"
                            class="relative rounded-lg p-2 text-gray-600 hover:bg-gray-100"
                        >
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div
                            x-show="notificationOpen"
                            @click.away="notificationOpen = false"
                            x-cloak
                            class="absolute right-0 mt-2 w-80 rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                            <div class="border-b border-gray-200 p-4">
                                <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <a
                                    href="#"
                                    class="block border-b border-gray-100 p-4 hover:bg-gray-50"
                                >
                                    <p class="text-sm font-medium text-gray-800">Transaksi baru masuk</p>
                                    <p class="mt-1 text-xs text-gray-500">5 menit yang lalu</p>
                                </a>
                                <a
                                    href="#"
                                    class="block border-b border-gray-100 p-4 hover:bg-gray-50"
                                >
                                    <p class="text-sm font-medium text-gray-800">Pengguna baru terdaftar</p>
                                    <p class="mt-1 text-xs text-gray-500">1 jam yang lalu</p>
                                </a>
                            </div>
                            <a
                                href="#"
                                class="block p-3 text-center text-sm font-medium text-indigo-600 hover:bg-gray-50"
                            >
                                Lihat Semua
                            </a>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button
                            @click="profileOpen = !profileOpen"
                            class="flex items-center space-x-2 rounded-lg p-2 hover:bg-gray-100"
                        >
                            <img
                                src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=4f46e5&color=fff"
                                alt="Profile"
                                class="h-8 w-8 rounded-full"
                            >
                            <span
                                class="hidden text-sm font-medium text-gray-700 md:block">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-600"></i>
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <div
                            x-show="profileOpen"
                            @click.away="profileOpen = false"
                            x-cloak
                            class="absolute right-0 mt-2 w-48 rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                            >
                                <i class="fas fa-user w-5"></i> Profil
                            </a>
                            <a
                                href="{{ route('admin.settings.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                            >
                                <i class="fas fa-cog w-5"></i> Pengaturan
                            </a>
                            <hr class="my-1">
                            <form
                                action="{{ route('logout') }}"
                                method="POST"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-50"
                                >
                                    <i class="fas fa-sign-out-alt w-5"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 lg:p-8">
            <!-- Alert Messages -->
            @if (session('success'))
                <div
                    class="mb-6 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800"
                    x-data="{ show: true }"
                    x-show="show"
                >
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button
                        @click="show = false"
                        class="text-green-600 hover:text-green-800"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 flex items-center justify-between rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800"
                    x-data="{ show: true }"
                    x-show="show"
                >
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button
                        @click="show = false"
                        class="text-red-600 hover:text-red-800"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="mt-8 border-t border-gray-200 bg-white">
            <div class="px-4 py-4 text-center text-sm text-gray-600 lg:px-8">
                &copy; {{ date('Y') }} TopUp Store. All rights reserved.
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>
