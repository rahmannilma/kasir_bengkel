<?php $__env->startSection('title', 'Tambah Jasa - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('admin.services.index')); ?>" class="text-blue-600 hover:underline">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h1 class="text-xl font-bold mb-6">Tambah Jasa Baru</h1>

    <form action="<?php echo e(route('admin.services.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Nama Jasa</label>
            <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Kategori</label>
            <select name="category_id" required class="w-full px-3 py-2 border rounded-lg">
                <option value="">Pilih Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-2">Harga</label>
                <input type="number" name="price" value="<?php echo e(old('price')); ?>" required min="0" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Estimasi Waktu (menit)</label>
                <input type="number" name="estimated_time" value="<?php echo e(old('estimated_time')); ?>" min="1" class="w-full px-3 py-2 border rounded-lg">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg"><?php echo e(old('description')); ?></textarea>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="<?php echo e(route('admin.services.index')); ?>" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                Batal
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/services/create.blade.php ENDPATH**/ ?>