<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('order_type', ['dine_in', 'takeaway'])->default('takeaway');
            $table->enum('order_status', ['Preparing', 'Ready', 'Delivered'])->default('Preparing');
            $table->date('order_date')->nullable();
            $table->time('order_time')->nullable(); 
            $table->decimal('total_amount', 10, 2)->default(0.00);
           $table->foreignId('table_id')->nullable()->constrained('restaurant_tables')->onDelete('set null')->after('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};


