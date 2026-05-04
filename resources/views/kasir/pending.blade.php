@extends('layouts.app')

@section('title', 'Draft Transaksi - Bengkel POS')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Draft Transaksi</h1>
        <a href="{{ route('kasir.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Transaksi Baru
        </a>
    </div>

    @if($transactions->isEmpty())
    <div class="text-center py-12">
        <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Tidak ada draft transaksi</p>
    </div>
    @else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
<thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pelanggan/Mobil</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4">{{ $transaction->invoice_number }}</td>
                    <td class="px-6 py-4">
                        <div>{{ $transaction->customer->name ?? 'Umum' }}</div>
                        <div class="text-xs text-gray-500">{{ $transaction->customer->vehicle_plate ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('kasir.pending.continue', $transaction->id) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit mr-1"></i> Lanjutkan
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection