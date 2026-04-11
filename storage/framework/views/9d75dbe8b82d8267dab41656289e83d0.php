<?php $__env->startSection('title', 'Mekanik - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold">Manajemen Mekanik</h1>
        <p class="text-gray-500">Kelola data mekanik dan penggajian</p>
    </div>
    <a href="<?php echo e(route('admin.mechanics.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i> Tambah Mekanik
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Mekanik</p>
        <p class="text-2xl font-bold"><?php echo e($mechanics->total()); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Aktif</p>
        <p class="text-2xl font-bold text-green-600"><?php echo e($mechanics->where('is_active', true)->count()); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Gaji Pending</p>
        <p class="text-2xl font-bold text-yellow-600">Rp <?php echo e(number_format($mechanics->sum('pending_salary'), 0, ',', '.')); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Sudah Dibayar</p>
        <p class="text-2xl font-bold text-blue-600">Rp <?php echo e(number_format($mechanics->sum('total_earnings'), 0, ',', '.')); ?></p>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex gap-4">
        <input type="text" name="search" placeholder="Cari mekanik (nama, telepon, spesialisasi)..." value="<?php echo e(request('search')); ?>"
            class="px-4 py-2 border rounded-lg flex-1">
        <select name="status" onchange="this.form.submit()" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Status</option>
            <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
            <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Nonaktif</option>
        </select>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<!-- Mechanics Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 w-8"></th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Kontak</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Spesialisasi</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Komisi</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Status</th>
                <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">Gaji Pending</th>
                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $mechanics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mechanic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $pendingSalary = $mechanic->salaries->where('status', 'pending')->sum('commission_amount');
                $paidSalary = $mechanic->salaries->where('status', 'paid')->sum('commission_amount');
                $serviceCount = $mechanic->salaries->count();
            ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <button onclick="toggleSalary(<?php echo e($mechanic->id); ?>)" class="text-gray-500 hover:text-gray-700">
                        <i id="toggle-icon-<?php echo e($mechanic->id); ?>" class="fas fa-chevron-right transition-transform"></i>
                    </button>
                </td>
                <td class="px-4 py-3">
                    <p class="font-medium"><?php echo e($mechanic->name); ?></p>
                    <?php if($mechanic->address): ?>
                    <p class="text-xs text-gray-500"><?php echo e(Str::limit($mechanic->address, 40)); ?></p>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-sm">
                    <p><?php echo e($mechanic->phone ?? '-'); ?></p>
                    <p class="text-gray-400 text-xs"><?php echo e($mechanic->email ?? ''); ?></p>
                </td>
                <td class="px-4 py-3 text-center text-sm"><?php echo e($mechanic->specialization ?? '-'); ?></td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-sm"><?php echo e($mechanic->commission_rate ?? 0); ?>%</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <?php if($mechanic->is_active): ?>
                    <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-800">Aktif</span>
                    <?php else: ?>
                    <span class="px-2 py-1 rounded text-sm bg-red-100 text-red-800">Nonaktif</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-right">
                    <?php if($pendingSalary > 0): ?>
                    <span class="text-yellow-600 font-medium">Rp <?php echo e(number_format($pendingSalary, 0, ',', '.')); ?></span>
                    <?php else: ?>
                    <span class="text-green-600">-</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="<?php echo e(route('admin.mechanics.edit', $mechanic)); ?>" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="showCommissionModal(<?php echo e($mechanic->id); ?>, '<?php echo e($mechanic->name); ?>', <?php echo e($mechanic->commission_rate ?? 0); ?>)" 
                            class="text-purple-600 hover:text-purple-800" title="Set Komisi">
                            <i class="fas fa-percent"></i>
                        </button>
                        <?php if($pendingSalary > 0): ?>
                        <button onclick="showPaySalaryModal(<?php echo e($mechanic->id); ?>, '<?php echo e($mechanic->name); ?>', <?php echo e($pendingSalary); ?>)" 
                            class="text-green-600 hover:text-green-800" title="Bayar Gaji">
                            <i class="fas fa-money-bill-wave"></i>
                        </button>
                        <?php endif; ?>
                        <form action="<?php echo e(route('admin.mechanics.destroy', $mechanic)); ?>" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus mekanik ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <!-- Salary Detail Row -->
            <tr id="salary-row-<?php echo e($mechanic->id); ?>" class="hidden bg-gray-50">
                <td colspan="8" class="px-4 py-4">
                    <div class="ml-8">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-medium text-gray-700">Riwayat Gaji & Komisi</h4>
                            <div class="flex gap-2">
                                <div class="text-sm">
                                    <span class="text-gray-500">Total Dibayar:</span>
                                    <span class="font-medium text-green-600">Rp <?php echo e(number_format($paidSalary, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if($mechanic->salaries->count() > 0): ?>
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="pb-2">Periode</th>
                                    <th class="pb-2 text-right">Nilai Jasa</th>
                                    <th class="pb-2 text-right">Komisi (%)</th>
                                    <th class="pb-2 text-right">Jumlah</th>
                                    <th class="pb-2 text-center">Status</th>
                                    <th class="pb-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <?php $__currentLoopData = $mechanic->salaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e($salary->status === 'pending' ? 'bg-yellow-50' : ''); ?>">
                                    <td class="py-2">
                                        <?php echo e($salary->period_start->format('d/m/Y')); ?> - <?php echo e($salary->period_end->format('d/m/Y')); ?>

                                    </td>
                                    <td class="py-2 text-right">Rp <?php echo e(number_format($salary->service_amount, 0, ',', '.')); ?></td>
                                    <td class="py-2 text-right"><?php echo e($salary->commission_rate); ?>%</td>
                                    <td class="py-2 text-right font-medium">Rp <?php echo e(number_format($salary->commission_amount, 0, ',', '.')); ?></td>
                                    <td class="py-2 text-center">
                                        <?php if($salary->status === 'paid'): ?>
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Lunas</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 text-center">
                                        <?php if($salary->status === 'pending'): ?>
                                        <form action="<?php echo e(route('admin.mechanics.salary.paid', $mechanic)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="salary_ids[]" value="<?php echo e($salary->id); ?>">
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-xs">Bayar</button>
                                        </form>
                                        <?php else: ?>
                                        <span class="text-gray-400 text-xs">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <p class="text-gray-400 text-sm">Belum ada riwayat gaji untuk mekanik ini</p>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada data mekanik</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="p-4 border-t">
        <?php echo e($mechanics->links()); ?>

    </div>
</div>

<!-- Commission Modal -->
<div id="commission-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Set Komosi - <span id="comm-mechanic-name"></span></h3>
        <form id="commission-form" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Persentase Komosi (%)</label>
                <input type="number" id="commission-rate" name="commission_rate" min="0" max="100" step="0.01" 
                    class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="hideCommissionModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Pay Salary Modal -->
<div id="pay-salary-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Pembayaran Gaji - <span id="pay-mechanic-name"></span></h3>
        <form id="pay-salary-form" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Total Gaji Pending</label>
                <p class="text-lg font-bold text-yellow-600">Rp <span id="pay-salary-amount"></span></p>
            </div>
            <p class="text-sm text-gray-500 mb-4">Klik "Bayar" untuk menandai semua gaji pending sebagai lunas.</p>
            <div class="flex gap-2">
                <button type="button" onclick="hidePaySalaryModal()" class="flex-1 py-2 border rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Bayar Semua</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSalary(id) {
    const row = document.getElementById('salary-row-' + id);
    const icon = document.getElementById('toggle-icon-' + id);
    row.classList.toggle('hidden');
    icon.classList.toggle('rotate-90');
}

function showCommissionModal(id, name, rate) {
    document.getElementById('comm-mechanic-name').textContent = name;
    document.getElementById('commission-rate').value = rate;
    document.getElementById('commission-form').action = '/admin/mechanics/' + id + '/commission';
    document.getElementById('commission-modal').classList.remove('hidden');
    document.getElementById('commission-modal').classList.add('flex');
}

function hideCommissionModal() {
    document.getElementById('commission-modal').classList.add('hidden');
    document.getElementById('commission-modal').classList.remove('flex');
}

function showPaySalaryModal(id, name, amount) {
    document.getElementById('pay-mechanic-name').textContent = name;
    document.getElementById('pay-salary-amount').textContent = amount.toLocaleString('id-ID');
    document.getElementById('pay-salary-form').action = '/admin/mechanics/' + id + '/salary/paid';
    document.getElementById('pay-salary-modal').classList.remove('hidden');
    document.getElementById('pay-salary-modal').classList.add('flex');
}

function hidePaySalaryModal() {
    document.getElementById('pay-salary-modal').classList.add('hidden');
    document.getElementById('pay-salary-modal').classList.remove('flex');
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/mechanics/index.blade.php ENDPATH**/ ?>