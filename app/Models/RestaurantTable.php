<?php

namespace App\Models;
use App\Models\Order;
use App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RestaurantTable extends Model
{
    
     public function orders(): HasMany
     {
        return $this->hasMany(Order::class, 'table_id'); 
     }

     public function invoices(): HasMany
     {
        return $this->hasMany(Invoice::class,'table_id');
     }
}
