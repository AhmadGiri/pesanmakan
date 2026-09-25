<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan
    protected $table = 'foods';

    // Melindungi kolom id dari mass assignment
    protected $guarded = ['id'];

    // Kolom yang boleh diisi melalui mass assignment
    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'image',
    ];
}