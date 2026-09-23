<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('loans')->insert([
            [
                'user_id' => 1,
                'book_id' => 1,
                'loan_date' => '2026-09-01',
                'return_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'book_id' => 3,
                'loan_date' => '2026-09-05',
                'return_date' => '2026-09-12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'book_id' => 2,
                'loan_date' => '2026-09-08',
                'return_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'book_id' => 4,
                'loan_date' => '2026-09-10',
                'return_date' => '2026-09-17',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}