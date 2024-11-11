<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // [
            //     'id'    => 1,
            //     'name'  => 'TA',
            //     'slug'  => 'TA',
            //     'user_id' => 1,
            // ],
            // [
            //     'id'    => 2,
            //     'name'  => 'TA POTONG',
            //     'slug'  => 'TA-POTONG',
            //     'user_id' => 1,
            // ],
            // [
            //     'id'    => 3,
            //     'name'  => 'TRED',
            //     'slug'  => 'TRED',
            //     'user_id' => 1,
            // ],
            // [
            //     'id'    => 4,
            //     'name'  => 'BENANG',
            //     'slug'  => 'BENANG',
            //     'user_id' => 1,
            // ],
            // [
            //     'id'    => 5,
            //     'name'  => 'KELOTOKAN',
            //     'slug'  => 'KELOTOKAN',
            //     'user_id' => 1,
            // ],
            // [
            //     'id'    => 6,
            //     'name'  => 'KAWAT',
            //     'slug'  => 'KAWAT',
            //     'user_id' => 1,
            // ]

            [
                'id'    => 1,
                'name'  => 'Produk Mentah',
                'slug'  => 'produk-mentah',
                'user_id' => 1,
            ],
            [
                'id'    => 2,
                'name'  => 'Produk Jadi',
                'slug'  => 'produk-jadi',
                'user_id' => 1,
            ],
        ];

        // Menggunakan batch insert
        Category::insert($categories);
    }
}
