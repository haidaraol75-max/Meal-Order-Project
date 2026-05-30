<?php

namespace App\Models;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{
    
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
