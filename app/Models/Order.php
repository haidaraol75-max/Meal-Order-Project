<?php

namespace App\Models;
use App\Models\Invoice;
use App\Models\RestaurantTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Order extends Model
{
      use HasFactory;
  
    public function restaurantTable(): BelongsTo
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id'); 
    }

    public function invoice(): HasOne
    {
       return $this->hasOne(Invoice::class, 'order_id');
    }

     public function menuItems(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'order_items', 'order_id', 'menu_item_id')
                    ->withPivot('quantity', 'price'); 
    }
}
