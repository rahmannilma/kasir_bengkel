<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mechanic_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mechanic_id')->constrained()->onDelete('cascade');
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->decimal('service_amount', 12, 2);
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->decimal('commission_amount', 12, 2);
            $table->date('period_start');
            $table->date('period_end');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mechanic_salaries');
    }
};
