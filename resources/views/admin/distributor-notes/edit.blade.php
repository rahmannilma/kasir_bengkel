@extends('layouts.admin')

@section('title', 'Edit Nota Distributor - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <a href="{{ route('admin.distributor-notes.index') }}" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Nota Distributor
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-bold mb-6">Edit Nota Distributor</h1>
    <form method="POST" action="{{ route('admin.distributor-notes.update', $distributorNote) }}">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Distributor <span class="text-red-500">*</span></label>
                <select name="distributor_id" required class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Pilih Distributor</option>
                    @foreach($distributors as $distributor)
                        <option value="{{ $distributor->id }}" {{ $distributorNote->distributor_id == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }} - {{ $distributor->company }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Nomor Nota <span class="text-red-500">*</span></label>
                <input type="text" name="note_number" required class="w-full px-3 py-2 border rounded-lg" value="{{ $distributorNote->note_number }}">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium mb-2">Tanggal Nota <span class="text-red-500">*</span></label>
                <input type="date" name="date" required class="w-full px-3 py-2 border rounded-lg" value="{{ $distributorNote->date->format('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
                <input type="date" name="due_date" required class="w-full px-3 py-2 border rounded-lg" value="{{ $distributorNote->due_date->format('Y-m-d') }}">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium mb-2">Total Tagihan <span class="text-red-500">*</span></label>
                <input type="number" name="total_amount" required min="0" step="0.01" class="w-full px-3 py-2 border rounded-lg" value="{{ $distributorNote->total_amount }}">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Status Pembayaran</label>
                <div class="mt-2">
                    @if($distributorNote->status === 'paid')
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">Lunas</span>
                    @elseif($distributorNote->status === 'partial')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">Sebagian (Rp {{ number_format($distributorNote->paid_amount, 0, ',', '.') }})</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">Belum Lunas</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium mb-2">Catatan</label>
            <textarea name="notes" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ $distributorNote->notes }}</textarea>
        </div>
        <div class="flex gap-2 mt-6">
            <a href="{{ route('admin.distributor-notes.index') }}" class="flex-1 py-2 border rounded-lg hover:bg-gray-50 text-center">Batal</a>
            <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection