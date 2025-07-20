<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $categories = Category::all();

    $products = Product::where('is_active', true)
        ->orderByDesc('average_rating')
        ->limit(6)
        ->get();

    $productsfeature = Product::where('is_active', true)
        ->where('is_featured', true)
        ->orderByDesc('average_rating')
        ->limit(6)
        ->get();

    return view('frontend.pages.index', compact('categories', 'products', 'productsfeature'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function shop()
    {
             $settings = Setting::first();
             $categories = Category::all();
             $products = Product::where('is_active', true)->paginate(30);
            return view('frontend.pages.shop', compact('categories', 'products','settings'));

        
    }


//mysql
public function dash()
{
    $user = auth()->user();
    
    // Base query for orders that will be filtered based on role
    $ordersQuery = Order::query();
    $productsQuery = Product::query();
    
    // If user is role_id 2 (non-admin), filter data to only show their own records
    if ($user->role_id == 2) {
        // For products - assuming author_id is the user who created the product
        $productsQuery->where('author_id', $user->id);
        
        // For orders - need to adjust based on your business logic
        // Option 1: If orders have a seller_id or similar
        // $ordersQuery->where('seller_id', $user->id);
        
        // Option 2: If we should show orders of their products
        $ordersQuery->whereHas('product', function($q) use ($user) {
            $q->where('author_id', $user->id);
        });
    }

    // Estatísticas básicas
    $totalProducts = $productsQuery->count();
    $totalOrders = $ordersQuery->count();
    $totalUsers = $user->role_id == 1 ? User::count() : null; // Only admin sees total users

    // Vendas
    $todaySales = $ordersQuery->clone()->whereDate('created_at', Carbon::today())->count();
    $weekSales = $ordersQuery->clone()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    $monthSales = $ordersQuery->clone()->whereMonth('created_at', Carbon::now()->month)->count();
    
    // Vendas por status
    $orderStatuses = $ordersQuery->clone()
        ->selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->get()
        ->pluck('count', 'status');
        
    // Vendas mensais para gráfico
    $monthlySales = $ordersQuery->clone()
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('count', 'month');
        
    // Produtos mais vendidos
    $topProducts = $productsQuery->clone()
        ->withCount(['orders' => function($q) use ($user) {
            if ($user->role_id == 2) {
                $q->whereHas('product', function($q) use ($user) {
                    $q->where('author_id', $user->id);
                });
            }
        }])
        ->orderBy('orders_count', 'desc')
        ->take(5)
        ->get();
        
    // Últimos pedidos
    $recentOrders = $ordersQuery->clone()
        ->with(['user', 'product'])
        ->latest()
        ->take(5)
        ->get();

    return view('admin.pages.index', compact(
        'totalProducts',
        'totalOrders',
        'totalUsers',
        'todaySales',
        'weekSales',
        'monthSales',
        'orderStatuses',
        'monthlySales',
        'topProducts',
        'recentOrders',
        'user' // Pass user to view if needed
    ));
}

//sqllite
// public function dash()
// {
//     $user = auth()->user();

//     $ordersQuery = Order::query();
//     $productsQuery = Product::query();

//     if ($user->role_id == 2) {
//         $productsQuery->where('author_id', $user->id);

//         $ordersQuery->whereHas('product', function ($q) use ($user) {
//             $q->where('author_id', $user->id);
//         });
//     }

//     $totalProducts = $productsQuery->count();
//     $totalOrders = $ordersQuery->count();
//     $totalUsers = $user->role_id == 1 ? User::count() : null;

//     // Detecta o driver
//     $driver = DB::getDriverName();

//     // Datas formatadas
//     $today = Carbon::today()->toDateString();
//     $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
//     $endOfWeek = Carbon::now()->endOfWeek()->toDateString();
//     $currentMonth = Carbon::now()->format('m');
//     $currentYear = Carbon::now()->format('Y');

//     // Vendas
//     $todaySales = $ordersQuery->clone()->whereDate('created_at', $today)->count();
//     $weekSales = $ordersQuery->clone()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

//     // whereMonth e whereYear não funcionam no SQLite
//     if ($driver === 'sqlite') {
//         $monthSales = $ordersQuery->clone()
//             ->whereRaw("strftime('%m', created_at) = ?", [$currentMonth])
//             ->count();
//     } else {
//         $monthSales = $ordersQuery->clone()
//             ->whereMonth('created_at', Carbon::now()->month)
//             ->count();
//     }

//     // Vendas por status
//     $orderStatuses = $ordersQuery->clone()
//         ->selectRaw('status, count(*) as count')
//         ->groupBy('status')
//         ->get()
//         ->pluck('count', 'status');

//     // Vendas mensais (gráfico)
//     if ($driver === 'sqlite') {
//         $monthlySales = $ordersQuery->clone()
//             ->selectRaw("strftime('%m', created_at) as month, COUNT(*) as count")
//             ->whereRaw("strftime('%Y', created_at) = ?", [$currentYear])
//             ->groupBy('month')
//             ->orderBy('month')
//             ->get()
//             ->pluck('count', 'month');
//     } else {
//         $monthlySales = $ordersQuery->clone()
//             ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
//             ->whereYear('created_at', $currentYear)
//             ->groupBy('month')
//             ->orderBy('month')
//             ->get()
//             ->pluck('count', 'month');
//     }

//     // Produtos mais vendidos
//     $topProducts = $productsQuery->clone()
//         ->withCount(['orders' => function ($q) use ($user) {
//             if ($user->role_id == 2) {
//                 $q->whereHas('product', function ($q) use ($user) {
//                     $q->where('author_id', $user->id);
//                 });
//             }
//         }])
//         ->orderBy('orders_count', 'desc')
//         ->take(5)
//         ->get();

//     // Últimos pedidos
//     $recentOrders = $ordersQuery->clone()
//         ->with(['user', 'product'])
//         ->latest()
//         ->take(5)
//         ->get();

//     return view('admin.pages.index', compact(
//         'totalProducts',
//         'totalOrders',
//         'totalUsers',
//         'todaySales',
//         'weekSales',
//         'monthSales',
//         'orderStatuses',
//         'monthlySales',
//         'topProducts',
//         'recentOrders',
//         'user'
//     ));
// }
    public function about()
    {
            
     return view('frontend.pages.about');
    }
    public function contract()
    {
        $setting=Setting::first();
        return view('admin.pages.contract',compact('setting'));
        
    }
    public function show(Product $product)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
