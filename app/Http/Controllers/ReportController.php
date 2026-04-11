<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $transactions = Transaction::with(['customer', 'user'])
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSales = $transactions->sum('total');
        $totalTransaction = $transactions->count();
        $totalItems = $transactions->sum(function ($t) {
            return $t->items->sum('quantity');
        });

        return view('admin.reports.sales', compact(
            'transactions',
            'totalSales',
            'totalTransaction',
            'totalItems',
            'dateFrom',
            'dateTo'
        ));
    }

    public function salesExport(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $transactions = Transaction::with(['customer', 'user', 'items'])
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reports.sales-export', compact('transactions', 'dateFrom', 'dateTo'));
    }

    public function productSales(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $items = TransactionItem::with(['transaction', 'item'])
            ->whereHas('transaction', function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                  ->where('status', 'completed');
            })
            ->where('item_type', 'product')
            ->get();

        $productSales = $items->groupBy('item_id')->map(function ($item) {
            return [
                'item_name' => $item->first()->item_name,
                'quantity' => $item->sum('quantity'),
                'revenue' => $item->sum('subtotal'),
            ];
        })->sortByDesc('revenue')->values();

        return view('admin.reports.product-sales', compact('productSales', 'dateFrom', 'dateTo'));
    }

    public function serviceSales(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $items = TransactionItem::with(['transaction'])
            ->whereHas('transaction', function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                  ->where('status', 'completed');
            })
            ->where('item_type', 'service')
            ->get();

        $serviceSales = $items->groupBy('item_id')->map(function ($item) {
            return [
                'item_name' => $item->first()->item_name,
                'quantity' => $item->sum('quantity'),
                'revenue' => $item->sum('subtotal'),
            ];
        })->sortByDesc('revenue')->values();

        return view('admin.reports.service-sales', compact('serviceSales', 'dateFrom', 'dateTo'));
    }

    public function dailySales(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');

        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $dailySales = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as transaction_count, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalMonth = $dailySales->sum('total');
        $totalTransaction = $dailySales->sum('transaction_count');

        return view('admin.reports.daily-sales', compact('dailySales', 'month', 'totalMonth', 'totalTransaction'));
    }

    public function customerReport(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $customers = Customer::with(['transactions' => function ($q) use ($dateFrom, $dateTo) {
            $q->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
              ->where('status', 'completed');
        }])->get();

        $customerData = $customers->map(function ($customer) {
            return [
                'customer' => $customer,
                'transaction_count' => $customer->transactions->count(),
                'total_spending' => $customer->transactions->sum('total'),
            ];
        })->filter(function ($c) {
            return $c['transaction_count'] > 0;
        })->sortByDesc('total_spending')->values();

        return view('admin.reports.customer', compact('customerData', 'dateFrom', 'dateTo'));
    }

    public function stockReport()
    {
        $products = Product::with('category')->orderBy('name')->get();
        $lowStockProducts = $products->filter(function ($p) {
            return $p->stock <= $p->min_stock;
        });

        return view('admin.reports.stock', compact('products', 'lowStockProducts'));
    }

    public function summary(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $transactions = Transaction::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->where('status', 'completed')
            ->get();

        $totalSales = $transactions->sum('total');
        $totalTransaction = $transactions->count();
        $avgTransaction = $totalTransaction > 0 ? $totalSales / $totalTransaction : 0;

        $byPaymentMethod = $transactions->groupBy('payment_method')->map(function ($t) {
            return [
                'count' => $t->count(),
                'total' => $t->sum('total'),
            ];
        });

        $productRevenue = TransactionItem::whereHas('transaction', function ($q) use ($dateFrom, $dateTo) {
            $q->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
              ->where('status', 'completed');
        })->where('item_type', 'product')->sum('subtotal');

        $serviceRevenue = TransactionItem::whereHas('transaction', function ($q) use ($dateFrom, $dateTo) {
            $q->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
              ->where('status', 'completed');
        })->where('item_type', 'service')->sum('subtotal');

        return view('admin.reports.summary', compact(
            'totalSales',
            'totalTransaction',
            'avgTransaction',
            'byPaymentMethod',
            'productRevenue',
            'serviceRevenue',
            'dateFrom',
            'dateTo'
        ));
    }
}
