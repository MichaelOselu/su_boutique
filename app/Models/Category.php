<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    /**
     * Type casting for safety
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * A category has many products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
