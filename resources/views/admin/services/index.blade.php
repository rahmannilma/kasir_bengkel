@extends('layouts.admin')

@section('title', 'Jasa Service - Bengkel POS')

@section('admin_content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Manajemen Jasa Service</h1>
        <p class="text-gray-500">Kelola jasa, layanan, dan kategori</p>
    </div>
    <button onclick="showServiceModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah Jasa
    </button>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Jasa</p>
        <p class="text-2xl font-bold">{{ $services->total() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Kategori Service</p>
        <p class="text-2xl font-bold">{{ $allCategories->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Pendapatan Jasa</p>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($services->sum('price'), 0, ',', '.') }}</p>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="font-semibold">Kategori Service</h2>
        <button onclick="showCategoryModal()" class="text-sm text-blue-600 hover:text-blue-800">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
        </button>
    </div>
    @if($allCategories->count() > 0)
    <div class="p-4 grid grid-cols-4 gap-3">
        @foreach($allCategories as $category)
        <div class="border rounded-lg p-3 flex justify-between items-center">
            <div>
                <p class="font-medium">{{ $category->name }}</p>
                <p class="text-xs text-gray-500">{{ $category->products_count ?? 0 }} produk</p>
            </div>
            <div class="flex gap-1">
                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', 'service')" 
                    class="text-yellow-600 hover:text-yellow-800 text-sm">
                    <i class="fas fa-edit"></i>
                </button>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                    onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="p-4 text-gray-400 text-sm">Belum ada kategori service</p>
    @endif
</div>

<!-- Services Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <form method="GET" class="flex gap-4">
            <input type="text" name="search" placeholder="Cari jasa..." value="{{ request('search') }}"
                class="px-4 py-2 border rounded-lg flex-1">
            <select name="category_id" onchange="this.form.submit()" class="px-4 py-2 border rounded-lg">
                <option value="">Semua Kategori</option>
                @foreach($allCategories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kategori</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Harga</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Estimasi</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Status</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($services as $service)
            <tr>
                <td class="px-4 py-3">
                    <p class="font-medium">{{ $service->name }}</p>
                    @if($service->description)
                    <p class="text-xs text-gray-500">{{ Str::limit($service->description, 50) }}</p>
                    @endif
                </td>
                <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                        {{ $service->category->name ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right text-sm font-medium">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center text-sm">{{ $service->formatted_time }}</td>
                <td class="px-4 py-3 text-center">
                    @if($service->is_active ?? true)
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Aktif</span>
                    @else
                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Nonaktif</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editService({{ $service->id }}, '{{ $service->name }}', {{ $service->category_id ?? '' }}, {{ $service->price }}, '{{ $service->description ?? '' }}', {{ $service->estimated_time ?? '' }})" 
                            class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus jasa ini?')">
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
                <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada jasa service</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $services->links() }}
    </div>
</div>

<!-- Service Modal -->
<div id="service-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h3 id="service-modal-title" class="text-lg font-bold mb-4">Tambah Jasa</h3>
        <form id="service-form" method="POST">
            @csrf
            <input type="hidden" id="service-method" value="POST">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-2">Nama Jasa <span class="text-red-500">*</span></label>
                    <input type="text" id="service-name" name="name" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select id="service-category" name="category_id" required class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Kategori</option>
                        @foreach($allCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Harga <span class="text-red-500">*</span></label>
                    <input type="number" id="service-price" name="price" required min="0" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Estimasi Waktu (menit)</label>
                <input type="number" id="service-time" name="estimated_time" min="1" class="w-full px-3 py-2 border rounded-lg" placeholder="Contoh: 60">
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Deskripsi</label>
                <textarea id="service-desc" name="description" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="button" onclick="hideServiceModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Category Modal -->
<div id="category-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 id="category-modal-title" class="text-lg font-bold mb-4">Tambah Kategori Service</h3>
        <form id="category-form" method="POST">
            @csrf
            <input type="hidden" id="category-method" value="POST">
            <div>
                <label class="block text-sm font-medium mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" id="category-name" name="name" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <input type="hidden" name="type" value="service">
            <div class="flex gap-2 mt-6">
                <button type="button" onclick="hideCategoryModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function showServiceModal() {
    document.getElementById('service-modal-title').textContent = 'Tambah Jasa';
    document.getElementById('service-form').action = '{{ route('admin.services.store') }}';
    document.getElementById('service-method').value = 'POST';
    document.getElementById('service-name').value = '';
    document.getElementById('service-category').value = '';
    document.getElementById('service-price').value = '';
    document.getElementById('service-time').value = '';
    document.getElementById('service-desc').value = '';
    
    let methodInput = document.querySelector('#service-form input[name="_method"]');
    if (methodInput) methodInput.remove();
    
    document.getElementById('service-modal').classList.remove('hidden');
    document.getElementById('service-modal').classList.add('flex');
}

function editService(id, name, categoryId, price, desc, time) {
    document.getElementById('service-modal-title').textContent = 'Edit Jasa';
    document.getElementById('service-form').action = '/admin/services/' + id;
    document.getElementById('service-method').value = 'PUT';
    document.getElementById('service-name').value = name;
    document.getElementById('service-category').value = categoryId;
    document.getElementById('service-price').value = price;
    document.getElementById('service-time').value = time || '';
    document.getElementById('service-desc').value = desc || '';
    
    let methodInput = document.querySelector('#service-form input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('service-form').appendChild(methodInput);
    }
    methodInput.value = 'PUT';
    
    document.getElementById('service-modal').classList.remove('hidden');
    document.getElementById('service-modal').classList.add('flex');
}

function hideServiceModal() {
    document.getElementById('service-modal').classList.add('hidden');
    document.getElementById('service-modal').classList.remove('flex');
}

function showCategoryModal() {
    document.getElementById('category-modal-title').textContent = 'Tambah Kategori Service';
    document.getElementById('category-form').action = '{{ route('admin.categories.store') }}';
    document.getElementById('category-method').value = 'POST';
    document.getElementById('category-name').value = '';
    
    let methodInput = document.querySelector('#category-form input[name="_method"]');
    if (methodInput) methodInput.remove();
    
    document.getElementById('category-modal').classList.remove('hidden');
    document.getElementById('category-modal').classList.add('flex');
}

function editCategory(id, name, type) {
    document.getElementById('category-modal-title').textContent = 'Edit Kategori';
    document.getElementById('category-form').action = '/admin/categories/' + id;
    document.getElementById('category-method').value = 'PUT';
    document.getElementById('category-name').value = name;
    
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