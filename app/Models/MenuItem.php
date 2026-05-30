<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
      use HasFactory;
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class); 
    }
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items', 'menu_item_id', 'order_id')
                    ->withPivot('quantity', 'price'); 
    }
}
