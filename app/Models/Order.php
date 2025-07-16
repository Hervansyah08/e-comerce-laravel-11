<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'order_code',
        'user_id',
        'total_price',
        'status',
        'rating',
        'ulasan',
        'alamat_pengiriman',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'snap_token',
        'resi_code',
        'ongkir_id'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function ongkir()
    {
        return $this->belongsTo(Ongkir::class);
    }
    public function status(): Attribute
    {
        $descriptions = [
            'pending' => 'Menunggu pembayaran',
            'dibayar' => 'Sudah melakukan pembayaran',
            'sedang diproses' => 'Pesanan sedang diproses',
            'dikirim' => 'Pesanan sedang dikirim',
            'terkirim' => 'Pesanan diterima',
            'dibatalkan' => 'Pesanan dibatalkan',
        ];

        return Attribute::make(
            get: fn($value) => $descriptions[$value] ?? ucfirst($value), // Berikan deskripsi atau fallback ke kapitalisasi
        );
    }
}
