

<?php $__env->startSection('title', 'Dashboard - Bengkel POS'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <p class="text-gray-500">Selamat datang di sistem kasir bengkel</p>
</div>

<!-- Profit & Loss Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
                <p class="text-2xl font-bold text-green-600">Rp <?php echo e(number_format($todayProfit['revenue'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Kotor Hari Ini</p>
                <p class="text-2xl font-bold text-teal-600">Rp <?php echo e(number_format($todayProfit['gross_profit'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-teal-100 rounded-full p-3">
                <i class="fas fa-chart-line text-teal-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Biaya Gaji Mech.</p>
                <p class="text-2xl font-bold text-orange-600">Rp <?php echo e(number_format($todayProfit['salary_cost'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-orange-100 rounded-full p-3">
                <i class="fas fa-users text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Bersih Hari Ini</p>
                <p class="text-2xl font-bold <?php if(($todayProfit['net_profit'] ?? 0) >= 0): ?> text-green-600 <?php else: ?> text-red-600 <?php endif; ?>">Rp <?php echo e(number_format($todayProfit['net_profit'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="rounded-full p-3 <?php if(($todayProfit['net_profit'] ?? 0) >= 0): ?> bg-green-100 <?php else: ?> bg-red-100 <?php endif; ?>">
                <i class="fas fa-wallet text-xl <?php if(($todayProfit['net_profit'] ?? 0) >= 0): ?> text-green-600 <?php else: ?> text-red-600 <?php endif; ?>"></i>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Profit & Loss -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold text-green-600">Rp <?php echo e(number_format($monthlyProfit['revenue'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-arrow-up text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Kotor Bulan Ini</p>
                <p class="text-2xl font-bold text-teal-600">Rp <?php echo e(number_format($monthlyProfit['gross_profit'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-teal-100 rounded-full p-3">
                <i class="fas fa-chart-line text-teal-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Biaya Gaji Mech. Bulan Ini</p>
                <p class="text-2xl font-bold text-orange-600">Rp <?php echo e(number_format($monthlyProfit['salary_cost'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-orange-100 rounded-full p-3">
                <i class="fas fa-users text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Laba Bersih Bulan Ini</p>
                <p class="text-2xl font-bold <?php if(($monthlyProfit['net_profit'] ?? 0) >= 0): ?> text-green-600 <?php else: ?> text-red-600 <?php endif; ?>">Rp <?php echo e(number_format($monthlyProfit['net_profit'] ?? 0, 0, ',', '.')); ?></p>
            </div>
            <div class="rounded-full p-3 <?php if(($monthlyProfit['net_profit'] ?? 0) >= 0): ?> bg-green-100 <?php else: ?> bg-red-100 <?php endif; ?>">
                <i class="fas fa-wallet text-xl <?php if(($monthlyProfit['net_profit'] ?? 0) >= 0): ?> text-green-600 <?php else: ?> text-red-600 <?php endif; ?>"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
                <p class="text-2xl font-bold text-green-600">Rp <?php echo e(number_format($todaySales, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-money-bill text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                <p class="text-2xl font-bold text-blue-600"><?php echo e($todayTransactions); ?></p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-receipt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Penjualan Bulan Ini</p>
                <p class="text-2xl font-bold text-purple-600">Rp <?php echo e(number_format($monthlySales, 0, ',', '.')); ?></p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class="fas fa-calendar text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Stok Menipis</p>
                <p class="text-2xl font-bold text-red-600"><?php echo e($lowStockProducts); ?></p>
            </div>
            <div class="bg-red-100 rounded-full p-3">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <a href="<?php echo e(route('admin.products.index')); ?>" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="bg-orange-100 rounded-full p-3">
                <i class="fas fa-box text-orange-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold"><?php echo e($totalProducts); ?></p>
                <p class="text-sm text-gray-500">Sparepart</p>
            </div>
        </div>
    </a>
    
    <a href="<?php echo e(route('admin.services.index')); ?>" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="bg-teal-100 rounded-full p-3">
                <i class="fas fa-tools text-teal-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold"><?php echo e($totalServices); ?></p>
                <p class="text-sm text-gray-500">Jasa Service</p>
            </div>
        </div>
    </a>
    
    <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
        <div class="flex items-center gap-4">
            <div class="bg-pink-100 rounded-full p-3">
                <i class="fas fa-user-cog text-pink-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold"><?php echo e($totalUsers); ?></p>
                <p class="text-sm text-gray-500">User</p>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="font-bold">Transaksi Terbaru</h2>
            <a href="<?php echo e(route('admin.transactions.index')); ?>" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        <div class="p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="pb-2">Invoice</th>
                        <th class="pb-2">Pelanggan</th>
                        <th class="pb-2">Total</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t">
                        <td class="py-2">
                            <a href="<?php echo e(route('admin.transactions.show', $transaction)); ?>" class="text-blue-600 hover:underline">
                                <?php echo e($transaction->invoice_number); ?>

                            </a>
                        </td>
                        <td class="py-2"><?php echo e($transaction->customer->name ?? '-'); ?></td>
                        <td class="py-2">Rp <?php echo e(number_format($transaction->total, 0, ',', '.')); ?></td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded text-xs <?php echo e($transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e(ucfirst($transaction->status)); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-400">Belum ada transaksi</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="font-bold">Produk Terlaris</h2>
            <a href="<?php echo e(route('admin.reports.product-sales')); ?>" class="text-sm text-blue-600 hover:text-blue-800">Lihat Laporan</a>
        </div>
        <div class="p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="pb-2">Produk</th>
                        <th class="pb-2 text-right">Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t">
                        <td class="py-2"><?php echo e($product->name); ?></td>
                        <td class="py-2 text-right"><?php echo e($product->total_sold ?? 0); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="2" class="py-4 text-center text-gray-400">Belum ada data</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\kasir_bengkel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>