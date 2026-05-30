<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class InvoiceSeeder extends Seeder
{
    
    public function run(): void
    {
        
    $orders = Order::doesntHave('invoice')->get();

    foreach ($orders as $order) {
        Invoice::factory()->create([
            'order_id' => $order->id,
            'table_id' => $order->table_id,
        ]);
    }
    }
}
