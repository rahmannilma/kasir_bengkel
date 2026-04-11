@extends('layouts.admin')

@section('title', 'Kategori - Bengkel POS')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Manajemen Kategori</h1>
        <p class="text-gray-500">Kelola kategori produk dan jasa</p>
    </div>
    <button onclick="showCategoryModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah Kategori
    </button>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" placeholder="Cari kategori..." value="{{ request('search') }}"
            class="px-4 py-2 border rounded-lg flex-1 min-w-[200px]">
        <select name="type" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Tipe</option>
            <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Produk</option>
            <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Jasa</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Categories Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Tipe</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Distributor</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Deskripsi</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categories as $category)
            <tr>
                <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs {{ $category->type === 'product' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($category->type) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $category->distributor->name ?? '-' }}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $category->description ?? '-' }}</td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->type }}', '{{ $category->distributor_id }}', '{{ $category->description }}')"
                            class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada kategori</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $categories->links() }}
    </div>
</div>

<!-- Category Modal -->
<div id="category-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 id="modal-title" class="text-lg font-bold mb-4">Tambah Kategori</h3>
        <form id="category-form" method="POST">
            @csrf
            <input type="hidden" id="form-method" value="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Nama Kategori</label>
                <input type="text" id="cat-name" name="name" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Tipe</label>
                <select id="cat-type" name="type" required class="w-full px-3 py-2 border rounded-lg">
                    <option value="product">Produk</option>
                    <option value="service">Jasa</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Distributor</label>
                <select id="cat-distributor" name="distributor_id" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">- Tidak Ada -</option>
                    @foreach($distributors as $distributor)
                    <option value="{{ $distributor->id }}">{{ $distributor->name }}{{ $distributor->company ? ' (' . $distributor->company . ')' : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Deskripsi</label>
                <textarea id="cat-description" name="description" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="hideCategoryModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function showCategoryModal() {
    document.getElementById('modal-title').textContent = 'Tambah Kategori';
    document.getElementById('category-form').action = '{{ route('admin.categories.store') }}';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('cat-name').value = '';
    document.getElementById('cat-type').value = 'product';
    document.getElementById('cat-distributor').value = '';
    document.getElementById('cat-description').value = '';
    document.getElementById('category-modal').classList.remove('hidden');
    document.getElementById('category-modal').classList.add('flex');
}

function editCategory(id, name, type, distributorId, description) {
    document.getElementById('modal-title').textContent = 'Edit Kategori';
    document.getElementById('category-form').action = '/admin/categories/' + id;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('cat-name').value = name;
    document.getElementById('cat-type').value = type;
    document.getElementById('cat-distributor').value = distributorId || '';
    document.getElementById('cat-description').value = description || '';

    let methodInput = document.querySelector('#category-form input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('category-form').appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    document.getElementById('category-modal').classList.remove('hidden');
    document.getElementById('category-modal').classList.add('flex');
}

function hideCategoryModal() {
    document.getElementById('category-modal').classList.add('hidden');
    document.getElementById('category-modal').classList.remove('flex');
}
</script>
@endsection
