<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Mechanic;
use App\Models\MechanicSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $todaySales = Transaction::today()->completed()->sum('total');
        $todayTransactions = Transaction::today()->completed()->count();
        $monthlySales = Transaction::thisMonth()->completed()->sum('total');
        $monthlyTransactions = Transaction::thisMonth()->completed()->count();
        
        $totalProducts = Product::count();
        $lowStockProducts = Product::lowStock()->count();
        $totalServices = Service::count();
        $totalCustomers = Customer::count();
        $totalUsers = User::count();

        $recentTransactions = Transaction::with(['customer', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $topProducts = Product::withCount(['transactionItems as total_sold' => function ($query) {
            $query->select(\DB::raw('SUM(quantity)'));
        }])->orderByDesc('total_sold')->take(5)->get();

        $todayProfit = $this->calculateProfit(Transaction::today()->completed()->get(), 'today');
        $monthlyProfit = $this->calculateProfit(Transaction::thisMonth()->completed()->get(), 'monthly');

        return view('admin.dashboard', compact(
            'todaySales',
            'todayTransactions',
            'monthlySales',
            'monthlyTransactions',
            'totalProducts',
            'lowStockProducts',
            'totalServices',
            'totalCustomers',
            'totalUsers',
            'recentTransactions',
            'topProducts',
            'todayProfit',
            'monthlyProfit'
        ));
    }

    private function calculateProfit($transactions, $period = 'today')
    {
        $revenue = 0;
        $productCost = 0;
        
        foreach ($transactions as $transaction) {
            $revenue += $transaction->total;
            
            foreach ($transaction->items as $item) {
                if ($item->item_type === 'product') {
                    $product = Product::find($item->item_id);
                    if ($product && $product->purchase_price > 0) {
                        $productCost += $product->purchase_price * $item->quantity;
                    }
                }
            }
        }

        $salaryCost = 0;
        if ($period === 'today') {
            $salaryCost = MechanicSalary::whereDate('period_start', now()->toDateString())
                ->where('status', 'paid')
                ->sum('commission_amount');
        } elseif ($period === 'monthly') {
            $salaryCost = MechanicSalary::whereMonth('period_start', now()->month)
                ->whereYear('period_start', now()->year)
                ->where('status', 'paid')
                ->sum('commission_amount');
        }

        $grossProfit = $revenue - $productCost;
        $netProfit = $grossProfit - $salaryCost;

        return [
            'revenue' => $revenue,
            'product_cost' => $productCost,
            'salary_cost' => $salaryCost,
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
        ];
    }

    public function kasirDashboard()
    {
        $todaySales = Transaction::where('user_id', auth()->id())->today()->completed()->sum('total');
        $todayTransactions = Transaction::where('user_id', auth()->id())->today()->completed()->count();

        $productCategories = \App\Models\Category::product()
            ->with(['products' => function ($query) {
                $query->active()->inStock()->orderBy('name');
            }])
            ->orderBy('name')
            ->get()
            ->filter(fn ($cat) => $cat->products->isNotEmpty());

        $serviceCategories = \App\Models\Category::service()
            ->with(['services' => function ($query) {
                $query->active()->orderBy('name');
            }])
            ->orderBy('name')
            ->get()
            ->filter(fn ($cat) => $cat->services->isNotEmpty());

        // Items without category
        $productsWithoutCategory = Product::active()->inStock()->whereNull('category_id')->orderBy('name')->get();
        $servicesWithoutCategory = Service::active()->whereNull('category_id')->orderBy('name')->get();

        $mechanics = Mechanic::active()->orderBy('name')->get();

        return view('kasir.index', compact(
            'todaySales',
            'todayTransactions',
            'productCategories',
            'serviceCategories',
            'productsWithoutCategory',
            'servicesWithoutCategory',
            'mechanics'
        ));
    }
}
