<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('categories')->where('name', 'Ban')->update(['name' => 'Ban Luar']);

        DB::table('categories')->insert([
            'name' => 'Ban Dalam',
            'type' => 'product',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('categories')->where('name', 'Ban Dalam')->delete();
        DB::table('categories')->where('name', 'Ban Luar')->update(['name' => 'Ban']);
    }
};
