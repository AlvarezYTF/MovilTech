<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Repair;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'low_stock_products' => Product::where('quantity', '<', 10)->count(),
            'total_sales' => Sale::count(),
            'total_revenue' => Sale::where('status', 'completed')->sum('total'),
            'pending_repairs' => Repair::where('status', 'pending')->count(),
            'total_customers' => Customer::count(),
        ];

        // Ventas del mes actual
        $monthlySales = Sale::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Productos más vendidos
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Reparaciones por estado
        $repairStatuses = Repair::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('dashboard', compact('stats', 'monthlySales', 'topProducts', 'repairStatuses'));
    }
}
