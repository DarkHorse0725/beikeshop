<?php

namespace Beike\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Base
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['images', 'video', 'position', 'brand_id', 'tax_class_id', 'active', 'variables'];
    protected $casts = [
        'active' => 'boolean',
        'variables' => 'array',
        'images' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, ProductCategory::class)->withTimestamps();
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function description()
    {
        return $this->hasOne(ProductDescription::class)->where('locale', locale());
    }

    public function descriptions()
    {
        return $this->hasMany(ProductDescription::class);
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function master_sku()
    {
        return $this->hasOne(ProductSku::Class)->where('is_default', 1);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::Class, 'brand_id', 'id');
    }

    public function inCurrentWishlist()
    {
        return $this->hasOne(CustomerWishlist::class)->where('customer_id', current_customer() ? current_customer()->id : 0);
    }

    public function getPriceFormattedAttribute(): string
    {
        return '$' . $this->price;
    }

    public function getUrlAttribute()
    {
        return shop_route('products.show', ['product' => $this]);
    }
}
