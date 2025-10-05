@extends('layouts.page')

@section('title', 'TopUp Game Murah & Cepat')

@section('content')
    <!-- Hero Carousel Section - Single Slide Design -->
    <div class="py-8 md:py-12 lg:py-16">
        <div class="container mx-auto px-4">
            <!-- Carousel Container -->
            <div class="relative">
                <!-- Carousel Wrapper -->
                <div class="overflow-hidden rounded-2xl">
                    <div
                        id="hero-carousel"
                        class="flex transition-transform duration-500 ease-out"
                    >
                        <!-- Example Slides - Replace with database banners -->
                        <!-- Slide 1 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <div
                                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 p-8 shadow-2xl md:p-12 lg:p-16">
                                <div class="relative z-10 mx-auto max-w-4xl">
                                    <div class="flex flex-col items-center text-center md:flex-row md:text-left">
                                        <div class="mb-6 flex-1 md:mb-0 md:pr-8">
                                            <div
                                                class="mb-4 inline-block rounded-full bg-white/20 px-4 py-2 text-xs font-semibold text-white backdrop-blur-sm md:text-sm">
                                                🔥 HOT PROMO
                                            </div>
                                            <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl lg:text-5xl">
                                                Diskon Hingga 20%
                                            </h2>
                                            <p class="mb-6 text-base text-white/90 md:text-lg lg:text-xl">
                                                Untuk semua game favorit kamu. Promo terbatas, buruan ambil sekarang!
                                            </p>
                                            <button
                                                class="rounded-full bg-white px-6 py-3 font-bold text-orange-500 shadow-lg transition hover:scale-105 hover:bg-orange-50 md:px-8 md:py-4 md:text-lg"
                                            >
                                                Ambil Promo Sekarang
                                            </button>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="rounded-2xl bg-white/10 p-6 backdrop-blur-sm md:p-8">
                                                <div class="text-center">
                                                    <div class="mb-2 text-6xl font-bold text-white md:text-7xl lg:text-8xl">
                                                        20%</div>
                                                    <div class="text-xl font-semibold text-white/90 md:text-2xl">OFF</div>
                                                    <div class="mt-4 text-sm text-white/80 md:text-base">Semua Game</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Decorative elements -->
                                <div
                                    class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-3xl md:h-60 md:w-60">
                                </div>
                                <div
                                    class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-white/10 blur-3xl md:h-60 md:w-60">
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <div
                                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 p-8 shadow-2xl md:p-12 lg:p-16">
                                <div class="relative z-10 mx-auto max-w-4xl">
                                    <div class="flex flex-col items-center text-center">
                                        <div
                                            class="mb-4 inline-block rounded-full bg-white/20 px-4 py-2 text-xs font-semibold text-white backdrop-blur-sm md:text-sm">
                                            ⚡ KEUNGGULAN KAMI
                                        </div>
                                        <h2 class="mb-6 text-3xl font-bold text-white md:text-4xl lg:text-5xl">
                                            Kenapa Pilih Kami?
                                        </h2>
                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-6">
                                            <div
                                                class="rounded-xl bg-white/10 p-6 backdrop-blur-sm transition hover:bg-white/20">
                                                <div
                                                    class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-white/20">
                                                    <i class="fas fa-bolt text-3xl text-yellow-300"></i>
                                                </div>
                                                <h3 class="mb-2 text-xl font-bold text-white">Proses Instan</h3>
                                                <p class="text-sm text-white/80">Diamond masuk dalam hitungan detik</p>
                                            </div>
                                            <div
                                                class="rounded-xl bg-white/10 p-6 backdrop-blur-sm transition hover:bg-white/20">
                                                <div
                                                    class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-white/20">
                                                    <i class="fas fa-shield-alt text-3xl text-green-300"></i>
                                                </div>
                                                <h3 class="mb-2 text-xl font-bold text-white">100% Aman</h3>
                                                <p class="text-sm text-white/80">Transaksi dijamin aman dan terpercaya</p>
                                            </div>
                                            <div
                                                class="rounded-xl bg-white/10 p-6 backdrop-blur-sm transition hover:bg-white/20">
                                                <div
                                                    class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-white/20">
                                                    <i class="fas fa-headset text-3xl text-blue-300"></i>
                                                </div>
                                                <h3 class="mb-2 text-xl font-bold text-white">CS 24/7</h3>
                                                <p class="text-sm text-white/80">Customer service siap membantu kapan saja
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <div
                                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 p-8 shadow-2xl md:p-12 lg:p-16">
                                <div class="relative z-10 mx-auto max-w-4xl">
                                    <div class="flex flex-col items-center text-center md:flex-row md:text-left">
                                        <div class="mb-6 flex-1 md:mb-0 md:pr-8">
                                            <div
                                                class="mb-4 inline-block rounded-full bg-white/20 px-4 py-2 text-xs font-semibold text-white backdrop-blur-sm md:text-sm">
                                                🎁 BONUS MEMBER BARU
                                            </div>
                                            <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl lg:text-5xl">
                                                Member Baru?
                                            </h2>
                                            <p class="mb-6 text-base text-white/90 md:text-lg lg:text-xl">
                                                Daftar sekarang dan dapatkan voucher gratis senilai 50 ribu rupiah!
                                            </p>
                                            <button
                                                onclick="openModal('registerModal')"
                                                class="rounded-full bg-white px-6 py-3 font-bold text-pink-600 shadow-lg transition hover:scale-105 hover:bg-pink-50 md:px-8 md:py-4 md:text-lg"
                                            >
                                                Daftar Sekarang
                                            </button>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="rounded-2xl bg-white/10 p-6 backdrop-blur-sm md:p-8">
                                                <div class="text-center">
                                                    <i
                                                        class="fas fa-ticket-alt mb-4 text-5xl text-yellow-300 md:text-6xl"></i>
                                                    <div class="mb-2 text-4xl font-bold text-white md:text-5xl">50K</div>
                                                    <div class="text-lg text-white/90">Voucher Gratis</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Decorative elements -->
                                <div
                                    class="absolute right-0 top-0 h-32 w-32 rounded-full bg-white/10 blur-2xl md:h-48 md:w-48">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 h-32 w-32 rounded-full bg-white/10 blur-2xl md:h-48 md:w-48">
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <div
                                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-500 to-teal-600 p-8 shadow-2xl md:p-12 lg:p-16">
                                <div class="relative z-10 mx-auto max-w-4xl text-center">
                                    <div
                                        class="mb-4 inline-block rounded-full bg-white/20 px-4 py-2 text-xs font-semibold text-white backdrop-blur-sm md:text-sm">
                                        💎 REWARD SYSTEM
                                    </div>
                                    <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl lg:text-5xl">
                                        Bonus Poin Setiap Transaksi
                                    </h2>
                                    <p class="mb-8 text-base text-white/90 md:text-lg lg:text-xl">
                                        Kumpulkan poin dan tukar dengan reward menarik atau diskon khusus!
                                    </p>
                                    <div class="mx-auto max-w-2xl rounded-2xl bg-white/10 p-6 backdrop-blur-sm md:p-8">
                                        <div class="mb-4 flex items-center justify-between text-white">
                                            <span class="text-sm md:text-base">Setiap Rp 10.000</span>
                                            <span class="text-lg font-bold md:text-xl">= 10 Poin</span>
                                        </div>
                                        <div class="mb-4 h-4 overflow-hidden rounded-full bg-white/20">
                                            <div
                                                class="h-full w-3/4 rounded-full bg-gradient-to-r from-yellow-300 to-yellow-400">
                                            </div>
                                        </div>
                                        <p class="text-sm text-white/80">1000 poin = Voucher 100K</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 5 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <div
                                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-700 p-8 shadow-2xl md:p-12 lg:p-16">
                                <div class="relative z-10 mx-auto max-w-4xl text-center">
                                    <div
                                        class="mb-4 inline-block rounded-full bg-white/20 px-4 py-2 text-xs font-semibold text-white backdrop-blur-sm md:text-sm">
                                        ⭐ TERPERCAYA
                                    </div>
                                    <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl lg:text-5xl">
                                        Dipercaya Ribuan User
                                    </h2>
                                    <p class="mb-8 text-base text-white/90 md:text-lg lg:text-xl">
                                        Telah melayani lebih dari 50.000+ transaksi dengan rating tertinggi
                                    </p>
                                    <div class="grid grid-cols-3 gap-4 md:gap-6">
                                        <div class="rounded-xl bg-white/10 p-4 backdrop-blur-sm md:p-6">
                                            <div class="mb-2 text-3xl font-bold text-white md:text-5xl">50K+</div>
                                            <div class="text-xs text-white/80 md:text-sm">Transaksi</div>
                                        </div>
                                        <div class="rounded-xl bg-white/10 p-4 backdrop-blur-sm md:p-6">
                                            <div class="mb-2 text-3xl font-bold text-white md:text-5xl">4.9</div>
                                            <div class="text-xs text-white/80 md:text-sm">Rating ⭐</div>
                                        </div>
                                        <div class="rounded-xl bg-white/10 p-4 backdrop-blur-sm md:p-6">
                                            <div class="mb-2 text-3xl font-bold text-white md:text-5xl">24/7</div>
                                            <div class="text-xs text-white/80 md:text-sm">Support</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add more slides from database here -->
                        <!-- @foreach ($banners as $banner)
    -->
                        <!-- <div class="carousel-slide w-full flex-shrink-0">
                                                                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-600 to-blue-600 p-8 shadow-2xl md:p-12 lg:p-16">
                                                                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="absolute inset-0 h-full w-full object-cover opacity-20">
                                                                    <div class="relative z-10 mx-auto max-w-4xl">
                                                                        {{ $banner->content }}
                                                                    </div>
                                                                </div>
                                                            </div> -->
                        <!--
    @endforeach -->
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button
                    onclick="prevSlide()"
                    class="absolute left-2 top-1/2 z-10 -translate-y-1/2 transform rounded-full bg-white/90 p-2 shadow-lg transition hover:scale-110 hover:bg-white md:left-4 md:p-3"
                >
                    <i class="fas fa-chevron-left text-sm text-gray-800 md:text-base"></i>
                </button>
                <button
                    onclick="nextSlide()"
                    class="absolute right-2 top-1/2 z-10 -translate-y-1/2 transform rounded-full bg-white/90 p-2 shadow-lg transition hover:scale-110 hover:bg-white md:right-4 md:p-3"
                >
                    <i class="fas fa-chevron-right text-sm text-gray-800 md:text-base"></i>
                </button>
            </div>

            <!-- Carousel Indicators -->
            <div class="mt-6 flex justify-center space-x-2">
                <button
                    onclick="goToSlide(0)"
                    class="carousel-indicator h-2 w-8 rounded-full bg-white/40 transition-all duration-300 hover:bg-white/60"
                ></button>
                <button
                    onclick="goToSlide(1)"
                    class="carousel-indicator h-2 w-8 rounded-full bg-white/40 transition-all duration-300 hover:bg-white/60"
                ></button>
                <button
                    onclick="goToSlide(2)"
                    class="carousel-indicator h-2 w-8 rounded-full bg-white/40 transition-all duration-300 hover:bg-white/60"
                ></button>
                <button
                    onclick="goToSlide(3)"
                    class="carousel-indicator h-2 w-8 rounded-full bg-white/40 transition-all duration-300 hover:bg-white/60"
                ></button>
                <button
                    onclick="goToSlide(4)"
                    class="carousel-indicator h-2 w-8 rounded-full bg-white/40 transition-all duration-300 hover:bg-white/60"
                ></button>
            </div>
        </div>
    </div>

    <!-- Popular Games Section -->
    <div class="bg-gradient-to-b from-gray-900 to-gray-800 py-12">
        <div class="container mx-auto px-4">
            <div class="mb-8 flex items-center">
                <span class="mr-3 text-3xl">🔥</span>
                <div>
                    <h2 class="text-2xl font-bold text-white md:text-3xl">POPULER SEKARANG!</h2>
                    <p class="text-sm text-gray-400">Berikut adalah beberapa produk yang paling populer saat ini.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($games->take(9) as $index => $game)
                    @php
                        $gradients = [
                            'from-blue-500 to-blue-700',
                            'from-pink-500 to-pink-700',
                            'from-cyan-500 to-cyan-700',
                            'from-purple-500 to-purple-700',
                            'from-gray-500 to-gray-700',
                            'from-orange-500 to-orange-700',
                            'from-indigo-500 to-indigo-700',
                            'from-green-500 to-green-700',
                            'from-red-500 to-red-700',
                        ];
                        $gradient = $gradients[$index % count($gradients)];
                    @endphp
                    <a
                        href="{{ route('game.show', $game->slug) }}"
                        class="{{ $gradient }} group relative overflow-hidden rounded-2xl bg-gradient-to-br p-6 shadow-lg transition duration-300 hover:scale-105 hover:shadow-2xl"
                    >
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-xl bg-white/20 backdrop-blur-sm transition-transform duration-300 group-hover:scale-110">
                                    <i class="fas fa-gamepad text-4xl text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="mb-1 text-lg font-bold text-white md:text-xl">{{ $game->name }}</h3>
                                <p class="text-sm text-white/80">{{ $game->description ?? 'Publisher Name' }}</p>
                            </div>
                        </div>
                        <!-- Decorative diagonal lines -->
                        <div class="absolute -right-8 -top-8 h-32 w-32 rotate-45 bg-white/10"></div>
                        <div class="absolute -bottom-8 -left-8 h-32 w-32 rotate-45 bg-white/10"></div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Games Section -->
    <div class="bg-gray-900 py-12">
        <div class="container mx-auto px-4">
            <!-- Category Tabs -->
            <div class="mb-8 flex flex-wrap gap-2 overflow-x-auto pb-2">
                <button
                    class="game-tab active whitespace-nowrap rounded-lg bg-gray-700 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-600"
                >
                    Top Up Games
                </button>
                <button
                    class="game-tab whitespace-nowrap rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700"
                >
                    Joki MLBB
                </button>
                <button
                    class="game-tab whitespace-nowrap rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700"
                >
                    Joki HOK
                </button>
                <button
                    class="game-tab whitespace-nowrap rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700"
                >
                    Top Up via LINK
                </button>
                <button
                    class="game-tab whitespace-nowrap rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700"
                >
                    Pulsa & Data
                </button>
                <button
                    class="game-tab whitespace-nowrap rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700"
                >
                    Voucher
                </button>
                <button
                    class="game-tab whitespace-nowrap rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700"
                >
                    Entertaiment
                </button>
                <button
                    class="game-tab whitespace-nowrap rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700"
                >
                    Tagihan
                </button>
            </div>

            <!-- Games Grid -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach ($games as $game)
                    <a
                        href="{{ route('game.show', $game->slug) }}"
                        class="group transform overflow-hidden rounded-xl bg-gray-800 shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-2xl"
                    >
                        <div class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-purple-500 to-blue-600">
                            <i
                                class="fas fa-gamepad absolute inset-0 flex items-center justify-center text-5xl text-white transition-transform duration-300 group-hover:scale-110"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .carousel-indicator.active {
            background-color: white;
            width: 3rem;
        }

        /* Smooth carousel transition */
        #hero-carousel {
            scroll-behavior: smooth;
        }
    </style>

    <script>
        // Hero Carousel - Single slide view for all devices
        let currentSlide = 0;
        const totalSlides = 5; // Update this based on number of slides from database
        let autoplayInterval;
        let touchStartX = 0;
        let touchEndX = 0;

        function updateCarousel() {
            const carousel = document.getElementById('hero-carousel');
            const offset = currentSlide * 100;

            carousel.style.transform = `translateX(-${offset}%)`;

            // Update indicators
            const indicators = document.querySelectorAll('.carousel-indicator');
            indicators.forEach((indicator, index) => {
                if (index === currentSlide) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateCarousel();
            resetAutoplay();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateCarousel();
            resetAutoplay();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
            resetAutoplay();
        }

        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        function resetAutoplay() {
            clearInterval(autoplayInterval);
            startAutoplay();
        }

        // Touch events for mobile swipe
        function handleTouchStart(e) {
            touchStartX = e.changedTouches[0].screenX;
        }

        function handleTouchEnd(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide(); // Swipe left
                } else {
                    prevSlide(); // Swipe right
                }
            }
        }

        // Games Carousel Scroll
        function scrollGames(direction) {
            const carousel = document.getElementById('games-carousel');
            const scrollAmount = window.innerWidth < 768 ? 240 : 300;

            if (direction === 'left') {
                carousel.scrollLeft -= scrollAmount;
            } else {
                carousel.scrollLeft += scrollAmount;
            }
        }

        // Initialize carousel
        document.addEventListener('DOMContentLoaded', function() {
            updateCarousel();
            startAutoplay();

            // Add touch event listeners for swipe on mobile
            const carouselContainer = document.getElementById('hero-carousel');
            if (carouselContainer) {
                carouselContainer.addEventListener('touchstart', handleTouchStart, {
                    passive: true
                });
                carouselContainer.addEventListener('touchend', handleTouchEnd, {
                    passive: true
                });
            }

            // Pause autoplay on hover (desktop only)
            const carouselWrapper = carouselContainer?.parentElement;
            if (carouselWrapper && window.innerWidth >= 768) {
                carouselWrapper.addEventListener('mouseenter', function() {
                    clearInterval(autoplayInterval);
                });

                carouselWrapper.addEventListener('mouseleave', function() {
                    startAutoplay();
                });
            }
        });
    </script>
@endpush
