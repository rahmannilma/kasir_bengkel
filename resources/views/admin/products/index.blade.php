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

<div class="mb-4 flex justify-between items-center">
    <div>
        <h1 class="text-xl font-bold">Manajemen Sparepart</h1>
        <p class="text-xs text-gray-500">Kelola sparepart, stok, dan kategori</p>
    </div>
    <div class="flex gap-2">
        <button onclick="document.getElementById('import-modal').classList.remove('hidden'); document.getElementById('import-modal').classList.add('flex')" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">
            <i class="fas fa-file-import mr-1"></i> Import
        </button>
        <button onclick="showProductModal()" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">
            <i class="fas fa-plus mr-1"></i> Tambah
        </button>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-4 gap-2 mb-4">
    <div class="bg-white rounded shadow p-3">
        <p class="text-[10px] text-gray-500">Total Sparepart</p>
        <p class="text-lg font-bold">{{ $products->total() }}</p>
    </div>
    <div class="bg-white rounded shadow p-3">
        <p class="text-[10px] text-gray-500">Jenis Berbeda</p>
        <p class="text-lg font-bold">{{ $allJenis->count() }}</p>
    </div>
    <div class="bg-white rounded shadow p-3">
        <p class="text-[10px] text-gray-500">Stok Habis</p>
        <p class="text-lg font-bold text-red-600">{{ $outOfStockCount }}</p>
    </div>
    <div class="bg-white rounded shadow p-3">
        <p class="text-[10px] text-gray-500">Stok Menipis</p>
        <p class="text-lg font-bold text-orange-500">{{ $lowStockCount }}</p>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded shadow overflow-hidden">
    <div class="p-2 border-b">
        <div class="flex flex-wrap items-center gap-2 mb-2">
            <form method="GET" class="flex flex-wrap items-center gap-2 flex-1">
                <input type="text" name="search" onchange="this.form.submit()" placeholder="Cari sparepart..." value="{{ request('search') }}"
                    class="px-2 py-1 border rounded w-full sm:w-auto sm:min-w-[140px] text-xs">
                <button type="button" onclick="document.getElementById('filter-options').classList.toggle('hidden')" 
                    class="px-2 py-1 border rounded bg-gray-50 hover:bg-gray-100 text-xs">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <div id="filter-options" class="hidden w-full sm:flex flex-wrap gap-1 mt-2 sm:mt-0">
                    <select name="jenis" onchange="this.form.submit()" class="px-2 py-1 border rounded text-xs">
                        <option value="">Semua Kategori</option>
                        <option value="Aki" {{ request('jenis') == 'Aki' ? 'selected' : '' }}>Aki</option>
                        <option value="Ban Luar" {{ request('jenis') == 'Ban Luar' ? 'selected' : '' }}>Ban Luar</option>
                        <option value="Ban Dalam" {{ request('jenis') == 'Ban Dalam' ? 'selected' : '' }}>Ban Dalam</option>
                        <option value="Oli" {{ request('jenis') == 'Oli' ? 'selected' : '' }}>Oli</option>
                        <option value="Sparepart" {{ request('jenis') == 'Sparepart' ? 'selected' : '' }}>Sparepart</option>
                    </select>
                    <select name="stock_filter" id="stock-filter" onchange="this.form.submit()" class="px-2 py-1 border rounded text-xs">
                        <option value="">Semua Stok</option>
                        <option value="low" {{ request('stock_filter') == 'low' ? 'selected' : '' }}>Stok Menipis</option>
                        <option value="out" {{ request('stock_filter') == 'out' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <table class="w-full text-xs">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Kode</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Nama</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Jenis</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Merek</th>
                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500">Harga Beli</th>
                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500">Harga Jual</th>
                <th class="px-3 py-2 text-center text-xs font-medium text-gray-500">Stok</th>
                <th class="px-3 py-2 text-center text-xs font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($products as $product)
            <tr class="{{ $product->is_low_stock ? 'bg-red-50' : '' }}">
                <td class="px-3 py-2">{{ $product->code }}</td>
                <td class="px-3 py-2">
                    <p class="font-medium">{{ $product->name }}</p>
                    @if($product->part_number)
                    <p class="text-[10px] text-gray-500">{{ $product->part_number }}</p>
                    @endif
                </td>
                <td class="px-3 py-2">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-[10px]">
                        {{ $product->jenis ?? '-' }}
                    </span>
                </td>
                <td class="px-3 py-2">{{ $product->brand ?? '-' }}</td>
                <td class="px-3 py-2 text-right">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                <td class="px-3 py-2 text-right">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                <td class="px-3 py-2 text-center">
                    <span class="px-2 py-1 rounded text-[10px] {{ $product->stock <= $product->min_stock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="px-3 py-2 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="showStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})" 
                            class="text-blue-600 hover:text-blue-800" title="Atur Stok">
                            <i class="fas fa-boxes"></i>
                        </button>
                        <button onclick="editProduct({{ $product->id }}, '{{ $product->code }}', '{{ $product->name }}', '{{ $product->jenis ?? '' }}', '{{ $product->brand ?? '' }}', '{{ $product->part_number ?? '' }}', {{ $product->purchase_price }}, {{ $product->selling_price }}, {{ $product->stock }}, {{ $product->min_stock }}, '{{ $product->description ?? '' }}')"
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
                <td colspan="7" class="px-3 py-8 text-center text-gray-400 text-xs">Belum ada sparepart</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-2 border-t">
        {{ $products->appends(request()->query())->links() }}
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
                    <label class="block text-sm font-medium mb-2">Jenis</label>
                    <input type="text" id="product-jenis" name="jenis" class="w-full px-3 py-2 border rounded-lg" placeholder="Mis: Oli, Ban, Parts">
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

<!-- Import Modal -->
<div id="import-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Import Data Sparepart dari Excel</h3>
        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Pilih File Excel (.xlsx, .xls)</label>
                <input type="file" name="file" accept=".xlsx,.xls" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-yellow-800 font-medium mb-2">Format Kolom (wajib):</p>
                <p class="text-xs text-yellow-700">kode, nama, harga_beli, harga_jual, stok, stok_minimum</p>
                <p class="text-sm text-yellow-800 font-medium mb-1 mt-2">Opsional:</p>
                <p class="text-xs text-yellow-700">jenis, merek, part_number, deskripsi</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden'); document.getElementById('import-modal').classList.remove('flex')" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Import</button>
            </div>
        </form>
    </div>
</div>

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
    document.getElementById('product-jenis').value = '';
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

function editProduct(id, code, name, jenis, brand, partNumber, purchasePrice, sellingPrice, stock, minStock, desc) {
    document.getElementById('product-modal-title').textContent = 'Edit Sparepart';
    document.getElementById('product-form').action = '/admin/products/' + id;
    document.getElementById('product-method').value = 'PUT';
    document.getElementById('product-code').value = code;
    document.getElementById('product-name').value = name;
    document.getElementById('product-jenis').value = jenis;
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