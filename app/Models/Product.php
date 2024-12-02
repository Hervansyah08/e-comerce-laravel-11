<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        // 'berat',
        'is_active',
    ];

    // tipe data ini akan di konversi ketika kita mengakses data dengan model
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'stock' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
