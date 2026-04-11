@extends('layouts.admin')

@section('title', 'Sparepart - Bengkel POS')

@section('admin_content')
@if(isset($outOfStockCount) && ($outOfStockCount > 0) || (isset($lowStockCount) && $lowStockCount > 0))
<div class="mb-6 space-y-3">
    @if(isset($outOfStockCount) && $outOfStockCount > 0)
    <div class="bg-red-100 border-l-4 border-red-600 p-4 rounded-r flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
        <div>
            <p class="font-bold text-red-800">Stok Habis!</p>
            <p class="text-sm text-red-700">{{ $outOfStockCount }} sparepart telah habis stoknya</p>
        </div>
        <a href="{{ route('admin.products.index', ['stock_filter' => 'out']) }}" class="ml-auto bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
            Lihat
        </a>
    </div>
    @endif
    
    @if(isset($lowStockCount) && $lowStockCount > 0)
    <div class="bg-orange-100 border-l-4 border-orange-500 p-4 rounded-r flex items-center gap-3">
        <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
        <div>
            <p class="font-bold text-orange-800">Stok Menipis!</p>
            <p class="text-sm text-orange-700">{{ $lowStockCount }} sparepart stoknya menipis</p>
        </div>
        <a href="{{ route('admin.products.index', ['stock_filter' => 'low']) }}" class="ml-auto bg-orange-500 text-white px-3 py-1 rounded text-sm hover:bg-orange-600">
            Lihat
        </a>
    </div>
    @endif
