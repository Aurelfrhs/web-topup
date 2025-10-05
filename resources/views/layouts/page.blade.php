<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>@yield('title', 'TopUp Game Murah & Cepat')</title>
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >
    <style>
        body {
            background-color: hsl(241, 24%, 13%);
            color: white;
        }

        .modal {
            transition: opacity 0.25s ease;
        }

        body.modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
        }
    </style>
</head>

<body class="text-white">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-transparent bg-white/10 shadow-none backdrop-blur-md">
        <div class="container mx-auto px-4">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <a
                    href="{{ route('home') }}"
                    class="flex items-center space-x-2"
                >
                    <i class="fas fa-gamepad text-2xl text-white"></i>
                    <span class="text-xl font-bold text-white">TopUp Store</span>
                </a>

                <!-- Search Bar - Desktop -->
                <div class="mx-8 hidden max-w-md flex-1 md:flex">
                    <div class="relative w-full">
                        <input
                            type="text"
                            placeholder="Cari game favorit Anda..."
                            class="w-full rounded-lg px-4 py-2 pr-10 text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-300"
                        >
                        <button
                            class="absolute right-2 top-1/2 -translate-y-1/2 transform text-purple-600 hover:text-purple-800"
                        >
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Navigation Links - Desktop -->
                <div class="hidden items-center space-x-6 md:flex">
                    @guest
                        <!-- Login/Register Buttons -->
                        <button
                            onclick="openModal('loginModal')"
                            class="cursor-pointer"
                        >
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </button>
                        <button
                            onclick="openModal('registerModal')"
                            class="cursor-pointer"
                        >
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </button>
                    @else
                        <!-- User Dropdown -->
                        <div class="group relative">
                            <button class="flex items-center space-x-2 text-white transition hover:text-gray-200">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div
                                class="invisible absolute right-0 z-50 mt-2 w-48 rounded-lg bg-white opacity-0 shadow-lg transition-all duration-200 group-hover:visible group-hover:opacity-100">
                                <a
                                    href="/profile"
                                    class="block rounded-t-lg px-4 py-2 text-gray-800 hover:bg-gray-100"
                                >
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <a
                                    href="/orders"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                                >
                                    <i class="fas fa-shopping-bag mr-2"></i> Pesanan Saya
                                </a>
                                @if (Auth::user()->role === 'admin')
                                    <a
                                        href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                                    >
                                        <i class="fas fa-cog mr-2"></i> Admin Panel
                                    </a>
                                @endif
                                <hr class="my-1">
                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full rounded-b-lg px-4 py-2 text-left text-red-600 hover:bg-gray-100"
                                    >
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <button
                    id="mobile-menu-btn"
                    class="text-2xl text-white md:hidden"
                >
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Search Bar -->
            <div class="pb-4 md:hidden">
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Cari game favorit Anda..."
                        class="w-full rounded-lg px-4 py-2 pr-10 text-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-300"
                    >
                    <button
                        class="absolute right-2 top-1/2 -translate-y-1/2 transform text-purple-600 hover:text-purple-800"
                    >
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            id="mobile-menu"
            class="hidden md:hidden"
        >
            <div class="container mx-auto space-y-3 px-4 py-4">
                @guest
                    <div class="space-y-2 pt-3">
                        <button
                            onclick="openModal('loginModal')"
                            class="w-full rounded-lg border border-white px-4 py-2 text-center text-white transition hover:bg-white hover:text-gray-200 hover:text-purple-600"
                        >
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </button>
                        <button
                            onclick="openModal('registerModal')"
                            class="w-full rounded-lg bg-white px-4 py-2 text-center font-semibold text-purple-600 transition hover:bg-gray-100"
                        >
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </button>
                    </div>
                @else
                    <div class="border-t border-purple-600 pt-3">
                        <p class="mb-2 font-semibold text-white">
                            <i class="fas fa-user-circle mr-2"></i> {{ Auth::user()->name }}
                        </p>
                        <a
                            href="/profile"
                            class="block py-2 text-white transition hover:text-gray-200"
                        >
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <a
                            href="/orders"
                            class="block py-2 text-white transition hover:text-gray-200"
                        >
                            <i class="fas fa-shopping-bag mr-2"></i> Pesanan Saya
                        </a>
                        @if (Auth::user()->role === 'admin')
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="block py-2 text-white transition hover:text-gray-200"
                            >
                                <i class="fas fa-cog mr-2"></i> Admin Panel
                            </a>
                        @endif
                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                            class="mt-2"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="w-full py-2 text-left text-red-300 transition hover:text-red-100"
                            >
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div
        id="loginModal"
        class="modal pointer-events-none fixed left-0 top-0 z-50 flex h-full w-full items-center justify-center opacity-0"
    >
        <div
            class="modal-overlay absolute h-full w-full bg-gray-900 opacity-50"
            onclick="closeModal('loginModal')"
        ></div>

        <div class="modal-container z-50 mx-auto w-11/12 overflow-y-auto rounded-lg bg-white shadow-lg md:max-w-md">
            <div class="modal-content px-6 py-4 text-left">
                <!-- Title -->
                <div class="flex items-center justify-between border-b pb-3">
                    <p class="text-2xl font-bold text-purple-600">Login</p>
                    <button
                        onclick="closeModal('loginModal')"
                        class="modal-close z-50 cursor-pointer"
                    >
                        <i class="fas fa-times text-gray-500 hover:text-gray-700"></i>
                    </button>
                </div>

                <!-- Body -->
                <form
                    id="loginForm"
                    method="POST"
                    action="{{ route('login') }}"
                    class="mt-4"
                >
                    @csrf
                    <div
                        id="loginError"
                        class="mb-4 hidden rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700"
                    ></div>

                    <div class="mb-4">
                        <label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="login-email"
                        >
                            Email
                        </label>
                        <input
                            type="email"
                            id="login-email"
                            name="email"
                            required
                            class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="email@example.com"
                        >
                    </div>

                    <div class="mb-6">
                        <label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="login-password"
                        >
                            Password
                        </label>
                        <input
                            type="password"
                            id="login-password"
                            name="password"
                            required
                            class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="mb-4 flex items-center justify-between">
                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                class="form-checkbox text-purple-600"
                            >
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                        <a
                            href="#"
                            class="text-sm text-purple-600 hover:text-purple-800"
                        >Lupa Password?</a>
                    </div>

                    <button
                        type="submit"
                        class="focus:shadow-outline w-full rounded bg-purple-600 px-4 py-2 font-bold text-white transition hover:bg-purple-700 focus:outline-none"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </button>

                    <p class="mt-4 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a
                            href="#"
                            onclick="switchModal('loginModal', 'registerModal')"
                            class="font-semibold text-purple-600 hover:text-purple-800"
                        >Daftar Sekarang</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div
        id="registerModal"
        class="modal pointer-events-none fixed left-0 top-0 z-50 flex h-full w-full items-center justify-center opacity-0"
    >
        <div
            class="modal-overlay absolute h-full w-full bg-gray-900 opacity-50"
            onclick="closeModal('registerModal')"
        ></div>

        <div class="modal-container z-50 mx-auto w-11/12 overflow-y-auto rounded-lg bg-white shadow-lg md:max-w-md">
            <div class="modal-content px-6 py-4 text-left">
                <!-- Title -->
                <div class="flex items-center justify-between border-b pb-3">
                    <p class="text-2xl font-bold text-purple-600">Daftar</p>
                    <button
                        onclick="closeModal('registerModal')"
                        class="modal-close z-50 cursor-pointer"
                    >
                        <i class="fas fa-times text-gray-500 hover:text-gray-700"></i>
                    </button>
                </div>

                <!-- Body -->
                <form
                    id="registerForm"
                    method="POST"
                    action="{{ route('register') }}"
                    class="mt-4"
                >
                    @csrf
                    <div
                        id="registerError"
                        class="mb-4 hidden rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700"
                    ></div>

                    <div class="mb-4">
                        <label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="register-name"
                        >
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            id="register-name"
                            name="name"
                            required
                            class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="John Doe"
                        >
                    </div>

                    <div class="mb-4">
                        <label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="register-email"
                        >
                            Email
                        </label>
                        <input
                            type="email"
                            id="register-email"
                            name="email"
                            required
                            class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="email@example.com"
                        >
                    </div>

                    <div class="mb-4">
                        <label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="register-phone"
                        >
                            No. WhatsApp
                        </label>
                        <input
                            type="tel"
                            id="register-phone"
                            name="phone"
                            required
                            class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="08123456789"
                        >
                    </div>

                    <div class="mb-4">
                        <label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="register-password"
                        >
                            Password
                        </label>
                        <input
                            type="password"
                            id="register-password"
                            name="password"
                            required
                            class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="mb-6">
                        <label
                            class="mb-2 block text-sm font-bold text-gray-700"
                            for="register-password-confirmation"
                        >
                            Konfirmasi Password
                        </label>
                        <input
                            type="password"
                            id="register-password-confirmation"
                            name="password_confirmation"
                            required
                            class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="••••••••"
                        >
                    </div>

                    <button
                        type="submit"
                        class="focus:shadow-outline w-full rounded bg-purple-600 px-4 py-2 font-bold text-white transition hover:bg-purple-700 focus:outline-none"
                    >
                        <i class="fas fa-user-plus mr-2"></i> Daftar
                    </button>

                    <p class="mt-4 text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <a
                            href="#"
                            onclick="switchModal('registerModal', 'loginModal')"
                            class="font-semibold text-purple-600 hover:text-purple-800"
                        >Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <div class="min-h-screen">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-16 bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="grid gap-8 md:grid-cols-3">
                <div>
                    <h3 class="mb-4 text-lg font-bold">TopUp Store</h3>
                    <p class="text-gray-400">Platform top up game terpercaya dan termurah di Indonesia</p>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-bold">Kontak</h3>
                    <p class="text-gray-400"><i class="fas fa-envelope mr-2"></i> support@topupstore.com</p>
                    <p class="text-gray-400"><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</p>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-bold">Sosial Media</h3>
                    <div class="flex space-x-4">
                        <a
                            href="#"
                            class="text-gray-400 transition hover:text-white"
                        ><i class="fab fa-instagram text-2xl"></i></a>
                        <a
                            href="#"
                            class="text-gray-400 transition hover:text-white"
                        ><i class="fab fa-facebook text-2xl"></i></a>
                        <a
                            href="#"
                            class="text-gray-400 transition hover:text-white"
                        ><i class="fab fa-twitter text-2xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>&copy; 2025 TopUp Store. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Modal Functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('opacity-0');
            modal.classList.remove('pointer-events-none');
            document.body.classList.add('modal-active');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0');
            modal.classList.add('pointer-events-none');
            document.body.classList.remove('modal-active');
        }

        function switchModal(closeModalId, openModalId) {
            closeModal(closeModalId);
            setTimeout(() => openModal(openModalId), 200);
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('loginModal');
                closeModal('registerModal');
            }
        });

        // AJAX Login Form
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const errorDiv = document.getElementById('loginError');

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        errorDiv.textContent = data.message || 'Login gagal. Periksa email dan password Anda.';
                        errorDiv.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    errorDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                    errorDiv.classList.remove('hidden');
                });
        });

        // AJAX Register Form
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const errorDiv = document.getElementById('registerError');

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        errorDiv.textContent = data.message || 'Registrasi gagal. Periksa data Anda.';
                        errorDiv.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    errorDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                    errorDiv.classList.remove('hidden');
                });
        });
    </script>

    @stack('scripts')
</body>

</html>
