<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Tecnologia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Literatura',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'História',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ciência',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}