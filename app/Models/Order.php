<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Mengaktifkan Factory untuk membuat data dummy
    use HasFactory;

    // Melindungi kolom id dari mass assignment
    protected $guarded = ['id'];

    // Relasi: satu Order memiliki banyak OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}