<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class OrderItem extends Model
{
      use HasFactory;
    public $timestamps = false; 

   
    protected $guarded = [];
     
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class); 
    }

    
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class); 
    }
}
