@extends('layouts.admin')

@section('title', 'Transaksi - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Riwayat Transaksi</h1>
    <p class="text-gray-500">Lihat semua transaksi</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" placeholder="No. Invoice..." value="{{ request('search') }}"
            class="px-4 py-2 border rounded-lg min-w-[150px]">
        <input type="date" name="date_from" value="{{ request('date_from') }}"
            class="px-4 py-2 border rounded-lg">
        <input type="date" name="date_to" value="{{ request('date_to') }}"
            class="px-4 py-2 border rounded-lg">
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Status</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Invoice</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Tanggal</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Pelanggan</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Mekanik</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kasir</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Total</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Status</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($transactions as $transaction)
            <tr class="{{ $transaction->status === 'cancelled' ? 'bg-red-50' : '' }}">
                <td class="px-4 py-3">
                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-blue-600 hover:underline font-mono">
                        {{ $transaction->invoice_number }}
                    </a>
                </td>
                <td class="px-4 py-3 text-sm">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3 text-sm">{{ $transaction->customer->name ?? '-' }}</td>
                <td class="px-4 py-3 text-sm">{{ $transaction->mechanics->count() > 0 ? $transaction->mechanics->pluck('name')->join(', ') : '-' }}</td>
                <td class="px-4 py-3 text-sm">{{ $transaction->user->name }}</td>
                <td class="px-4 py-3 text-right text-sm font-medium">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-xs 
                        {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $transaction->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('receipt', $transaction) }}" target="_blank" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-print"></i>
                        </a>
                        @if($transaction->status !== 'cancelled')
                        <form action="{{ route('admin.transactions.void', $transaction) }}" method="POST" class="inline"
                            onsubmit="return confirm('Batalkan transaksi ini?')">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
