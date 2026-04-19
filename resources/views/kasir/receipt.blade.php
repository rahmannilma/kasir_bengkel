@extends('layouts.app')

@section('title', 'Struk - Bengkel POS')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-1">
    <div class="bg-white shadow-xl w-full max-w-[80mm] p-3" style="width: 80mm; max-width: 80mm;">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
        @endif
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold">{{ \App\Models\Setting::get('shop_name', 'BENGKEL MOBIL') }}</h1>
            <p class="text-sm text-gray-500">{{ \App\Models\Setting::get('shop_address', 'Jl. Raya Bengkel No. 123') }}</p>
            <p class="text-sm text-gray-500">Telp: {{ \App\Models\Setting::get('shop_phone', '0812-3456-7890') }}</p>
        </div>

        <div class="border-t border-b border-dashed border-gray-300 py-4 mb-4">
            <div class="flex justify-between text-sm mb-2">
                <span>No. Invoice</span>
                <span class="font-mono">{{ $transaction->invoice_number }}</span>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span>Tanggal</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span>Kasir</span>
                <span>{{ $transaction->user->name }}</span>
            </div>
            @if($transaction->customer)
            <div class="flex justify-between text-sm">
                <span>Pelanggan</span>
                <span>{{ $transaction->customer->name }}</span>
            </div>
            @endif
            @if($transaction->mechanics->count() > 0)
            <div class="flex justify-between text-sm">
                <span>Mekanik</span>
                <span>{{ $transaction->mechanics->pluck('name')->join(', ') }}</span>
            </div>
            @endif
        </div>

        <div class="mb-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Item</th>
                        <th class="text-center py-2">Qty</th>
                        <th class="text-right py-2">Harga</th>
                        <th class="text-right py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $item)
                    <tr>
                        <td class="py-2">
                            {{ $item->item_name }}
                            <span class="text-xs text-gray-400 block">{{ ucfirst($item->item_type) }}</span>
                        </td>
                        <td class="text-center py-2">{{ $item->quantity }}</td>
                        <td class="text-right py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right py-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="border-t border-dashed border-gray-300 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($transaction->discount > 0)
            <div class="flex justify-between text-sm text-green-600">
                <span>Diskon</span>
                <span>- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between text-lg font-bold">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="border-t border-dashed border-gray-300 py-4 mt-4">
            <div class="flex justify-between text-sm">
                <span>Metode Bayar</span>
                <span class="uppercase">{{ str_replace(['cash', 'transfer', 'debit', 'qris'], ['Tunai', 'Transfer', 'Debit', 'QRIS'], $transaction->payment_method) }}</span>
            </div>
            @if($transaction->cash_received)
            <div class="flex justify-between text-sm">
                <span>Jumlah Bayar</span>
                <span>Rp {{ number_format($transaction->cash_received, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-green-600">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">Terima kasih atas kunjungan Anda!</p>
            <p class="text-xs text-gray-400 mt-2">Barang yang sudah dibeli tidak dapat dikembalikan</p>
        </div>

        <div class="mt-3 flex gap-2">
            <button onclick="window.print()" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i> Cetak
            </button>
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('kasir.index') }}" 
               class="flex-1 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-center">
                <i class="fas fa-home mr-2"></i> Menu Utama
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    @page {
        size: 80mm auto;
        margin: 0;
    }
    body {
        width: 80mm;
    }
    body * {
        visibility: hidden;
    }
    .bg-white, .bg-white * {
        visibility: visible;
    }
    .bg-white {
        position: absolute;
        left: 0;
        top: 0;
        width: 80mm;
        max-width: 80mm;
        box-shadow: none;
        border: none;
        padding: 5mm;
    }
    .text-xl {
        font-size: 14px;
    }
    .text-sm, text-xs {
        font-size: 10px;
    }
    .text-lg {
        font-size: 14px;
    }
    button, a {
        display: none !important;
    }
    .border-t, .border-b {
        border-color: #999 !important;
    }
}
</style>
@endsection
