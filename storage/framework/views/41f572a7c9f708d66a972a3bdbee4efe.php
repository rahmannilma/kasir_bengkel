

<?php $__env->startSection('title', 'Struk - Bengkel POS'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
            <i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold"><?php echo e(\App\Models\Setting::get('shop_name', 'BENGKEL MOBIL')); ?></h1>
            <p class="text-sm text-gray-500"><?php echo e(\App\Models\Setting::get('shop_address', 'Jl. Raya Bengkel No. 123')); ?></p>
            <p class="text-sm text-gray-500">Telp: <?php echo e(\App\Models\Setting::get('shop_phone', '0812-3456-7890')); ?></p>
        </div>

        <div class="border-t border-b border-dashed border-gray-300 py-4 mb-4">
            <div class="flex justify-between text-sm mb-2">
                <span>No. Invoice</span>
                <span class="font-mono"><?php echo e($transaction->invoice_number); ?></span>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span>Tanggal</span>
                <span><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></span>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span>Kasir</span>
                <span><?php echo e($transaction->user->name); ?></span>
            </div>
            <?php if($transaction->customer): ?>
            <div class="flex justify-between text-sm">
                <span>Pelanggan</span>
                <span><?php echo e($transaction->customer->name); ?></span>
            </div>
            <?php endif; ?>
            <?php if($transaction->mechanics->count() > 0): ?>
            <div class="flex justify-between text-sm">
                <span>Mekanik</span>
                <span><?php echo e($transaction->mechanics->pluck('name')->join(', ')); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Item</th>
                        <th class="text-center py-2">Qty</th>
                        <th class="text-right py-2">Harga</th>
                        <th class="text-right py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $transaction->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-2">
                            <?php echo e($item->item_name); ?>

                            <span class="text-xs text-gray-400 block"><?php echo e(ucfirst($item->item_type)); ?></span>
                        </td>
                        <td class="text-center py-2"><?php echo e($item->quantity); ?></td>
                        <td class="text-right py-2">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                        <td class="text-right py-2">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="border-t border-dashed border-gray-300 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span>Subtotal</span>
                <span>Rp <?php echo e(number_format($transaction->subtotal, 0, ',', '.')); ?></span>
            </div>
            <?php if($transaction->discount > 0): ?>
            <div class="flex justify-between text-sm text-green-600">
                <span>Diskon</span>
                <span>- Rp <?php echo e(number_format($transaction->discount, 0, ',', '.')); ?></span>
            </div>
            <?php endif; ?>
            <div class="flex justify-between text-lg font-bold">
                <span>TOTAL</span>
                <span>Rp <?php echo e(number_format($transaction->total, 0, ',', '.')); ?></span>
            </div>
        </div>

        <div class="border-t border-dashed border-gray-300 py-4 mt-4">
            <div class="flex justify-between text-sm">
                <span>Metode Bayar</span>
                <span class="uppercase"><?php echo e(str_replace(['cash', 'transfer', 'debit', 'qris'], ['Tunai', 'Transfer', 'Debit', 'QRIS'], $transaction->payment_method)); ?></span>
            </div>
            <?php if($transaction->cash_received): ?>
            <div class="flex justify-between text-sm">
                <span>Jumlah Bayar</span>
                <span>Rp <?php echo e(number_format($transaction->cash_received, 0, ',', '.')); ?></span>
            </div>
            <div class="flex justify-between text-sm text-green-600">
                <span>Kembalian</span>
                <span>Rp <?php echo e(number_format($transaction->change, 0, ',', '.')); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">Terima kasih atas kunjungan Anda!</p>
            <p class="text-xs text-gray-400 mt-2">Barang yang sudah dibeli tidak dapat dikembalikan</p>
        </div>

        <div class="mt-6 flex gap-2">
            <button onclick="window.print()" class="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i> Cetak
            </button>
            <a href="<?php echo e(auth()->user()->role === 'admin' ? route('admin.dashboard') : route('kasir.index')); ?>" 
               class="flex-1 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-center">
                <i class="fas fa-home mr-2"></i> Menu Utama
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .bg-gray-100, .bg-gray-100 * {
        visibility: visible;
    }
    .bg-gray-100 {
        position: absolute;
        left: 0;
        top: 0;
    }
    button, a {
        display: none !important;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/kasir/receipt.blade.php ENDPATH**/ ?>