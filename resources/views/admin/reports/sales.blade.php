@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Laporan Penjualan</h1>
    <p class="text-gray-500">Ringkasan penjualan berdasarkan periode</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium mb-2">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}" class="px-4 py-2 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ $dateTo }}" class="px-4 py-2 border rounded-lg">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-filter mr-2"></i> Filter
        </button>
        <a href="{{ route('admin.reports.sales-export', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-file-excel mr-2"></i> Export
        </a>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Penjualan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-money-bill text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Jumlah Transaksi</p>
                <p class="text-2xl font-bold text-blue-600">{{ $totalTransaction }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-receipt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Item Terjual</p>
                <p class="text-2xl font-bold text-purple-600">{{ $totalItems }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-box text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <h2 class="font-bold">Detail Transaksi</h2>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Invoice</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Tanggal</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Pelanggan</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kasir</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($transactions as $t)
            <tr>
                <td class="px-4 py-3 font-mono text-sm">{{ $t->invoice_number }}</td>
                <td class="px-4 py-3 text-sm">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3 text-sm">{{ $t->customer->name ?? '-' }}</td>
                <td class="px-4 py-3 text-sm">{{ $t->user->name }}</td>
                <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-400">Tidak ada transaksi dalam periode ini</td>
            </tr>
            @endforelse
        </tbody>
        @if($transactions->count() > 0)
        <tfoot class="bg-gray-50 font-bold">
            <tr>
                <td colspan="4" class="px-4 py-3 text-right">Total</td>
                <td class="px-4 py-3 text-right text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection
