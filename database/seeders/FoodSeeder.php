<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            ['name' => 'Nasi Goreng', 'category' => 'Makanan', 'price' => 20000, 'description' => 'Nasi goreng spesial', 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mie Tek Tek', 'category' => 'Makanan', 'price' => 15000, 'description' => 'Mie kuah hangat', 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Es Teh Manis', 'category' => 'Minuman', 'price' => 5000, 'description' => 'Teh manis dingin', 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kopi Hitam', 'category' => 'Minuman', 'price' => 10000, 'description' => 'Kopi asli', 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kentang Goreng', 'category' => 'Cemilan', 'price' => 12000, 'description' => 'Kentang renyah', 'image' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}