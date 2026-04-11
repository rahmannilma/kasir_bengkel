<?php $__env->startSection('title', 'Distributor - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Manajemen Distributor</h1>
        <p class="text-gray-500">Kelola data distributor dan nota/tagihan</p>
    </div>
    <button onclick="showDistributorModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah Distributor
    </button>
</div>

<!-- Search -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex gap-4">
        <input type="text" name="search" placeholder="Cari distributor, perusahaan..." value="<?php echo e(request('search')); ?>"
            class="px-4 py-2 border rounded-lg flex-1">
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Distributors Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 w-8"></th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Perusahaan</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kontak</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Kategori</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Nota</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Total Tagihan</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $distributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $totalNotes = $distributor->notes->count();
                $unpaidNotes = $distributor->notes->where('status', '!=', 'paid')->count();
                $overdueNotes = $distributor->notes->filter(fn($n) => $n->is_overdue)->count();
                $totalAmount = $distributor->notes->sum('total_amount');
                $paidAmount = $distributor->notes->sum('paid_amount');
                $remainingAmount = $totalAmount - $paidAmount;
            ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <button onclick="toggleNotes(<?php echo e($distributor->id); ?>)" class="text-gray-500 hover:text-gray-700">
                        <i id="toggle-icon-<?php echo e($distributor->id); ?>" class="fas fa-chevron-right transition-transform"></i>
                    </button>
                </td>
                <td class="px-4 py-3 font-medium"><?php echo e($distributor->name); ?></td>
                <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($distributor->company ?? '-'); ?></td>
                <td class="px-4 py-3 text-sm">
                    <p><?php echo e($distributor->phone ?? '-'); ?></p>
                    <p class="text-gray-400"><?php echo e($distributor->email ?? ''); ?></p>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                        <?php echo e($distributor->categories_count); ?>x
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-1">
                        <?php if($totalNotes > 0): ?>
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs" title="Total Nota"><?php echo e($totalNotes); ?></span>
                        <?php endif; ?>
                        <?php if($unpaidNotes > 0): ?>
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs" title="Belum Lunas"><?php echo e($unpaidNotes); ?></span>
                        <?php endif; ?>
                        <?php if($overdueNotes > 0): ?>
                        <span class="px-2 py-1 bg-red-200 text-red-900 rounded text-xs font-bold" title="Jatuh Tempo"><?php echo e($overdueNotes); ?></span>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="px-4 py-3 text-right">
                    <?php if($remainingAmount > 0): ?>
                    <span class="text-red-600 font-medium">Rp <?php echo e(number_format($remainingAmount, 0, ',', '.')); ?></span>
                    <?php else: ?>
                    <span class="text-green-600">Lunas</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editDistributor(<?php echo e($distributor->id); ?>, '<?php echo e($distributor->name); ?>', '<?php echo e($distributor->phone); ?>', '<?php echo e($distributor->email); ?>', '<?php echo e($distributor->address); ?>', '<?php echo e($distributor->company); ?>')"
                            class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="<?php echo e(route('admin.distributors.destroy', $distributor)); ?>" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus distributor ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr id="notes-row-<?php echo e($distributor->id); ?>" class="hidden bg-gray-50">
                <td colspan="8" class="px-4 py-4">
                    <div class="ml-8">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-medium text-gray-700">Riwayat Nota Distributor</h4>
                            <button onclick="showNoteModal(<?php echo e($distributor->id); ?>, '<?php echo e($distributor->name); ?>')" 
                                class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200">
                                <i class="fas fa-plus mr-1"></i> Tambah Nota
                            </button>
                        </div>
                        <?php if($distributor->notes->count() > 0): ?>
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="pb-2">No. Nota</th>
                                    <th class="pb-2">Tanggal</th>
                                    <th class="pb-2">Jatuh Tempo</th>
                                    <th class="pb-2 text-right">Total</th>
                                    <th class="pb-2 text-right">Terbayar</th>
                                    <th class="pb-2 text-right">Sisa</th>
                                    <th class="pb-2 text-center">Status</th>
                                    <th class="pb-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <?php $__currentLoopData = $distributor->notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e($note->is_overdue ? 'bg-red-50' : ''); ?>">
                                    <td class="py-2 font-medium"><?php echo e($note->note_number); ?></td>
                                    <td class="py-2"><?php echo e($note->date->format('d/m/Y')); ?></td>
                                    <td class="py-2 <?php echo e($note->is_overdue ? 'text-red-600 font-bold' : ''); ?>">
                                        <?php echo e($note->due_date->format('d/m/Y')); ?>

                                        <?php if($note->is_overdue): ?>
                                            <span class="text-xs">(Terlambat)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 text-right">Rp <?php echo e(number_format($note->total_amount, 0, ',', '.')); ?></td>
                                    <td class="py-2 text-right text-green-600">Rp <?php echo e(number_format($note->paid_amount, 0, ',', '.')); ?></td>
                                    <td class="py-2 text-right font-medium">Rp <?php echo e(number_format($note->remaining_amount, 0, ',', '.')); ?></td>
                                    <td class="py-2 text-center">
                                        <?php if($note->status === 'paid'): ?>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Lunas</span>
                                        <?php elseif($note->status === 'partial'): ?>
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Sebagian</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Belum</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 text-center">
                                        <div class="flex justify-center gap-2">
                                            <?php if($note->status !== 'paid'): ?>
                                            <button onclick="showPayModal(<?php echo e($note->id); ?>, '<?php echo e($note->note_number); ?>', <?php echo e($note->remaining_amount); ?>)"
                                                class="text-green-600 hover:text-green-800 text-xs">
                                                Bayar
                                            </button>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('admin.distributor-notes.edit', $note)); ?>" class="text-yellow-600 hover:text-yellow-800 text-xs">
                                                Edit
                                            </a>
                                            <form action="<?php echo e(route('admin.distributor-notes.destroy', $note)); ?>" method="POST" class="inline"
                                                onsubmit="return confirm('Hapus nota ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <p class="text-gray-400 text-sm">Belum ada nota untuk distributor ini</p>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada distributor</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="p-4 border-t">
        <?php echo e($distributors->links()); ?>

    </div>
