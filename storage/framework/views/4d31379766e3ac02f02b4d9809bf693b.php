<?php $__env->startSection('title', 'Stok Menipis - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Stok Menipis</h1>
        <p class="text-gray-500">Daftar sparepart dengan stok di bawah minimum</p>
    </div>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Sparepart
    </a>
</div>

<!-- Alert Summary -->
<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 flex items-center gap-3">
    <div class="bg-red-100 p-3 rounded-full">
        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
    </div>
    <div>
        <p class="font-semibold text-red-800"><?php echo e($products->total()); ?> sparepart memerlukan restok</p>
        <p class="text-sm text-red-600">Segera lakukan pemesanan ulang untuk menghindari kehabisan stok</p>
    </div>
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
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-red-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-red-700">Kode</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-red-700">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-red-700">Kategori</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-red-700">Distributor</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-red-700">Harga Jual</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-red-700">Stok Saat Ini</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-red-700">Stok Minimum</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-red-700">Kekurangan</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-red-700">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="bg-red-50/30 hover:bg-red-50/60">
                <td class="px-4 py-3 text-sm"><?php echo e($product->code); ?></td>
                <td class="px-4 py-3">
                    <p class="font-medium"><?php echo e($product->name); ?></p>
                    <?php if($product->brand): ?>
                    <p class="text-xs text-gray-500"><?php echo e($product->brand); ?></p>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-sm"><?php echo e($product->category->name ?? '-'); ?></td>
                <td class="px-4 py-3 text-sm">
                    <?php echo e($product->category->distributor->name ?? '-'); ?>

                    <?php if($product->category->distributor && $product->category->distributor->phone): ?>
                    <p class="text-xs text-gray-500"><?php echo e($product->category->distributor->phone); ?></p>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-right text-sm">Rp <?php echo e(number_format($product->selling_price, 0, ',', '.')); ?></td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-sm font-bold <?php echo e($product->stock == 0 ? 'bg-red-600 text-white' : 'bg-red-100 text-red-800'); ?>">
                        <?php echo e($product->stock); ?>

                    </span>
                </td>
                <td class="px-4 py-3 text-center text-sm"><?php echo e($product->min_stock); ?></td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-sm bg-red-100 text-red-800 font-medium">
                        <?php echo e($product->min_stock - $product->stock); ?>

                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="showStockModal(<?php echo e($product->id); ?>, '<?php echo e($product->name); ?>', <?php echo e($product->stock); ?>)"
                            class="text-blue-600 hover:text-blue-800" title="Tambah Stok">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                    <i class="fas fa-check-circle text-green-500 text-3xl mb-2 block"></i>
                    Semua stok sparepart dalam kondisi baik
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if($products->hasPages()): ?>
    <div class="p-4 border-t">
        <?php echo e($products->links()); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Stock Modal -->
<div id="stock-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Tambah Stok</h3>
        <p class="mb-4">Produk: <span id="stock-product-name" class="font-medium"></span></p>
        <p class="mb-4">Stok Saat Ini: <span id="stock-current" class="font-medium text-red-600"></span></p>

        <form action="" method="POST" id="stock-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="type" value="add">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Jumlah Tambahan</label>
                <input type="number" name="quantity" min="1" required class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan jumlah">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Catatan</label>
                <textarea name="notes" class="w-full px-3 py-2 border rounded-lg" rows="2" placeholder="Contoh: Pembelian dari distributor X"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="hideStockModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-1"></i> Tambah Stok
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/products/low-stock.blade.php ENDPATH**/ ?>