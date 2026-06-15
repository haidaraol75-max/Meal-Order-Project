<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('amount', 10, 2);
            $table->timestamp('payment_time')->nullable(); 
           $table->foreignId('order_id')->unique()->constrained('orders')->cascadeOnDelete();
            $table->foreignId('table_id')->nullable()->constrained('restaurant_tables')->onDelete('set null')->after('amount');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};