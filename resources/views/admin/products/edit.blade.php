@extends('layouts.admin')

@section('title', 'Edit Sparepart - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h1 class="text-xl font-bold mb-6">Edit Sparepart</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Kode Sparepart</label>
                <input type="text" name="code" value="{{ $product->code }}" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Kategori</label>
                <select name="jenis" class="w-full px-3 py-2 border rounded-lg">
                    <option value="Aki" {{ $product->jenis == 'Aki' ? 'selected' : '' }}>Aki</option>
                    <option value="Ban Luar" {{ $product->jenis == 'Ban Luar' ? 'selected' : '' }}>Ban Luar</option>
                    <option value="Ban Dalam" {{ $product->jenis == 'Ban Dalam' ? 'selected' : '' }}>Ban Dalam</option>
                    <option value="Oli" {{ $product->jenis == 'Oli' ? 'selected' : '' }}>Oli</option>
                    <option value="Sparepart" {{ $product->jenis == 'Sparepart' ? 'selected' : '' }}>Sparepart</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium mb-2">Nama Sparepart</label>
            <input type="text" name="name" value="{{ $product->name }}" required class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium mb-2">Merk</label>
                <input type="text" name="brand" value="{{ $product->brand }}" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">No. Part</label>
                <input type="text" name="part_number" value="{{ $product->part_number }}" class="w-full px-3 py-2 border rounded-lg">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium mb-2">Harga Beli</label>
                <input type="number" name="purchase_price" value="{{ $product->purchase_price }}" required min="0" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Harga Jual</label>
                <input type="number" name="selling_price" value="{{ $product->selling_price }}" required min="0" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}" required min="0" class="w-full px-3 py-2 border rounded-lg">
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium mb-2">Minimal Stok</label>
            <input type="number" name="min_stock" value="{{ $product->min_stock }}" required min="0" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ $product->description }}</textarea>
        </div>

        <div class="mt-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="mr-2">
                <span class="text-sm font-medium">Aktif</span>
            </label>
        </div>

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Update
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection