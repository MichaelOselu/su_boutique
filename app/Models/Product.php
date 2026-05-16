<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock_quantity',
        'image',
        'is_active',

        'sale_price',
        'is_flash_sale',
        'sale_ends_at',
    ];

    /**
     * Type casting for safe data handling
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Product belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function hasDiscount()
{
    return $this->sale_price &&
           $this->sale_price < $this->price;
}

public function discountPercentage()
{
    if (!$this->hasDiscount()) {
        return 0;
    }

    return round(
        (($this->price - $this->sale_price) / $this->price) * 100
    );
}

public function finalPrice()
{
    return $this->hasDiscount()
        ? $this->sale_price
        : $this->price;
}
}
