<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = collect([

            [
                'name' => 'Kilogram',
                'slug' => 'kilogram',
                'short_code' => 'kg',
                'user_id'=>1
            ],

        ]);

        $units->each(function ($unit){
            Unit::insert($unit);
        });
    }
}
