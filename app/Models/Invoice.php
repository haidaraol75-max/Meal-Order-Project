<?php

namespace App\Models;
use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Invoice extends Model
{
      use HasFactory;
      protected $fillable = [
        'quantity',
        'amount',
        'payment_time',
        'order_id',
        'table_id',
    ];
   
    public function restaurantTable(): BelongsTo
    {
        return $this->belongsTo(RestaurantTable::class,'table_id')->withDefault([
        'table_number' => 'Takeaway' 
        ]);
    }

    public function order(): BelongsTo
    {
      return $this->belongsTo(Order::class, 'order_id');
    }
}

