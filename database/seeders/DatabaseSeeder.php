<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Create kasir user
        User::create([
            'name' => 'Kasir Bengkel',
            'email' => 'kasir@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'phone' => '081234567891',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Aki', 'type' => 'product'],
            ['name' => 'Ban Luar', 'type' => 'product'],
            ['name' => 'Ban Dalam', 'type' => 'product'],
            ['name' => 'Oli', 'type' => 'product'],
            ['name' => 'Sparepart', 'type' => 'product'],
            ['name' => 'Service Rutin', 'type' => 'service'],
            ['name' => 'Service Mesin', 'type' => 'service'],
            ['name' => 'Service Rem', 'type' => 'service'],
            ['name' => 'Service AC', 'type' => 'service'],
            ['name' => 'Tambal Ban', 'type' => 'service'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create products (spareparts)
        $products = [
            ['code' => 'OLI001', 'name' => 'Oli Motor Shell 4T 10W-40', 'category_id' => 3, 'brand' => 'Shell', 'part_number' => 'SHL-4T-1040', 'purchase_price' => 65000, 'selling_price' => 85000, 'stock' => 50, 'min_stock' => 10, 'is_active' => true],
            ['code' => 'OLI002', 'name' => 'Oli Motor Castrol 4T 15W-50', 'category_id' => 3, 'brand' => 'Castrol', 'part_number' => 'CST-4T-1550', 'purchase_price' => 75000, 'selling_price' => 95000, 'stock' => 45, 'min_stock' => 10, 'is_active' => true],
            ['code' => 'OLI003', 'name' => 'Oli Motor Pertamax 4T 10W-40', 'category_id' => 3, 'brand' => 'Pertamina', 'part_number' => 'Ptx-4T-1040', 'purchase_price' => 55000, 'selling_price' => 72000, 'stock' => 60, 'min_stock' => 15, 'is_active' => true],
            ['code' => 'AKI001', 'name' => 'Aki GS QT5S 12V 5Ah', 'category_id' => 1, 'brand' => 'GS', 'part_number' => 'GS-AKI-005', 'purchase_price' => 180000, 'selling_price' => 250000, 'stock' => 10, 'min_stock' => 2, 'is_active' => true],
            ['code' => 'AKI002', 'name' => 'Aki Yuasa YT7B-BS 12V 6.5Ah', 'category_id' => 1, 'brand' => 'Yuasa', 'part_number' => 'YUA-YT7B', 'purchase_price' => 220000, 'selling_price' => 300000, 'stock' => 8, 'min_stock' => 2, 'is_active' => true],
            ['code' => 'BAN001', 'name' => 'Ban Depan IRC NRX 80/90-17', 'category_id' => 2, 'brand' => 'IRC', 'part_number' => 'IRC-BD-NRX80', 'purchase_price' => 180000, 'selling_price' => 250000, 'stock' => 15, 'min_stock' => 3, 'is_active' => true],
            ['code' => 'BAN002', 'name' => 'Ban Belakang IRC GTR 90/80-17', 'category_id' => 2, 'brand' => 'IRC', 'part_number' => 'IRC-BB-GTR90', 'purchase_price' => 220000, 'selling_price' => 300000, 'stock' => 12, 'min_stock' => 3, 'is_active' => true],
            ['code' => 'FLT001', 'name' => 'Filter Oli Honda Beat', 'category_id' => 4, 'brand' => 'Honda', 'part_number' => 'HDA-FO-001', 'purchase_price' => 15000, 'selling_price' => 25000, 'stock' => 30, 'min_stock' => 5, 'is_active' => true],
            ['code' => 'FLT002', 'name' => 'Filter Oli Yamaha NMAX', 'category_id' => 4, 'brand' => 'Yamaha', 'part_number' => 'YMA-FO-002', 'purchase_price' => 18000, 'selling_price' => 30000, 'stock' => 25, 'min_stock' => 5, 'is_active' => true],
            ['code' => 'FLT003', 'name' => 'Filter Udara Honda Vario', 'category_id' => 4, 'brand' => 'Honda', 'part_number' => 'HDA-FU-003', 'purchase_price' => 25000, 'selling_price' => 40000, 'stock' => 20, 'min_stock' => 5, 'is_active' => true],
            ['code' => 'BRK001', 'name' => 'Kampas Rem Depan Honda Beat', 'category_id' => 4, 'brand' => 'Honda Genuine', 'part_number' => 'HDA-KRD-001', 'purchase_price' => 35000, 'selling_price' => 55000, 'stock' => 15, 'min_stock' => 3, 'is_active' => true],
            ['code' => 'BRK002', 'name' => 'Kampas Rem Belakang Yamaha NMAX', 'category_id' => 4, 'brand' => 'Yamaha Genuine', 'part_number' => 'YMA-KRB-002', 'purchase_price' => 40000, 'selling_price' => 60000, 'stock' => 12, 'min_stock' => 3, 'is_active' => true],
            ['code' => 'BSI001', 'name' => 'Busi NGK CR7E', 'category_id' => 4, 'brand' => 'NGK', 'part_number' => 'NGK-CR7E', 'purchase_price' => 25000, 'selling_price' => 40000, 'stock' => 40, 'min_stock' => 10, 'is_active' => true],
            ['code' => 'BSI002', 'name' => 'Busi Denso U20EPR9', 'category_id' => 4, 'brand' => 'Denso', 'part_number' => 'DNS-U20EPR9', 'purchase_price' => 28000, 'selling_price' => 45000, 'stock' => 35, 'min_stock' => 8, 'is_active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create services
        $services = [
            ['name' => 'Ganti Oli Rutin', 'category_id' => 5, 'price' => 25000, 'estimated_time' => 15, 'description' => 'Penggantian oli mesin motor', 'is_active' => true],
            ['name' => 'Service Ringan', 'category_id' => 5, 'price' => 50000, 'estimated_time' => 30, 'description' => 'Cek oli, filter, kampas rem', 'is_active' => true],
            ['name' => 'Service Besar', 'category_id' => 5, 'price' => 150000, 'estimated_time' => 120, 'description' => 'Service full overhaul mesin', 'is_active' => true],
            ['name' => 'Tune Up', 'category_id' => 6, 'price' => 75000, 'estimated_time' => 45, 'description' => 'Penyetelan karburator, busi, klep', 'is_active' => true],
            ['name' => 'Overhaul Mesin', 'category_id' => 6, 'price' => 500000, 'estimated_time' => 360, 'description' => 'Pembongkaran dan perbaikan mesin total', 'is_active' => true],
            ['name' => 'Pengecekan CDI', 'category_id' => 6, 'price' => 35000, 'estimated_time' => 20, 'description' => 'Pengujian dan penyetelan CDI', 'is_active' => true],
            ['name' => 'Service Rem Depan', 'category_id' => 7, 'price' => 40000, 'estimated_time' => 30, 'description' => 'Penggantian kampas dan penyetelan rem', 'is_active' => true],
            ['name' => 'Service Rem Belakang', 'category_id' => 7, 'price' => 35000, 'estimated_time' => 25, 'description' => 'Penggantian kampas dan penyetelan rem', 'is_active' => true],
            ['name' => 'Flush AC', 'category_id' => 8, 'price' => 100000, 'estimated_time' => 60, 'description' => 'Pencucian sistem AC motor', 'is_active' => true],
            ['name' => 'Isi Ulang Freon AC', 'category_id' => 8, 'price' => 75000, 'estimated_time' => 20, 'description' => 'Pengisian freon AC', 'is_active' => true],
            ['name' => 'Tambal Ban Tubeless', 'category_id' => 9, 'price' => 25000, 'estimated_time' => 15, 'description' => 'Penambalan ban tubeless', 'is_active' => true],
            ['name' => 'Tambal Ban Tube', 'category_id' => 9, 'price' => 20000, 'estimated_time' => 20, 'description' => 'Penambalan ban dalam', 'is_active' => true],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create sample customers
        $customers = [
            ['name' => 'Budi Santoso', 'phone' => '081234567001', 'vehicle_plate' => 'B 1234 ABC', 'vehicle_brand' => 'Honda Beat', 'vehicle_type' => 'Beat CBS'],
            ['name' => 'Ahmad Wijaya', 'phone' => '081234567002', 'vehicle_plate' => 'B 5678 DEF', 'vehicle_brand' => 'Yamaha NMAX', 'vehicle_type' => 'NMAX Connected'],
            ['name' => 'Dewi Lestari', 'phone' => '081234567003', 'vehicle_plate' => 'D 9012 GHI', 'vehicle_brand' => 'Honda Vario', 'vehicle_type' => 'Vario 125 CBS'],
            ['name' => 'Rudi Hermawan', 'phone' => '081234567004', 'vehicle_plate' => 'F 3456 JKL', 'vehicle_brand' => 'Suzuki Satria', 'vehicle_type' => 'Satria FU 150'],
            ['name' => 'Siti Nurhaliza', 'phone' => '081234567005', 'vehicle_plate' => 'E 7890 MNO', 'vehicle_brand' => 'Yamaha Aerox', 'vehicle_type' => 'Aerox NVX'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
