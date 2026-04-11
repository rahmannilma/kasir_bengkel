@extends('layouts.admin')

@section('title', 'Pengaturan - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Pengaturan Bengkel</h1>
    <p class="text-gray-500">Atur nama, alamat, dan telepon bengkel</p>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Bengkel</label>
            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name', $settings['shop_name']) }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('shop_name') border-red-500 @enderror"
                required>
            @error('shop_name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="shop_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Bengkel</label>
            <textarea id="shop_address" name="shop_address" rows="3"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('shop_address') border-red-500 @enderror"
                required>{{ old('shop_address', $settings['shop_address']) }}</textarea>
            @error('shop_address')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="shop_phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
            <input type="text" id="shop_phone" name="shop_phone" value="{{ old('shop_phone', $settings['shop_phone']) }}"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('shop_phone') border-red-500 @enderror"
                required>
            @error('shop_phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
