@extends('layouts.app')

@section('title', 'Kasir - Bengkel POS')

@section('content')
<div class="flex h-screen">
    <!-- Left Panel - Product & Service Selection -->
    <div class="flex-1 flex flex-col bg-gray-100">
        <!-- Header -->
        <div class="bg-white shadow p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">Kasir</h1>
                    <p class="text-sm text-gray-500">{{ now()->format('d M Y, H:i') }} | {{ auth()->user()->name }}</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Hari Ini</p>
                        <p class="text-lg font-bold text-green-600">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Transaksi</p>
                        <p class="text-lg font-bold">{{ $todayTransactions }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Type Tabs -->
        <div class="bg-white border-b">
            <div class="flex">
                <button onclick="switchType('product')" id="type-product" class="px-6 py-3 font-medium text-blue-600 border-b-2 border-blue-600">
                    Sparepart
                </button>
                <button onclick="switchType('service')" id="type-service" class="px-6 py-3 font-medium text-gray-500 hover:text-blue-600">
                    Jasa
                </button>
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="bg-white border-b">
            <div class="flex overflow-x-auto" id="category-tabs">
                {{-- Product categories --}}
                <button onclick="switchCategory('all-product')" data-type="product" class="cat-tab cat-tab-product whitespace-nowrap px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                    Semua Sparepart
                </button>
                @foreach($productCategories as $category)
                <button onclick="switchCategory('cat-product-{{ $category->id }}')" data-type="product" class="cat-tab cat-tab-product whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-500 hover:text-blue-600">
                    {{ $category->name }}
                </button>
                @endforeach
                @if($productsWithoutCategory->isNotEmpty())
                <button onclick="switchCategory('no-cat-product')" data-type="product" class="cat-tab cat-tab-product whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-500 hover:text-blue-600">
                    Tanpa Kategori
                </button>
                @endif

                {{-- Service categories --}}
                <button onclick="switchCategory('all-service')" data-type="service" class="cat-tab cat-tab-service whitespace-nowrap px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600 hidden">
                    Semua Jasa
                </button>
                @foreach($serviceCategories as $category)
                <button onclick="switchCategory('cat-service-{{ $category->id }}')" data-type="service" class="cat-tab cat-tab-service whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-500 hover:text-blue-600 hidden">
                    {{ $category->name }}
                </button>
                @endforeach
                @if($servicesWithoutCategory->isNotEmpty())
                <button onclick="switchCategory('no-cat-service')" data-type="service" class="cat-tab cat-tab-service whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-500 hover:text-blue-600 hidden">
                    Tanpa Kategori
                </button>
                @endif
            </div>
        </div>

        <!-- Search -->
        <div class="p-4 bg-white">
            <input type="text" id="search" placeholder="Cari produk/jasa..." 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                oninput="filterItems()">
        </div>

        <!-- Items Grid -->
        <div class="flex-1 overflow-y-auto p-4" id="items-container">
            {{-- Product: All --}}
            <div id="panel-all-product" class="category-panel" data-type="product">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($productCategories as $category)
                        @foreach($category->products as $product)
                        <button onclick="addItem('product', {{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->selling_price }}, {{ $product->stock }})"
                            class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between
                            {{ $product->stock <= $product->min_stock ? 'border-2 border-red-400' : '' }}"
                            data-name="{{ strtolower($product->name) }}" data-type="product" data-category-id="{{ $category->id }}">
                            <div>
                                <p class="font-medium text-sm line-clamp-2">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $category->name }}</p>
                            </div>
                            <div class="flex justify-between items-end">
                                <p class="text-blue-600 font-bold">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400">Stok: {{ $product->stock }}</p>
                            </div>
                        </button>
                        @endforeach
                    @endforeach
                    @foreach($productsWithoutCategory as $product)
                    <button onclick="addItem('product', {{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->selling_price }}, {{ $product->stock }})"
                        class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between
                        {{ $product->stock <= $product->min_stock ? 'border-2 border-red-400' : '' }}"
                        data-name="{{ strtolower($product->name) }}" data-type="product" data-category-id="none">
                        <div>
                            <p class="font-medium text-sm line-clamp-2">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">Tanpa Kategori</p>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-blue-600 font-bold">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">Stok: {{ $product->stock }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
                @if($productCategories->isEmpty() && $productsWithoutCategory->isEmpty())
                <p class="text-center text-gray-400 py-8">Tidak ada sparepart tersedia</p>
                @endif
            </div>

            {{-- Product: Per-category panels --}}
            @foreach($productCategories as $category)
            <div id="panel-cat-product-{{ $category->id }}" class="category-panel hidden" data-type="product">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($category->products as $product)
                    <button onclick="addItem('product', {{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->selling_price }}, {{ $product->stock }})"
                        class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between
                        {{ $product->stock <= $product->min_stock ? 'border-2 border-red-400' : '' }}"
                        data-name="{{ strtolower($product->name) }}" data-type="product" data-category-id="{{ $category->id }}">
                        <div>
                            <p class="font-medium text-sm line-clamp-2">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $category->name }}</p>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-blue-600 font-bold">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">Stok: {{ $product->stock }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach

            {{-- Product: Without category --}}
            @if($productsWithoutCategory->isNotEmpty())
            <div id="panel-no-cat-product" class="category-panel hidden" data-type="product">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($productsWithoutCategory as $product)
                    <button onclick="addItem('product', {{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->selling_price }}, {{ $product->stock }})"
                        class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between
                        {{ $product->stock <= $product->min_stock ? 'border-2 border-red-400' : '' }}"
                        data-name="{{ strtolower($product->name) }}" data-type="product" data-category-id="none">
                        <div>
                            <p class="font-medium text-sm line-clamp-2">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">Tanpa Kategori</p>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-blue-600 font-bold">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">Stok: {{ $product->stock }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Service: All --}}
            <div id="panel-all-service" class="category-panel hidden" data-type="service">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($serviceCategories as $category)
                        @foreach($category->services as $service)
                        <button onclick="addItem('service', {{ $service->id }}, '{{ addslashes($service->name) }}', {{ $service->price }}, 999)"
                            class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between"
                            data-name="{{ strtolower($service->name) }}" data-type="service" data-category-id="{{ $category->id }}">
                            <div>
                                <p class="font-medium text-sm line-clamp-2">{{ $service->name }}</p>
                                <p class="text-xs text-gray-500">{{ $category->name }}</p>
                            </div>
                            <div class="flex justify-between items-end">
                                <p class="text-green-600 font-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                @if($service->estimated_time)
                                <p class="text-xs text-gray-400">{{ $service->formatted_time }}</p>
                                @endif
                            </div>
                        </button>
                        @endforeach
                    @endforeach
                    @foreach($servicesWithoutCategory as $service)
                    <button onclick="addItem('service', {{ $service->id }}, '{{ addslashes($service->name) }}', {{ $service->price }}, 999)"
                        class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between"
                        data-name="{{ strtolower($service->name) }}" data-type="service" data-category-id="none">
                        <div>
                            <p class="font-medium text-sm line-clamp-2">{{ $service->name }}</p>
                            <p class="text-xs text-gray-500">Tanpa Kategori</p>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-green-600 font-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            @if($service->estimated_time)
                            <p class="text-xs text-gray-400">{{ $service->formatted_time }}</p>
                            @endif
                        </div>
                    </button>
                    @endforeach
                </div>
                @if($serviceCategories->isEmpty() && $servicesWithoutCategory->isEmpty())
                <p class="text-center text-gray-400 py-8">Tidak ada jasa tersedia</p>
                @endif
            </div>

            {{-- Service: Per-category panels --}}
            @foreach($serviceCategories as $category)
            <div id="panel-cat-service-{{ $category->id }}" class="category-panel hidden" data-type="service">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($category->services as $service)
                    <button onclick="addItem('service', {{ $service->id }}, '{{ addslashes($service->name) }}', {{ $service->price }}, 999)"
                        class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between"
                        data-name="{{ strtolower($service->name) }}" data-type="service" data-category-id="{{ $category->id }}">
                        <div>
                            <p class="font-medium text-sm line-clamp-2">{{ $service->name }}</p>
                            <p class="text-xs text-gray-500">{{ $category->name }}</p>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-green-600 font-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            @if($service->estimated_time)
                            <p class="text-xs text-gray-400">{{ $service->formatted_time }}</p>
                            @endif
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach

            {{-- Service: Without category --}}
            @if($servicesWithoutCategory->isNotEmpty())
            <div id="panel-no-cat-service" class="category-panel hidden" data-type="service">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($servicesWithoutCategory as $service)
                    <button onclick="addItem('service', {{ $service->id }}, '{{ addslashes($service->name) }}', {{ $service->price }}, 999)"
                        class="bg-white rounded-lg shadow p-4 text-left hover:shadow-lg transition h-32 flex flex-col justify-between"
                        data-name="{{ strtolower($service->name) }}" data-type="service" data-category-id="none">
                        <div>
                            <p class="font-medium text-sm line-clamp-2">{{ $service->name }}</p>
                            <p class="text-xs text-gray-500">Tanpa Kategori</p>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-green-600 font-bold">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            @if($service->estimated_time)
                            <p class="text-xs text-gray-400">{{ $service->formatted_time }}</p>
                            @endif
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Right Panel - Cart -->
    <div class="w-96 bg-white shadow-xl flex flex-col">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-bold">Keranjang</h2>
            <div class="flex gap-2">
                <button onclick="showManualServiceModal()" type="button" class="text-sm bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">
                    <i class="fas fa-plus mr-1"></i> Jasa Manual
                </button>
                <button onclick="clearCart()" class="text-sm text-red-500 hover:text-red-700">Clear All</button>
            </div>
        </div>

        <form id="transaction-form" action="{{ route('transactions.store') }}" method="POST" class="flex-1 flex flex-col">
            @csrf
            
            <!-- Customer Info -->
            <div class="p-4 border-b space-y-3">
                <div>
                    <label class="block text-sm font-medium mb-2">Nama Pelanggan</label>
                    <input type="text" name="customer_name" id="customer-name" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Masukkan nama pelanggan">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Plat Nomor</label>
                    <input type="text" name="customer_plate" id="customer-plate" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Contoh: B 1234 XYZ">
                </div>
            </div>

            <!-- Mechanic Selection -->
            <div class="p-4 border-b">
                <label class="block text-sm font-medium mb-2"><i class="fas fa-user-hard-hat mr-1"></i> Mekanik (bisa pilih lebih dari 1)</label>
                <div class="space-y-2 max-h-32 overflow-y-auto border rounded-lg p-2" id="mechanics-container">
                    @foreach($mechanics as $mechanic)
                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                        <input type="checkbox" name="mechanic_ids[]" value="{{ $mechanic->id }}" class="rounded text-blue-600">
                        <span class="text-sm">{{ $mechanic->name }}{{ $mechanic->specialization ? ' - ' . $mechanic->specialization : '' }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4" id="cart-items">
                <div class="text-center text-gray-400 py-8">
                    <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                    <p>Keranjang kosong</p>
                </div>
            </div>

            <!-- Hidden items for form submission -->
            <div id="hidden-items"></div>

            <!-- Summary -->
            <div class="p-4 border-t space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Subtotal</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Diskon</span>
                    <input type="number" name="discount" id="discount" value="0" min="0" 
                        class="w-24 text-right border rounded px-2 py-1" onchange="calculateTotal()">
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span id="total">Rp 0</span>
                </div>
            </div>

            <!-- Payment -->
            <div class="p-4 border-t space-y-3">
                <div>
                    <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                    <select name="payment_method" id="payment-method" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="cash">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="debit">Debit</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                <div id="cash-input">
                    <label class="block text-sm font-medium mb-2">Jumlah Bayar</label>
                    <input type="text" name="cash_received" id="cash-received" 
                        class="w-full px-3 py-2 border rounded-lg" placeholder="Contoh: 100.000"
                        oninput="formatCashInput(this); calculateChange()">
                </div>
                <div id="change-display" class="text-right text-lg font-bold text-green-600 hidden">
                    Kembalian: <span id="change">Rp 0</span>
                </div>
            </div>

            <!-- Submit -->
            <div class="p-4 bg-gray-50">
                <input type="hidden" name="notes" id="notes">
                <button type="submit" id="submit-btn" disabled
                    class="w-full py-3 rounded-lg font-bold text-white disabled:bg-gray-300 disabled:cursor-not-allowed
                    bg-green-600 hover:bg-green-700 transition">
                    <i class="fas fa-check mr-2"></i> Bayar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let cart = [];
let currentType = 'product';
let currentCategory = 'all-product';

function switchType(type) {
    currentType = type;

    // Toggle type tab styles
    document.getElementById('type-product').classList.toggle('border-b-2', type === 'product');
    document.getElementById('type-product').classList.toggle('border-blue-600', type === 'product');
    document.getElementById('type-product').classList.toggle('text-blue-600', type === 'product');
    document.getElementById('type-product').classList.toggle('text-gray-500', type !== 'product');

    document.getElementById('type-service').classList.toggle('border-b-2', type === 'service');
    document.getElementById('type-service').classList.toggle('border-blue-600', type === 'service');
    document.getElementById('type-service').classList.toggle('text-blue-600', type === 'service');
    document.getElementById('type-service').classList.toggle('text-gray-500', type !== 'service');

    // Show/hide category tabs
    document.querySelectorAll('.cat-tab').forEach(tab => {
        tab.classList.toggle('hidden', tab.dataset.type !== type);
    });

    // Activate "Semua" category for the selected type
    switchCategory('all-' + type);
}

function switchCategory(categoryId) {
    currentCategory = categoryId;

    // Update category tab styles
    document.querySelectorAll('.cat-tab').forEach(tab => {
        const isActive = tab.getAttribute('onclick')?.includes("'" + categoryId + "'");
        tab.classList.toggle('border-b-2', isActive);
        tab.classList.toggle('border-blue-600', isActive);
        tab.classList.toggle('text-blue-600', isActive);
        tab.classList.toggle('text-gray-500', !isActive);
    });

    // Show/hide panels
    document.querySelectorAll('.category-panel').forEach(panel => {
        panel.classList.toggle('hidden', panel.id !== 'panel-' + categoryId);
    });

    // Clear search when switching category
    document.getElementById('search').value = '';
}

function filterItems() {
    const search = document.getElementById('search').value.toLowerCase();
    const activePanel = document.querySelector('.category-panel:not(.hidden)');
    if (!activePanel) return;

    activePanel.querySelectorAll('button').forEach(item => {
        const name = item.dataset.name;
        item.classList.toggle('hidden', search && !name.includes(search));
    });
}

function addItem(type, id, name, price, maxStock) {
    const existingItem = cart.find(item => item.type === type && item.id === id);
    
    if (existingItem) {
        if (existingItem.quantity < maxStock || type === 'service') {
            existingItem.quantity++;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    } else {
        cart.push({ type, id, name, price, maxStock, quantity: 1 });
    }
    
    renderCart();
}

function updateQuantity(index, change) {
    const item = cart[index];
    const newQty = item.quantity + change;
    
    if (newQty <= 0) {
        cart.splice(index, 1);
    } else if (newQty > item.maxStock && item.type === 'product') {
        alert('Stok tidak mencukupi!');
        return;
    } else {
        item.quantity = newQty;
    }
    
    renderCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

function clearCart() {
    if (cart.length > 0 && !confirm('Hapus semua item dari keranjang?')) return;
    cart = [];
    renderCart();
}

function renderCart() {
    const container = document.getElementById('cart-items');
    const hiddenItems = document.getElementById('hidden-items');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-400 py-8">
                <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                <p>Keranjang kosong</p>
            </div>
        `;
        hiddenItems.innerHTML = '';
        document.getElementById('submit-btn').disabled = true;
        return;
    }
    
    let html = '';
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        
        html += `
            <div class="flex justify-between items-center py-2 border-b">
                <div class="flex-1">
                    <p class="font-medium text-sm">${item.name}</p>
                    <p class="text-xs text-gray-500">
                        <span class="cursor-pointer text-blue-600 hover:text-blue-800 underline" onclick="editPrice(${index})" title="Klik untuk ubah harga">
                            Rp ${formatNumber(item.price)}
                        </span> 
                        x ${item.quantity}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="updateQuantity(${index}, -1)" class="w-7 h-7 rounded bg-gray-200 hover:bg-gray-300">-</button>
                    <span class="w-8 text-center">${item.quantity}</span>
                    <button onclick="updateQuantity(${index}, 1)" class="w-7 h-7 rounded bg-gray-200 hover:bg-gray-300">+</button>
                    <button onclick="removeItem(${index})" class="w-7 h-7 rounded bg-red-100 text-red-600 hover:bg-red-200">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Update hidden inputs
    hiddenItems.innerHTML = cart.map((item, index) => `
        <input type="hidden" name="items[${index}][type]" value="${item.type}">
        <input type="hidden" name="items[${index}][id]" value="${item.id}">
        <input type="hidden" name="items[${index}][name]" value="${item.name}">
        <input type="hidden" name="items[${index}][price]" value="${item.price}">
        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
    `).join('');
    
    document.getElementById('submit-btn').disabled = false;
    calculateTotal();
}

function calculateTotal() {
    let subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    let discount = parseInt(document.getElementById('discount').value) || 0;
    let total = subtotal - discount;
    
    document.getElementById('subtotal').textContent = 'Rp ' + formatNumber(subtotal);
    document.getElementById('total').textContent = 'Rp ' + formatNumber(total);
    
    calculateChange();
}

function calculateChange() {
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0) - (parseInt(document.getElementById('discount').value) || 0);
    const cash = getCashValue();
    const change = cash - total;
    
    const changeDisplay = document.getElementById('change-display');
    const changeSpan = document.getElementById('change');
    
    if (document.getElementById('payment-method').value === 'cash' && cash > 0) {
        changeDisplay.classList.remove('hidden');
        changeSpan.textContent = 'Rp ' + formatNumber(Math.max(0, change));
        changeSpan.className = change >= 0 ? 'text-green-600' : 'text-red-600';
    } else {
        changeDisplay.classList.add('hidden');
    }
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatCashInput(input) {
    let value = input.value.replace(/\./g, '');
    value = value.replace(/\D/g, '');
    if (value) {
        input.value = parseInt(value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
}

function getCashValue() {
    const input = document.getElementById('cash-received');
    return parseInt(input.value.replace(/\./g, '')) || 0;
}

function editPrice(index) {
    const item = cart[index];
    const newPrice = prompt(`Ubah harga untuk "${item.name}"\nHarga saat ini: Rp ${formatNumber(item.price)}`, item.price);
    
    if (newPrice !== null) {
        const parsedPrice = parseInt(newPrice);
        if (isNaN(parsedPrice) || parsedPrice < 0) {
            alert('Harga tidak valid!');
            return;
        }
        item.price = parsedPrice;
        renderCart();
    }
}

// Payment method change handler
document.getElementById('payment-method').addEventListener('change', function() {
    const cashInput = document.getElementById('cash-input');
    if (this.value === 'cash') {
        cashInput.classList.remove('hidden');
    } else {
        cashInput.classList.add('hidden');
        document.getElementById('change-display').classList.add('hidden');
    }
});

// Form submission
document.getElementById('transaction-form').addEventListener('submit', function(e) {
    if (cart.length === 0) {
        e.preventDefault();
        alert('Keranjang masih kosong!');
        return;
    }
    
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0) - (parseInt(document.getElementById('discount').value) || 0);
    const paymentMethod = document.getElementById('payment-method').value;
    
    if (paymentMethod === 'cash') {
        const cash = getCashValue();
        if (cash < total) {
            e.preventDefault();
            alert('Jumlah pembayaran kurang dari total!');
            return;
        }
    }
});

// Quick customer form
function showQuickCustomerForm() {
    document.getElementById('quick-customer-modal').classList.remove('hidden');
    document.getElementById('quick-customer-modal').classList.add('flex');
}

function hideQuickCustomerForm() {
    document.getElementById('quick-customer-modal').classList.add('hidden');
    document.getElementById('quick-customer-modal').classList.remove('flex');
}

document.getElementById('quick-customer-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const data = {
        name: document.getElementById('qc-name').value,
        phone: document.getElementById('qc-phone').value,
        vehicle_plate: document.getElementById('qc-plate').value,
        vehicle_brand: document.getElementById('qc-brand').value
    };
    
    // Get CSRF token from cookie
    function getCookie(name) {
        let cookieValue = null;
        if (document.cookie && document.cookie !== '') {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.substring(0, name.length + 1) === (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
    
    try {
        const response = await fetch('{{ route('customers.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCookie('XSRF-TOKEN')
            },
            body: JSON.stringify(data)
        });
        
        if (!response.ok) {
            let errorText;
            try {
                const errorJson = await response.json();
                errorText = errorJson.message || JSON.stringify(errorJson);
            } catch {
                errorText = await response.text();
            }
            alert('Gagal menyimpan pelanggan: ' + response.status + ' - ' + errorText);
            return;
        }
        
        const result = await response.json();
        
        if (result.id) {
            const select = document.getElementById('customer-select');
            const option = document.createElement('option');
            option.value = result.id;
            option.textContent = result.name + ' - ' + (result.vehicle_plate || 'N/A');
            select.appendChild(option);
            select.value = result.id;
            
            hideQuickCustomerForm();
            this.reset();
        } else {
            alert('Terjadi kesalahan saat menyimpan pelanggan');
        }
    } catch (error) {
        alert('Gagal menyimpan pelanggan');
    }
});
</script>
<!-- Manual Service Modal -->
<div id="manual-service-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah Jasa Manual</h3>
            <button type="button" onclick="hideManualServiceModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="manual-service-form" class="p-4 space-y-4" onsubmit="return false;">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Jasa</label>
                <input type="text" id="manual-service-name" class="w-full px-3 py-2 border rounded-lg" placeholder="Contoh: Ganti oli mesin">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" id="manual-service-price" class="w-full px-3 py-2 border rounded-lg" placeholder="Contoh: 50000">
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="hideManualServiceModal()" class="flex-1 px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="button" onclick="submitManualService()" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Tambah ke Keranjang</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Service Modal -->
<div id="add-service-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah Jasa Baru</h3>
            <button onclick="hideAddServiceModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="add-service-form" class="p-4 space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Jasa</label>
                <input type="text" id="new-service-name" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select id="new-service-category" class="w-full px-3 py-2 border rounded-lg">
                    @foreach($serviceCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" id="new-service-price" required min="0" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Estimasi Waktu (menit)</label>
                <input type="number" id="new-service-time" min="0" class="w-full px-3 py-2 border rounded-lg" placeholder="Optional">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea id="new-service-description" class="w-full px-3 py-2 border rounded-lg" rows="2" placeholder="Optional"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="hideAddServiceModal()" class="flex-1 px-4 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddServiceModal() {
    document.getElementById('add-service-modal').classList.remove('hidden');
    document.getElementById('add-service-modal').classList.add('flex');
    document.getElementById('new-service-name').focus();
}

function hideAddServiceModal() {
    document.getElementById('add-service-modal').classList.add('hidden');
    document.getElementById('add-service-modal').classList.remove('flex');
    document.getElementById('add-service-form').reset();
}

function showManualServiceModal() {
    const modal = document.getElementById('manual-service-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('manual-service-name').focus();
}

function hideManualServiceModal() {
    const modal = document.getElementById('manual-service-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('manual-service-form').reset();
}

function submitManualService() {
    const nameInput = document.getElementById('manual-service-name');
    const priceInput = document.getElementById('manual-service-price');
    
    const name = nameInput.value.trim();
    const price = parseInt(priceInput.value);
    
    if (!name || !price || price < 0) {
        alert('Mohon isi nama dan harga dengan benar');
        return;
    }
    
    const tempId = 'manual_' + Date.now();
    addItem('service', tempId, name, price, 999);
    hideManualServiceModal();
    alert('Jasa "' + name + '" berhasil ditambahkan ke keranjang!');
}


function getCookie(name) {
    let cookieValue = null;
    if (document.cookie && document.cookie !== '') {
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.substring(0, name.length + 1) === (name + '=')) {
                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                break;
            }
        }
    }
    return cookieValue;
}

document.getElementById('add-service-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const data = {
        name: document.getElementById('new-service-name').value,
        category_id: document.getElementById('new-service-category').value,
        price: document.getElementById('new-service-price').value,
        estimated_time: document.getElementById('new-service-time').value || null,
        description: document.getElementById('new-service-description').value
    };
    
    try {
        const response = await fetch('{{ route('kasir.services.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCookie('XSRF-TOKEN')
            },
            body: JSON.stringify(data)
        });
        
        if (!response.ok) {
            const error = await response.json();
            alert('Gagal: ' + (error.message || 'Terjadi kesalahan'));
            return;
        }
        
        const service = await response.json();
        hideAddServiceModal();
        
        // Add to cart immediately
        addItem('service', service.id, service.name, parseInt(service.price), 999);
        alert('Jasa "' + service.name + '" berhasil ditambahkan ke keranjang!');
        
    } catch (error) {
        alert('Gagal menyimpan jasa');
    }
});
</script>
@endsection
