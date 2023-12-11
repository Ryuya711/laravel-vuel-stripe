<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'エクスプロージョンプロテイン',
                'description' => '格安プロテインです。',
                'image' => '/images/1.jpg',
                'price' =>'4999'
            ],
            [
                'name' => 'ザバスプロテイン',
                'description' => '値段普通目なプロテインです。',
                'image' => '/images/2.jpg',
                'price' =>'7000'
            ],
        ]);
    }
}
