<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    // Mengaktifkan Factory untuk membuat data dummy
    use HasFactory;

    // Menentukan tabel yang digunakan
    protected $table = 'order_details';

    // Melindungi kolom id dari mass assignment
    protected $guarded = ['id'];

    // Relasi: satu OrderDetail dimiliki oleh satu Food
    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    // Relasi: satu OrderDetail dimiliki oleh satu Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}