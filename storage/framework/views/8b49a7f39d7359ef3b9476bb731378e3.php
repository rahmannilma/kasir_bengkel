<?php $__env->startSection('title', 'Export Laporan Penjualan - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<style>
    @media print {
        .no-print { display: none !important; }
        body { -webkit-print-color-adjust: exact; }
    }
</style>

<div class="mb-6 no-print">
    <h1 class="text-2xl font-bold">Export Laporan Penjualan</h1>
    <p class="text-gray-500">Periode: <?php echo e($dateFrom); ?> s/d <?php echo e($dateTo); ?></p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-4">
        <button onclick="window.print()" class="no-print bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-print mr-2"></i> Print
        </button>
        <a href="<?php echo e(route('admin.reports.sales', ['date_from' => $dateFrom, 'date_to' => $dateTo])); ?>" class="no-print ml-2 text-blue-600 hover:underline">
            Kembali
        </a>
    </div>

    <div class="text-center mb-6 border-b pb-4">
        <h2 class="text-xl font-bold">LAPORAN PENJUALAN</h2>
        <p class="text-gray-600">Periode: <?php echo e(\Carbon\Carbon::parse($dateFrom)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($dateTo)->format('d/m/Y')); ?></p>
    </div>

    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2 text-left text-sm font-medium">No</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Invoice</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Tanggal</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Pelanggan</th>
                <th class="px-3 py-2 text-left text-sm font-medium">Kasir</th>
                <th class="px-3 py-2 text-right text-sm font-medium">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $no = 1; $grandTotal = 0; ?>
            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="px-3 py-2 text-sm"><?php echo e($no++); ?></td>
                <td class="px-3 py-2 text-sm font-mono"><?php echo e($t->invoice_number); ?></td>
                <td class="px-3 py-2 text-sm"><?php echo e($t->created_at->format('d/m/Y H:i')); ?></td>
                <td class="px-3 py-2 text-sm"><?php echo e($t->customer->name ?? '-'); ?></td>
                <td class="px-3 py-2 text-sm"><?php echo e($t->user->name); ?></td>
                <td class="px-3 py-2 text-right text-sm">Rp <?php echo e(number_format($t->total, 0, ',', '.')); ?></td>
            </tr>
            <?php $grandTotal += $t->total; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="px-3 py-4 text-center text-gray-400">Tidak ada transaksi</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <?php if($transactions->count() > 0): ?>
        <tfoot class="bg-gray-50 font-bold">
            <tr>
                <td colspan="5" class="px-3 py-3 text-right">GRAND TOTAL</td>
                <td class="px-3 py-3 text-right">Rp <?php echo e(number_format($grandTotal, 0, ',', '.')); ?></td>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>

    <div class="mt-6 text-sm text-gray-500">
        <p>Dicetak pada: <?php echo e(now()->format('d/m/Y H:i:s')); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/reports/sales-export.blade.php ENDPATH**/ ?>