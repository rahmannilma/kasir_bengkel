@extends('layouts.admin')

@section('title', 'Detail Transaksi - Bengkel POS')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.transactions.index') }}" class="text-blue-600 hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
    <div class="flex gap-2">
        <a href="{{ route('receipt', $transaction) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-print mr-2"></i> Cetak Struk
        </a>
        @if($transaction->status !== 'cancelled')
        <form action="{{ route('admin.transactions.void', $transaction) }}" method="POST" class="inline"
            onsubmit="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                <i class="fas fa-times mr-2"></i> Batalkan
            </button>
        </form>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Transaction Info -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Informasi Transaksi</h2>
        <table class="w-full text-sm">
            <tr>
                <td class="py-2 text-gray-500">Invoice</td>
                <td class="py-2 font-mono">{{ $transaction->invoice_number }}</td>
            </tr>
            <tr>
                <td class="py-2 text-gray-500">Tanggal</td>
                <td class="py-2">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td class="py-2 text-gray-500">Status</td>
                <td class="py-2">
                    <span class="px-2 py-1 rounded text-xs 
                        {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $transaction->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
            </tr>
            @if($transaction->customer)
            <tr>
                <td class="py-2 text-gray-500">Pelanggan</td>
                <td class="py-2">{{ $transaction->customer->name }}</td>
            </tr>
            <tr>
                <td class="py-2 text-gray-500">Kendaraan</td>
                <td class="py-2">{{ $transaction->customer->vehicle_plate ?? '-' }}</td>
            </tr>
            @endif
            <tr>
                <td class="py-2 text-gray-500">Kasir</td>
                <td class="py-2">{{ $transaction->user->name }}</td>
            </tr>
            @if($transaction->mechanics->count() > 0)
            <tr>
                <td class="py-2 text-gray-500">Mekanik</td>
                <td class="py-2">{{ $transaction->mechanics->pluck('name')->join(', ') }}</td>
            </tr>
            @endif
            <tr>
                <td class="py-2 text-gray-500">Metode Bayar</td>
                <td class="py-2 uppercase">{{ str_replace(['cash', 'transfer', 'debit', 'qris'], ['Tunai', 'Transfer', 'Debit', 'QRIS'], $transaction->payment_method) }}</td>
            </tr>
        </table>
    </div>

    <!-- Payment Info -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Pembayaran</h2>
        <table class="w-full text-sm">
            <tr>
                <td class="py-2 text-gray-500">Subtotal</td>
                <td class="py-2 text-right">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
            </tr>
            @if($transaction->discount > 0)
            <tr>
                <td class="py-2 text-gray-500">Diskon</td>
                <td class="py-2 text-right text-green-600">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="font-bold text-lg border-t">
                <td class="py-2">Total</td>
                <td class="py-2 text-right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
            </tr>
            @if($transaction->cash_received)
            <tr>
                <td class="py-2 text-gray-500">Jumlah Bayar</td>
                <td class="py-2 text-right">Rp {{ number_format($transaction->cash_received, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="py-2 text-gray-500">Kembalian</td>
                <td class="py-2 text-right text-green-600">Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>

<!-- Items Table -->
<div class="bg-white rounded-lg shadow mt-6">
    <div class="p-4 border-b">
        <h2 class="text-lg font-bold">Item Transaksi</h2>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Item</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Tipe</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Harga</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Qty</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($transaction->items as $item)
            <tr>
                <td class="px-4 py-3">{{ $item->item_name }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-xs {{ $item->item_type === 'product' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($item->item_type) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                <td class="px-4 py-3 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
