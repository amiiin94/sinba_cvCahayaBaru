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
                'slug' => 'ta-product-0',
                'code' => 001,
                'quantity' => 10,
                'buying_price' => 900,
                'selling_price' => 1400,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 1, // TA
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/ip14.png'
            ],
            [
                'slug' => 'ta-potong-product-002',
                'code' => 002,
                'quantity' => 10,
                'buying_price' => 900,
                'selling_price' => 1400,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 2, // TA POTONG
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/ip14.png'
            ],
            [
                'slug' => 'tred-product-003',
                'code' => 003,
                'quantity' => 10,
                'buying_price' => 900,
                'selling_price' => 1400,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 3, // TRED
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/keyboard.jpg'
            ],
            [
                'slug' => 'benang-product-004',
                'code' => 004,
                'quantity' => 10,
                'buying_price' => 900,
                'selling_price' => 1400,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 4, // BENANG
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/speaker.png'
            ],
            [
                'slug' => 'kelotokan-product-005',
                'code' => 005,
                'quantity' => 10,
                'buying_price' => 900,
                'selling_price' => 1400,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 5, // KELOTOKAN
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/autocard.png'
            ],
            [
                'slug' => 'kawat-product-005',
                'code' => 006,
                'quantity' => 10,
                'buying_price' => 900,
                'selling_price' => 1400,
                'quantity_alert' => 10,
                'tax' => 24,
                'tax_type' => 1,
                'notes' => null,
                'category_id' => 6, // KAWAT
                'unit_id' => 1,
                'user_id'=>1,
                'uuid'=>Str::uuid(),
                'product_image' => 'assets/img/products/autocard.png'
            ]
        ]);

        $products->each(function ($product){
            Product::create($product);
        });
    }
}