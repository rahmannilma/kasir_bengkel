<?php $__env->startSection('title', 'Nota Distributor - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Nota Distributor</h1>
        <p class="text-gray-500">Kelola nota dari distributor dan pengingat jatuh tempo</p>
    </div>
    <a href="<?php echo e(route('admin.distributor-notes.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah Nota
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex gap-4 flex-wrap">
        <select name="status" onchange="this.form.submit()" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Status</option>
            <option value="unpaid" <?php echo e(request('status') == 'unpaid' ? 'selected' : ''); ?>>Belum Lunas</option>
            <option value="partial" <?php echo e(request('status') == 'partial' ? 'selected' : ''); ?>>Sebagian</option>
            <option value="paid" <?php echo e(request('status') == 'paid' ? 'selected' : ''); ?>>Lunas</option>
        </select>
        <select name="distributor_id" onchange="this.form.submit()" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Distributor</option>
            <?php $__currentLoopData = $distributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($distributor->id); ?>" <?php echo e(request('distributor_id') == $distributor->id ? 'selected' : ''); ?>><?php echo e($distributor->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="filter" onchange="this.form.submit()" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Nota</option>
            <option value="overdue" <?php echo e(request('filter') == 'overdue' ? 'selected' : ''); ?>>Jatuh Tempo</option>
            <option value="due_soon" <?php echo e(request('filter') == 'due_soon' ? 'selected' : ''); ?>>Akan Jatuh Tempo (7 hari)</option>
        </select>
    </form>
</div>

<!-- Notes Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">No. Nota</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Distributor</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Total</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Terbayar</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Sisa</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Jatuh Tempo</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Status</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="<?php echo e($note->is_overdue ? 'bg-red-50' : ''); ?>">
                <td class="px-4 py-3 font-medium"><?php echo e($note->note_number); ?></td>
                <td class="px-4 py-3 text-sm"><?php echo e($note->distributor->name); ?></td>
                <td class="px-4 py-3 text-right text-sm">Rp <?php echo e(number_format($note->total_amount, 0, ',', '.')); ?></td>
                <td class="px-4 py-3 text-right text-sm text-green-600">Rp <?php echo e(number_format($note->paid_amount, 0, ',', '.')); ?></td>
                <td class="px-4 py-3 text-right text-sm font-medium">Rp <?php echo e(number_format($note->remaining_amount, 0, ',', '.')); ?></td>
                <td class="px-4 py-3 text-center">
                    <span class="<?php echo e($note->is_overdue ? 'text-red-600 font-bold' : ($note->days_until_due <= 7 && $note->days_until_due >= 0 ? 'text-yellow-600 font-medium' : 'text-gray-600')); ?>">
                        <?php echo e($note->due_date->format('d/m/Y')); ?>

                        <?php if($note->is_overdue): ?>
                            <span class="text-xs block">Terlambat <?php echo e(abs($note->days_until_due)); ?> hari</span>
                        <?php elseif($note->days_until_due <= 7 && $note->days_until_due >= 0): ?>
                            <span class="text-xs block"><?php echo e($note->days_until_due); ?> hari lagi</span>
                        <?php endif; ?>
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <?php if($note->status === 'paid'): ?>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Lunas</span>
                    <?php elseif($note->status === 'partial'): ?>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Sebagian</span>
                    <?php else: ?>
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Belum Lunas</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <?php if($note->status !== 'paid'): ?>
                            <button onclick="showPayModal(<?php echo e($note->id); ?>, '<?php echo e($note->note_number); ?>', <?php echo e($note->remaining_amount); ?>)"
                                class="text-green-600 hover:text-green-800 text-sm">
                                <i class="fas fa-money-bill-wave"></i> Bayar
                            </button>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.distributor-notes.edit', $note)); ?>" class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('admin.distributor-notes.destroy', $note)); ?>" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus nota ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada nota distributor</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="p-4 border-t">
        <?php echo e($notes->links()); ?>

    </div>
</div>

<!-- Pay Modal -->
<div id="pay-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Pembayaran Nota <span id="pay-note-number"></span></h3>
        <form id="pay-form" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Sisa Tagihan</label>
                <p class="text-lg font-bold text-red-600">Rp <span id="pay-remaining"></span></p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Jumlah Pembayaran</label>
                <input type="number" name="amount" id="pay-amount" required min="0" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="hidePayModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Bayar</button>
            </div>
        </form>
    </div>
</div>

<script>
function showPayModal(id, noteNumber, remaining) {
    document.getElementById('pay-note-number').textContent = noteNumber;
    document.getElementById('pay-remaining').textContent = remaining.toLocaleString('id-ID');
    document.getElementById('pay-amount').max = remaining;
    document.getElementById('pay-form').action = '/admin/distributor-notes/' + id + '/pay';
    document.getElementById('pay-modal').classList.remove('hidden');
    document.getElementById('pay-modal').classList.add('flex');
}

function hidePayModal() {
    document.getElementById('pay-modal').classList.add('hidden');
    document.getElementById('pay-modal').classList.remove('flex');
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/distributor-notes/index.blade.php ENDPATH**/ ?>