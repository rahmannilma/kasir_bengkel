@extends('layouts.admin')

@section('title', 'Export Laporan Penjualan - Bengkel POS')

@section('admin_content')
<style>
    @media print {
        .no-print { display: none !important; }
        body { -webkit-print-color-adjust: exact; }
    }
</style>

<div class="mb-6 no-print">
    <h1 class="text-2xl font-bold">Export Laporan Penjualan</h1>
    <p class="text-gray-500">Periode: {{ $dateFrom }} s/d {{ $dateTo }}</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-4">
        <button onclick="window.print()" class="no-print bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-print mr-2"></i> Print
        </button>
        <a href="{{ route('admin.reports.sales', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="no-print ml-2 text-blue-600 hover:underline">
            Kembali
        </a>
    </div>

    <div class="text-center mb-6 border-b pb-4">
        <h2 class="text-xl font-bold">LAPORAN PENJUALAN</h2>
        <p class="text-gray-600">Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}</p>
    </div>

    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2 text-left text-sm font-medium">No</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Invoice</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Tanggal</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Pelanggan</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Kasir</th>
                <th class="px-3 py-2 text-right text-sm font-medium">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @php $no = 1; $grandTotal = 0; @endphp
            @forelse($transactions as $t)
            <tr>
                <td class="px-3 py-2 text-sm">{{ $no++ }}</td>
                <td class="px-3 py-2 text-sm font-mono">{{ $t->invoice_number }}</td>
                <td class="px-3 py-2 text-sm">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-3 py-2 text-sm">{{ $t->customer->name ?? '-' }}</td>
                <td class="px-3 py-2 text-sm">{{ $t->user->name }}</td>
                <td class="px-3 py-2 text-right text-sm">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
            </tr>
            @php $grandTotal += $t->total; @endphp
            @empty
            <tr>
                <td colspan="6" class="px-3 py-4 text-center text-gray-400">Tidak ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
        @if($transactions->count() > 0)
        <tfoot class="bg-gray-50 font-bold">
            <tr>
                <td colspan="5" class="px-3 py-3 text-right">GRAND TOTAL</td>
                <td class="px-3 py-3 text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="mt-6 text-sm text-gray-500">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</div>
@endsection