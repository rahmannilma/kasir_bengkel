@extends('layouts.admin')

@section('title', 'Dashboard - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <p class="text-gray-500">Selamat datang di sistem kasir bengkel</p>
</div>

<!-- Profit & Loss Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($todayProfit['revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Kotor Hari Ini</p>
                <p class="text-2xl font-bold text-teal-600">Rp {{ number_format($todayProfit['gross_profit'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-teal-100 rounded-full p-3">
                <i class="fas fa-chart-line text-teal-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Biaya Gaji Mech.</p>
                <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($todayProfit['salary_cost'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-orange-100 rounded-full p-3">
                <i class="fas fa-users text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Bersih Hari Ini</p>
                <p class="text-2xl font-bold @if(($todayProfit['net_profit'] ?? 0) >= 0) text-green-600 @else text-red-600 @endif">Rp {{ number_format($todayProfit['net_profit'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-full p-3 @if(($todayProfit['net_profit'] ?? 0) >= 0) bg-green-100 @else bg-red-100 @endif">
                <i class="fas fa-wallet text-xl @if(($todayProfit['net_profit'] ?? 0) >= 0) text-green-600 @else text-red-600 @endif"></i>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Profit & Loss -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($monthlyProfit['revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Kotor Bulan Ini</p>
                <p class="text-2xl font-bold text-teal-600">Rp {{ number_format($monthlyProfit['gross_profit'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-teal-100 rounded-full p-3">
                <i class="fas fa-chart-line text-teal-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Biaya Gaji Mech. Bulan Ini</p>
                <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($monthlyProfit['salary_cost'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-orange-100 rounded-full p-3">
                <i class="fas fa-users text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Bersih Bulan Ini</p>
                <p class="text-2xl font-bold @if(($monthlyProfit['net_profit'] ?? 0) >= 0) text-green-600 @else text-red-600 @endif">Rp {{ number_format($monthlyProfit['net_profit'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-full p-3 @if(($monthlyProfit['net_profit'] ?? 0) >= 0) bg-green-100 @else bg-red-100 @endif">
                <i class="fas fa-wallet text-xl @if(($monthlyProfit['net_profit'] ?? 0) >= 0) text-green-600 @else text-red-600 @endif"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-money-bill text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                <p class="text-2xl font-bold text-blue-600">{{ $todayTransactions }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-receipt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Penjualan Bulan Ini</p>
                <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($monthlySales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-calendar text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Stok Menipis</p>
                <p class="text-2xl font-bold text-red-600">{{ $lowStockProducts }}</p>
            </div>
            <div class="bg-red-100 rounded-full p-3">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <a href="{{ route('admin.products.index') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="bg-orange-100 rounded-full p-3">
                <i class="fas fa-box text-orange-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold">{{ $totalProducts }}</p>
                <p class="text-sm text-gray-500">Sparepart</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.services.index') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="bg-teal-100 rounded-full p-3">
                <i class="fas fa-tools text-teal-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold">{{ $totalServices }}</p>
                <p class="text-sm text-gray-500">Jasa Service</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="bg-pink-100 rounded-full p-3">
                <i class="fas fa-user-cog text-pink-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                <p class="text-sm text-gray-500">User</p>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="font-bold">Transaksi Terbaru</h2>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        <div class="p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="pb-2">Invoice</th>
                        <th class="pb-2">Pelanggan</th>
                        <th class="pb-2">Total</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $transaction)
                    <tr class="border-t">
                        <td class="py-2">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-blue-600 hover:underline">
                                {{ $transaction->invoice_number }}
                            </a>
                        </td>
                        <td class="py-2">{{ $transaction->customer->name ?? '-' }}</td>
                        <td class="py-2">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded text-xs {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-400">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="font-bold">Produk Terlaris</h2>
            <a href="{{ route('admin.reports.product-sales') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Laporan</a>
        </div>
        <div class="p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="pb-2">Produk</th>
                        <th class="pb-2 text-right">Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $product)
                    <tr class="border-t">
                        <td class="py-2">{{ $product->name }}</td>
                        <td class="py-2 text-right">{{ $product->total_sold ?? 0 }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-4 text-center text-gray-400">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
