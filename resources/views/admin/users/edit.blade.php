@extends('layouts.admin')

@section('title', 'Edit User - Bengkel POS')

@section('admin_content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h1 class="text-xl font-bold mb-6">Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Role</label>
            <select name="role" required class="w-full px-3 py-2 border rounded-lg">
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Password <span class="text-gray-400">(kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Update
            </button>
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