</div>
@endif

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Manajemen Sparepart</h1>
        <p class="text-gray-500">Kelola sparepart, stok, dan kategori</p>
    </div>
    <button onclick="showProductModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah Sparepart
    </button>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Sparepart</p>
        <p class="text-2xl font-bold">{{ $products->total() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Kategori Sparepart</p>
        <p class="text-2xl font-bold">{{ $allCategories->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Stok Habis</p>
        <p class="text-2xl font-bold text-red-600">{{ $outOfStockCount }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Stok Menipis</p>
        <p class="text-2xl font-bold text-orange-500">{{ $lowStockCount }}</p>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="font-semibold">Kategori Sparepart</h2>
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
                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', 'product')" 
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
    <p class="p-4 text-gray-400 text-sm">Belum ada kategori sparepart</p>
    @endif
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="text" name="search" placeholder="Cari sparepart..." value="{{ request('search') }}"
                class="px-4 py-2 border rounded-lg flex-1 min-w-[200px]">
            <select name="category_id" class="px-4 py-2 border rounded-lg">
                <option value="">Semua Kategori</option>
                @foreach($allCategories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            <select name="stock_filter" class="px-4 py-2 border rounded-lg">
                <option value="">Semua Stok</option>
                <option value="low" {{ request('stock_filter') == 'low' ? 'selected' : '' }}>Stok Menipis</option>
                <option value="out" {{ request('stock_filter') == 'out' ? 'selected' : '' }}>Stok Habis</option>
            </select>
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kode</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kategori</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Harga Jual</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Stok</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($products as $product)
            <tr class="{{ $product->is_low_stock ? 'bg-red-50' : '' }}">
                <td class="px-4 py-3 text-sm">{{ $product->code }}</td>
                <td class="px-4 py-3">
                    <p class="font-medium">{{ $product->name }}</p>
                    @if($product->brand)
                    <p class="text-xs text-gray-500">{{ $product->brand }}</p>
                    @endif
                </td>
                <td class="px-4 py-3 text-sm">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                        {{ $product->category->name ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right text-sm">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-sm {{ $product->stock <= $product->min_stock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="showStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})" 
                            class="text-blue-600 hover:text-blue-800" title="Atur Stok">
                            <i class="fas fa-boxes"></i>
                        </button>
                        <button onclick="editProduct({{ $product->id }}, '{{ $product->code }}', '{{ $product->name }}', {{ $product->category_id ?? '' }}, '{{ $product->brand ?? '' }}', '{{ $product->part_number ?? '' }}', {{ $product->purchase_price }}, {{ $product->selling_price }}, {{ $product->stock }}, {{ $product->min_stock }}, '{{ $product->description ?? '' }}')"
                            class="text-yellow-600 hover:text-yellow-800" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus sparepart ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada sparepart</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $products->links() }}
    </div>
</div>

<!-- Product Modal -->
<div id="product-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
        <h3 id="product-modal-title" class="text-lg font-bold mb-4">Tambah Sparepart</h3>
        <form id="product-form" method="POST">
            @csrf
            <input type="hidden" id="product-method" value="POST">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Kode <span class="text-red-500">*</span></label>
                    <input type="text" id="product-code" name="code" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Nama <span class="text-red-500">*</span></label>
                    <input type="text" id="product-name" name="name" required class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select id="product-category" name="category_id" required class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Pilih Kategori</option>
                        @foreach($allCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Merek</label>
                    <input type="text" id="product-brand" name="brand" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Part Number</label>
                    <input type="text" id="product-part" name="part_number" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Harga Beli <span class="text-red-500">*</span></label>
                    <input type="number" id="product-purchase" name="purchase_price" required min="0" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Harga Jual <span class="text-red-500">*</span></label>
                    <input type="number" id="product-selling" name="selling_price" required min="0" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" id="product-stock" name="stock" required min="0" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Stok Minimum <span class="text-red-500">*</span></label>
                <input type="number" id="product-min" name="min_stock" required min="0" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Deskripsi</label>
                <textarea id="product-desc" name="description" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="button" onclick="hideProductModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Category Modal -->
<div id="category-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 id="category-modal-title" class="text-lg font-bold mb-4">Tambah Kategori Sparepart</h3>
        <form id="category-form" method="POST">
            @csrf
            <input type="hidden" id="category-method" value="POST">
            <div>
                <label class="block text-sm font-medium mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" id="category-name" name="name" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <input type="hidden" name="type" value="product">
            <div class="flex gap-2 mt-6">
                <button type="button" onclick="hideCategoryModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Stock Modal -->
<div id="stock-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Atur Stok</h3>
        <p class="mb-4">Produk: <span id="stock-product-name" class="font-medium"></span></p>
        <p class="mb-4">Stok Saat Ini: <span id="stock-current" class="font-medium"></span></p>
        
        <form action="" method="POST" id="stock-form">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Tipe</label>
                <select name="type" class="w-full px-3 py-2 border rounded-lg">
                    <option value="add">Tambah Stok</option>
                    <option value="reduce">Kurangi Stok</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Jumlah</label>
                <input type="number" name="quantity" min="1" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Catatan</label>
                <textarea name="notes" class="w-full px-3 py-2 border rounded-lg" rows="2"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="hideStockModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showProductModal() {
    document.getElementById('product-modal-title').textContent = 'Tambah Sparepart';
    document.getElementById('product-form').action = '{{ route('admin.products.store') }}';
    document.getElementById('product-method').value = 'POST';
    document.getElementById('product-code').value = '';
    document.getElementById('product-name').value = '';
    document.getElementById('product-category').value = '';
    document.getElementById('product-brand').value = '';
    document.getElementById('product-part').value = '';
    document.getElementById('product-purchase').value = '';
    document.getElementById('product-selling').value = '';
    document.getElementById('product-stock').value = '';
    document.getElementById('product-min').value = '';
    document.getElementById('product-desc').value = '';
    
    let methodInput = document.querySelector('#product-form input[name="_method"]');
    if (methodInput) methodInput.remove();
    
    document.getElementById('product-modal').classList.remove('hidden');
    document.getElementById('product-modal').classList.add('flex');
}

function editProduct(id, code, name, categoryId, brand, partNumber, purchasePrice, sellingPrice, stock, minStock, desc) {
    document.getElementById('product-modal-title').textContent = 'Edit Sparepart';
    document.getElementById('product-form').action = '/admin/products/' + id;
    document.getElementById('product-method').value = 'PUT';
    document.getElementById('product-code').value = code;
    document.getElementById('product-name').value = name;
    document.getElementById('product-category').value = categoryId;
    document.getElementById('product-brand').value = brand;
    document.getElementById('product-part').value = partNumber;
    document.getElementById('product-purchase').value = purchasePrice;
    document.getElementById('product-selling').value = sellingPrice;
    document.getElementById('product-stock').value = stock;
    document.getElementById('product-min').value = minStock;
    document.getElementById('product-desc').value = desc || '';
    
    let methodInput = document.querySelector('#product-form input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('product-form').appendChild(methodInput);
    }
    methodInput.value = 'PUT';
    
    document.getElementById('product-modal').classList.remove('hidden');
    document.getElementById('product-modal').classList.add('flex');
}

function hideProductModal() {
    document.getElementById('product-modal').classList.add('hidden');
    document.getElementById('product-modal').classList.remove('flex');
}

function showCategoryModal() {
    document.getElementById('category-modal-title').textContent = 'Tambah Kategori Sparepart';
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
    document.getElementById('category-modal').classListadd('flex');
}

function hideCategoryModal() {
    document.getElementById('category-modal').classList.add('hidden');
    document.getElementById('category-modal').classList.remove('flex');
}

function showStockModal(productId, productName, currentStock) {
    document.getElementById('stock-product-name').textContent = productName;
    document.getElementById('stock-current').textContent = currentStock;
    document.getElementById('stock-form').action = '/admin/products/' + productId + '/stock';
    document.getElementById('stock-modal').classList.remove('hidden');
    document.getElementById('stock-modal').classList.add('flex');
}

function hideStockModal() {
    document.getElementById('stock-modal').classList.add('hidden');
    document.getElementById('stock-modal').classList.remove('flex');
}
</script>
@endsection