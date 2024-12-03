<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'berat',
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
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format($value, 0, ',', '.'), // berfungsi ketika di panggil dengan model
            set: fn($value) => str_replace('.', '', $value) // berfungsi ketika disimpan di database
        );
    }
    public function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucwords(strtolower($value)), // Ubah seluruh kalimat menjadi huruf kecil dan kapital pada setiap kata
        );
    }
}
