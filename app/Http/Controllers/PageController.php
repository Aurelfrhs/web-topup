<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Product;
use App\Models\News;
use App\Models\Banner;
use App\Models\FlashSale;
use App\Models\Order;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display homepage
     */
    public function index()
    {
        // Get active banners for homepage
        $banners = Banner::where('is_active', true)
            ->where('position', 'home')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get popular/featured games
        $games = Game::where('is_active', true)
            ->with([
                'products' => function ($query) {
                    $query->where('is_active', true)->orderBy('price', 'asc');
                }
            ])
            ->take(8)
            ->get();

        // Get active flash sales
        $flashSales = FlashSale::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with(['product.game'])
            ->take(4)
            ->get();

        // Get latest news
        $news = News::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get statistics
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_orders' => Order::where('status', 'success')->count(),
            'total_games' => Game::where('is_active', true)->count(),
        ];

        return view('page.index', compact(
            'banners',
            'games',
            'flashSales',
            'news',
            'stats'
        ));
    }

    /**
     * Display all games
     */
    public function games(Request $request)
    {
        $query = Game::where('is_active', true)->with('products');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $games = $query->paginate(12);

        // Get categories for filter
        $categories = Game::where('is_active', true)
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('games', compact('games', 'categories'));
    }

    /**
     * Display game detail with products
     */
    public function showGame($slug)
    {
        // Find game by slug or name
        $game = Game::where('is_active', true)
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('name', 'like', '%' . str_replace('-', ' ', $slug) . '%')
                    ->orWhere('id', $slug);
            })
            ->with([
                'products' => function ($query) {
                    $query->where('is_active', true)->orderBy('price', 'asc');
                }
            ])
            ->firstOrFail();

        // Get active flash sales for this game's products
        $productIds = $game->products->pluck('id');
        $flashSales = FlashSale::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id');

        // Get related games (same category)
        $relatedGames = Game::where('is_active', true)
            ->where('category', $game->category)
            ->where('id', '!=', $game->id)
            ->take(4)
            ->get();

        return view('game-detail', compact('game', 'flashSales', 'relatedGames'));
    }

    /**
     * Display flash sale page
     */
    public function flashSale()
    {
        // Get active flash sales
        $flashSales = FlashSale::where('is_active', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->with(['product.game'])
            ->orderBy('end_time', 'asc')
            ->paginate(12);

        // Get upcoming flash sales
        $upcomingFlashSales = FlashSale::where('is_active', true)
            ->where('start_time', '>', now())
            ->with(['product.game'])
            ->orderBy('start_time', 'asc')
            ->take(4)
            ->get();

        return view('flash-sale', compact('flashSales', 'upcomingFlashSales'));
    }

    /**
     * Display news list
     */
    public function news(Request $request)
    {
        $query = News::where('is_active', true)->orderBy('created_at', 'desc');

        // Search by title or content
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->paginate(9);

        // Get latest news for sidebar
        $latestNews = News::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('news', compact('news', 'latestNews'));
    }

    /**
     * Display news detail
     */
    public function newsDetail($slug)
    {
        // Find news by id or generate slug from title
        $news = News::where('is_active', true)
            ->where(function ($query) use ($slug) {
                $query->where('id', $slug)
                    ->orWhere('slug', $slug)
                    ->orWhere('title', 'like', '%' . str_replace('-', ' ', $slug) . '%');
            })
            ->firstOrFail();

        // Get related news
        $relatedNews = News::where('is_active', true)
            ->where('id', '!=', $news->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get latest news for sidebar
        $latestNews = News::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('news-detail', compact('news', 'relatedNews', 'latestNews'));
    }

    /**
     * Display about page
     */
    public function about()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_orders' => Order::where('status', 'success')->count(),
            'total_games' => Game::where('is_active', true)->count(),
            'total_products' => Product::where('is_active', true)->count(),
        ];

        return view('about', compact('stats'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Display FAQ page
     */
    public function faq()
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara melakukan top up?',
                'answer' => 'Pilih game yang ingin di top up, pilih nominal diamond/item, masukkan User ID, pilih metode pembayaran, dan lakukan pembayaran.'
            ],
            [
                'question' => 'Berapa lama proses top up?',
                'answer' => 'Proses top up otomatis biasanya memakan waktu 1-5 menit setelah pembayaran dikonfirmasi. Untuk top up manual maksimal 24 jam.'
            ],
            [
                'question' => 'Apakah aman melakukan top up di sini?',
                'answer' => 'Sangat aman! Kami menggunakan sistem keamanan terbaik dan telah melayani ribuan transaksi dengan tingkat kepuasan tinggi.'
            ],
            [
                'question' => 'Bagaimana jika diamond tidak masuk?',
                'answer' => 'Jika diamond tidak masuk dalam waktu yang ditentukan, silakan hubungi customer service kami dengan menyertakan nomor order.'
            ],
            [
                'question' => 'Apakah bisa refund?',
                'answer' => 'Refund dapat dilakukan jika pesanan gagal diproses. Untuk pesanan yang sudah berhasil tidak dapat di-refund.'
            ],
        ];

        return view('faq', compact('faqs'));
    }

    /**
     * Display terms and conditions
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Display privacy policy
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * Search products (AJAX)
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q');

        if (!$keyword) {
            return response()->json(['data' => []]);
        }

        // Search in games
        $games = Game::where('is_active', true)
            ->where('name', 'like', '%' . $keyword . '%')
            ->take(5)
            ->get(['id', 'name', 'image', 'category']);

        // Search in products
        $products = Product::where('is_active', true)
            ->with('game:id,name,image')
            ->where('name', 'like', '%' . $keyword . '%')
            ->take(5)
            ->get(['id', 'game_id', 'name', 'price']);

        return response()->json([
            'games' => $games,
            'products' => $products,
        ]);
    }

    /**
     * Check server ID (for games that need validation)
     */
    public function checkServerId(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_id' => 'required|string',
            'server_id' => 'nullable|string',
        ]);

        $game = Game::find($request->game_id);

        // Mock validation - replace with actual game API integration
        $isValid = strlen($request->user_id) >= 6;

        if ($isValid) {
            return response()->json([
                'success' => true,
                'message' => 'User ID valid',
                'data' => [
                    'user_id' => $request->user_id,
                    'server_id' => $request->server_id,
                    'username' => 'Player' . substr($request->user_id, -4),
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User ID tidak valid atau tidak ditemukan'
        ], 422);
    }

    /**
     * Get payment methods
     */
    public function getPaymentMethods()
    {
        $paymentMethods = [
            [
                'category' => 'E-Wallet',
                'methods' => [
                    ['code' => 'gopay', 'name' => 'GoPay', 'icon' => 'gopay.png', 'fee' => 0],
                    ['code' => 'ovo', 'name' => 'OVO', 'icon' => 'ovo.png', 'fee' => 0],
                    ['code' => 'dana', 'name' => 'DANA', 'icon' => 'dana.png', 'fee' => 0],
                    ['code' => 'shopeepay', 'name' => 'ShopeePay', 'icon' => 'shopeepay.png', 'fee' => 0],
                ]
            ],
            [
                'category' => 'Bank Transfer',
                'methods' => [
                    ['code' => 'bca', 'name' => 'BCA', 'icon' => 'bca.png', 'fee' => 0],
                    ['code' => 'bni', 'name' => 'BNI', 'icon' => 'bni.png', 'fee' => 0],
                    ['code' => 'bri', 'name' => 'BRI', 'icon' => 'bri.png', 'fee' => 0],
                    ['code' => 'mandiri', 'name' => 'Mandiri', 'icon' => 'mandiri.png', 'fee' => 0],
                ]
            ],
            [
                'category' => 'Virtual Account',
                'methods' => [
                    ['code' => 'va_bca', 'name' => 'BCA Virtual Account', 'icon' => 'bca.png', 'fee' => 4000],
                    ['code' => 'va_bni', 'name' => 'BNI Virtual Account', 'icon' => 'bni.png', 'fee' => 4000],
                    ['code' => 'va_bri', 'name' => 'BRI Virtual Account', 'icon' => 'bri.png', 'fee' => 4000],
                ]
            ],
            [
                'category' => 'Retail',
                'methods' => [
                    ['code' => 'alfamart', 'name' => 'Alfamart', 'icon' => 'alfamart.png', 'fee' => 2500],
                    ['code' => 'indomaret', 'name' => 'Indomaret', 'icon' => 'indomaret.png', 'fee' => 2500],
                ]
            ],
        ];

        return response()->json(['data' => $paymentMethods]);
    }
}