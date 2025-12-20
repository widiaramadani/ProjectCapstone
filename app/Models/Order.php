<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'nama',
    'telepon',
    'kota',
    'kecamatan',
    'alamat',
    'ongkir',
    'total'
];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}