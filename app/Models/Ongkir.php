<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ongkir extends Model
{
    use HasFactory;

    protected $table = 'ongkirs';
    protected $fillable = [
        'ekspedisi',
        'layanan',
        'biaya',
        'estimasi',
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
