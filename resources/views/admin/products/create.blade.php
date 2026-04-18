@extends('layouts.admin')

@section('title', 'Tambah Sparepart - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-bold mb-6">Tambah Sparepart Baru</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Kode Sparepart <span class="text-red-500">*</span></label>
                <input type="text" name="code" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: AKI001">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="jenis" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Kategori</option>
                    <option value="Aki">Aki</option>
                    <option value="Ban Luar">Ban Luar</option>
                    <option value="Ban Dalam">Ban Dalam</option>
                    <option value="Oli">Oli</option>
                    <option value="Sparepart">Sparepart</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Nama Sparepart <span class="text-red-500">*</span></label>
            <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Aki GS QT5S 12V 5Ah">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Merek</label>
                <input type="text" name="brand" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: GS, Yuasa, Honda">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">No. Part</label>
                <input type="text" name="part_number" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: GS-AKI-005">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Harga Beli <span class="text-red-500">*</span></label>
                <input type="number" name="purchase_price" required min="0" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Harga Jual <span class="text-red-500">*</span></label>
                <input type="number" name="selling_price" required min="0" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Stok Awal <span class="text-red-500">*</span></label>
                <input type="number" name="stock" required min="0" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Minimal Stok</label>
                <input type="number" name="min_stock" required min="0" value="5" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Status</label>
                <div class="flex items-center gap-4 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="is_active" value="1" checked class="mr-2">
                        <span class="text-sm">Aktif</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="is_active" value="0" class="mr-2">
                        <span class="text-sm">Nonaktif</span>
                    </label>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi produk..."></textarea>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 border rounded-lg hover:bg-gray-50 flex items-center">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection