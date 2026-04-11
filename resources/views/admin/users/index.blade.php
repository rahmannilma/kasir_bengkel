@extends('layouts.admin')

@section('title', 'Manajemen User - Bengkel POS')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Manajemen User</h1>
        <p class="text-gray-500">Kelola pengguna sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah User
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex gap-4">
        <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}"
            class="px-4 py-2 border rounded-lg flex-1">
        <select name="role" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Telepon</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Role</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $user)
            <tr>
                <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                <td class="px-4 py-3 text-sm">{{ $user->phone ?? '-' }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-xs {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada user</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $users->links() }}
    </div>
</div>
@endsection
