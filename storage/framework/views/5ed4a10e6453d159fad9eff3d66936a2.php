<?php $__env->startSection('title', 'Tambah Nota Distributor - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('admin.distributor-notes.index')); ?>" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Nota Distributor
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-bold mb-6">Tambah Nota Distributor</h1>
    <form method="POST" action="<?php echo e(route('admin.distributor-notes.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Distributor <span class="text-red-500">*</span></label>
                <select name="distributor_id" required class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Pilih Distributor</option>
                    <?php $__currentLoopData = $distributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($distributor->id); ?>"><?php echo e($distributor->name); ?> - <?php echo e($distributor->company); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Nomor Nota <span class="text-red-500">*</span></label>
                <input type="text" name="note_number" required class="w-full px-3 py-2 border rounded-lg" placeholder="Contoh: NOTA/001/2024">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium mb-2">Tanggal Nota <span class="text-red-500">*</span></label>
                <input type="date" name="date" required class="w-full px-3 py-2 border rounded-lg" value="<?php echo e(date('Y-m-d')); ?>">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
                <input type="date" name="due_date" required class="w-full px-3 py-2 border rounded-lg">
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium mb-2">Total Tagihan <span class="text-red-500">*</span></label>
            <input type="number" name="total_amount" required min="0" step="0.01" class="w-full px-3 py-2 border rounded-lg" placeholder="0">
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium mb-2">Catatan</label>
            <textarea name="notes" rows="3" class="w-full px-3 py-2 border rounded-lg"></textarea>
        </div>
        <div class="flex gap-2 mt-6">
            <a href="<?php echo e(route('admin.distributor-notes.index')); ?>" class="flex-1 py-2 border rounded-lg hover:bg-gray-50 text-center">Batal</a>
            <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/distributor-notes/create.blade.php ENDPATH**/ ?>