</div>

<!-- Distributor Modal -->
<div id="distributor-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h3 id="modal-title" class="text-lg font-bold mb-4">Tambah Distributor</h3>
        <form id="distributor-form" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="form-method" value="POST">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nama</label>
                    <input type="text" id="dist-name" name="name" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Perusahaan</label>
                    <input type="text" id="dist-company" name="company" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-2">No. Telepon</label>
                    <input type="text" id="dist-phone" name="phone" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" id="dist-email" name="email" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Alamat</label>
                <textarea id="dist-address" name="address" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="button" onclick="hideDistributorModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Note Modal -->
<div id="note-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h3 class="text-lg font-bold mb-4">Tambah Nota - <span id="note-dist-name"></span></h3>
        <form id="note-form" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="note-distributor-id" name="distributor_id" value="">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
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
                    <label class="block text-sm font-medium mb-2">Jatuh Tempo <span class="text-red-500">*</span></label>
                    <input type="date" name="due_date" required class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Total Tagihan <span class="text-red-500">*</span></label>
                <input type="number" name="total_amount" required min="0" step="0.01" class="w-full px-3 py-2 border rounded-lg" placeholder="0">
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Catatan</label>
                <textarea name="notes" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea>
            </div>
            <div class="flex gap-2 mt-6">
                <button type="button" onclick="hideNoteModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
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
function toggleNotes(id) {
    const row = document.getElementById('notes-row-' + id);
    const icon = document.getElementById('toggle-icon-' + id);
    row.classList.toggle('hidden');
    icon.classList.toggle('rotate-90');
}

function showDistributorModal() {
    document.getElementById('modal-title').textContent = 'Tambah Distributor';
    document.getElementById('distributor-form').action = '<?php echo e(route('admin.distributors.store')); ?>';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('dist-name').value = '';
    document.getElementById('dist-company').value = '';
    document.getElementById('dist-phone').value = '';
    document.getElementById('dist-email').value = '';
    document.getElementById('dist-address').value = '';
    document.getElementById('distributor-modal').classList.remove('hidden');
    document.getElementById('distributor-modal').classList.add('flex');
}

function editDistributor(id, name, phone, email, address, company) {
    document.getElementById('modal-title').textContent = 'Edit Distributor';
    document.getElementById('distributor-form').action = '/admin/distributors/' + id;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('dist-name').value = name || '';
    document.getElementById('dist-company').value = company || '';
    document.getElementById('dist-phone').value = phone || '';
    document.getElementById('dist-email').value = email || '';
    document.getElementById('dist-address').value = address || '';

    let methodInput = document.querySelector('#distributor-form input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('distributor-form').appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    document.getElementById('distributor-modal').classList.remove('hidden');
    document.getElementById('distributor-modal').classList.add('flex');
}

function hideDistributorModal() {
    document.getElementById('distributor-modal').classList.add('hidden');
    document.getElementById('distributor-modal').classList.remove('flex');
}

function showNoteModal(distributorId, distributorName) {
    document.getElementById('note-dist-name').textContent = distributorName;
    document.getElementById('note-distributor-id').value = distributorId;
    document.getElementById('note-form').action = '<?php echo e(route('admin.distributor-notes.store')); ?>';
    document.getElementById('note-modal').classList.remove('hidden');
    document.getElementById('note-modal').classList.add('flex');
}

function hideNoteModal() {
    document.getElementById('note-modal').classList.add('hidden');
    document.getElementById('note-modal').classList.remove('flex');
}

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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/distributors/index.blade.php ENDPATH**/ ?>