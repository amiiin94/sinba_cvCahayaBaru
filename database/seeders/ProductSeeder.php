<?php

namespace Database\Seeders;

use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = collect([
            [
                'name' => 'TA',
                'slug' => 'ta',
                'code' => 001,
                'quantity' => 100,
                'buying_price' => 15000,
                'selling_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 0,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1, // TA
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/ip14.png'
            ],
            [
                'name' => 'TA Potong',
                'slug' => 'ta-potong',
                'code' => 002,
                'quantity' => 100,
                'buying_price' => 15000,
                'selling_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 0,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1, // TA POTONG
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/ip14.png'
            ],
            [
                'name' => 'TRED',
                'slug' => 'tred',
                'code' => 003,
                'quantity' => 100,
                'buying_price' => 15000,
                'selling_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 0,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1, // TRED
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/keyboard.jpg'
            ],
            [
                'name' => 'Benang',
                'slug' => 'benang',
                'code' => 003,
                'quantity' => 100,
                'buying_price' => 15000,
                'selling_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 0,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1, // TRED
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/keyboard.jpg'
            ],
            [
                'name' => 'Klotokan',
                'slug' => 'klotokan',
                'code' => 003,
                'quantity' => 100,
                'buying_price' => 15000,
                'selling_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 0,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1, // TRED
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/keyboard.jpg'
            ],
            [
                'name' => 'Kawat',
                'slug' => 'kawat',
                'code' => 003,
                'quantity' => 100,
                'buying_price' => 15000,
                'selling_price' => 20000,
                'quantity_alert' => 10,
                'tax' => 0,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1, // TRED
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/keyboard.jpg'
            ],
        ]);

        $products->each(function ($product){
            Product::create($product);
        });
    }
}
