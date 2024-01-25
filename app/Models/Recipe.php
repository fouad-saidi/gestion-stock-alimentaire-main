<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_recipe'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
