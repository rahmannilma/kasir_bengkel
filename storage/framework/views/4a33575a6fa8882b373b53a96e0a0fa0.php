

<?php $__env->startSection('title', 'Sparepart - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<!-- Stock Notices -->
<?php if(isset($outOfStockCount) && ($outOfStockCount > 0) || (isset($lowStockCount) && $lowStockCount > 0)): ?>
<div class="mb-6 space-y-3">
    <?php if(isset($outOfStockCount) && $outOfStockCount > 0): ?>
    <div class="bg-red-100 border-l-4 border-red-600 p-4 rounded-r flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
        <div>
            <p class="font-bold text-red-800">Stok Habis!</p>
            <p class="text-sm text-red-700"><?php echo e($outOfStockCount); ?> sparepart telah habis stoknya</p>
        </div>
        <a href="<?php echo e(route('admin.products.index', ['stock_filter' => 'out'])); ?>" class="ml-auto bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
            Lihat
        </a>
    </div>
    <?php endif; ?>
    
    <?php if(isset($lowStockCount) && $lowStockCount > 0): ?>
    <div class="bg-orange-100 border-l-4 border-orange-500 p-4 rounded-r flex items-center gap-3">
        <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
        <div>
            <p class="font-bold text-orange-800">Stok Menipis!</p>
            <p class="text-sm text-orange-700"><?php echo e($lowStockCount); ?> sparepart stoknya menipis</p>
        </div>
        <a href="<?php echo e(route('admin.products.index', ['stock_filter' => 'low'])); ?>" class="ml-auto bg-orange-500 text-white px-3 py-1 rounded text-sm hover:bg-orange-600">
            Lihat
        </a>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Manajemen Sparepart</h1>
        <p class="text-gray-500">Kelola stok sparepart bengkel</p>
    </div>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah Sparepart
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" placeholder="Cari sparepart..." value="<?php echo e(request('search')); ?>"
            class="px-4 py-2 border rounded-lg flex-1 min-w-[200px]">
        <select name="category_id" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Kategori</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                <?php echo e($category->name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="stock_filter" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Stok</option>
            <option value="low" <?php echo e(request('stock_filter') == 'low' ? 'selected' : ''); ?>>Stok Menipis</option>
            <option value="out" <?php echo e(request('stock_filter') == 'out' ? 'selected' : ''); ?>>Stok Habis</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
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
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="<?php echo e($product->is_low_stock ? 'bg-red-50' : ''); ?>">
                <td class="px-4 py-3 text-sm"><?php echo e($product->code); ?></td>
                <td class="px-4 py-3">
                    <p class="font-medium"><?php echo e($product->name); ?></p>
                    <?php if($product->brand): ?>
                    <p class="text-xs text-gray-500"><?php echo e($product->brand); ?></p>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-sm"><?php echo e($product->category->name ?? '-'); ?></td>
                <td class="px-4 py-3 text-right text-sm">Rp <?php echo e(number_format($product->selling_price, 0, ',', '.')); ?></td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-sm <?php echo e($product->stock <= $product->min_stock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'); ?>">
                        <?php echo e($product->stock); ?>

                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="showStockModal(<?php echo e($product->id); ?>, '<?php echo e($product->name); ?>', <?php echo e($product->stock); ?>)" 
                            class="text-blue-600 hover:text-blue-800" title="Atur Stok">
                            <i class="fas fa-boxes"></i>
                        </button>
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus sparepart ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada sparepart</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="p-4 border-t">
        <?php echo e($products->links()); ?>

    </div>
</div>

<!-- Stock Modal -->
<div id="stock-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Atur Stok</h3>
        <p class="mb-4">Produk: <span id="stock-product-name" class="font-medium"></span></p>
        <p class="mb-4">Stok Saat Ini: <span id="stock-current" class="font-medium"></span></p>
        
        <form action="" method="POST" id="stock-form">
            <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/products/index.blade.php ENDPATH**/ ?>