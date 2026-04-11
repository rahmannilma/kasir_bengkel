@extends('layouts.admin')

@section('title', 'Gaji Mekanik - Bengkel POS')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Gaji Mekanik</h1>
        <p class="text-gray-500">Kelola komisi dan gaji mekanik</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Sidebar - Mechanic List -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-bold mb-4">Daftar Mekanik</h2>
            <div class="space-y-2">
                @foreach($mechanics as $mechanic)
                <a href="{{ route('admin.mechanics.salary', ['mechanic_id' => $mechanic->id]) }}" 
                    class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 {{ $selectedMechanic && $selectedMechanic->id == $mechanic->id ? 'bg-blue-50 border border-blue-200' : '' }}">
                    <div>
                        <p class="font-medium">{{ $mechanic->name }}</p>
                        <p class="text-xs text-gray-500">{{ $mechanic->specialization ?? '-' }}</p>
                    </div>
                    <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">
                        {{ $mechanic->commission_rate ?? 10 }}%
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:col-span-2">
        @if($selectedMechanic)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-xl font-bold">{{ $selectedMechanic->name }}</h2>
                    <p class="text-gray-500">{{ $selectedMechanic->specialization ?? 'Tidak ada specialization' }}</p>
                </div>
                <form action="{{ route('admin.mechanics.commission.update', $selectedMechanic) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PUT')
                    <label class="text-sm">Komisi:</label>
                    <input type="number" name="commission_rate" value="{{ old('commission_rate', $selectedMechanic->commission_rate ?? 10) }}" 
                        class="w-20 px-2 py-1 border rounded text-sm" min="0" max="100" step="0.5">
                    <span class="text-sm">%</span>
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                        Simpan
                    </button>
                </form>
            </div>

            <!-- Filter -->
            <form method="GET" class="flex flex-wrap gap-4 mb-6">
                <input type="hidden" name="mechanic_id" value="{{ $selectedMechanic->id }}">
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from', now()->startOfMonth()->format('Y-m-d')) }}" 
                        class="px-3 py-2 border rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to', now()->endOfMonth()->format('Y-m-d')) }}" 
                        class="px-3 py-2 border rounded-lg text-sm">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Filter
                    </button>
                </div>
            </form>

            <!-- Summary -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-green-600">Total Pendapatan Jasa</p>
                    <p class="text-2xl font-bold text-green-700">Rp {{ number_format($salaries->sum('service_amount'), 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-600">Total Jasa per Mekanik</p>
                    <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($salaries->sum('service_amount_per_mechanic'), 0, ',', '.') }}</p>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 col-span-2">
                    <p class="text-sm text-yellow-600">Total Komisi ({{ $selectedMechanic->commission_rate ?? 10 }}%)</p>
                    <p class="text-2xl font-bold text-yellow-700">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Transaction List -->
            <h3 class="font-bold mb-3">Riwayat Transaksi</h3>
            @if($salaries->isNotEmpty())
            <form action="{{ route('admin.mechanics.salary.paid', $selectedMechanic) }}" method="POST">
                @csrf
                <div class="overflow-x-auto mb-4">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-center">
                                    <input type="checkbox" id="select-all" class="rounded">
                                </th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Invoice</th>
                                <th class="px-4 py-2 text-right">Nilai Jasa</th>
                                <th class="px-4 py-2 text-right">Komisi ({{ $selectedMechanic->commission_rate ?? 10 }}%)</th>
                                <th class="px-4 py-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($salaries as $index => $salary)
                            <tr class="{{ isset($salary['is_paid']) && $salary['is_paid'] ? 'bg-gray-50' : '' }}">
                                <td class="px-4 py-2 text-center">
                                    <input type="checkbox" name="salary_ids[]" value="{{ $salary['salary_id'] ?? $index }}" class="salary-checkbox rounded">
                                </td>
                                <td class="px-4 py-2">{{ $salary['transaction']->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2">{{ $salary['transaction']->invoice_number }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($salary['service_amount_per_mechanic'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right text-green-600 font-medium">Rp {{ number_format($salary['commission_amount'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-600">Pending</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold">
                            <tr>
                                <td colspan="3" class="px-4 py-2"></td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($salaries->sum('service_amount_per_mechanic'), 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right text-green-600">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i> Tandai Lunas
                </button>
            </form>
            @else
            <p class="text-center text-gray-400 py-8">Tidak ada transaksi dalam periode ini</p>
            @endif
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500">Pilih mekanik dari daftar untuk melihat laporan gaji</p>
        </div>
        @endif
    </div>
</div>

<script>
document.getElementById('select-all').addEventListener('change', function() {
    document.querySelectorAll('.salary-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
@endsection
