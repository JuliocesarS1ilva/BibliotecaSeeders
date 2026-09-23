<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'category_id' => 1,
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'publication_year' => 2008,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'title' => 'O Programador Pragmático',
                'author' => 'Andrew Hunt e David Thomas',
                'publication_year' => 1999,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'title' => 'Dom Casmurro',
                'author' => 'Machado de Assis',
                'publication_year' => 1899,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'title' => 'O Cortiço',
                'author' => 'Aluísio Azevedo',
                'publication_year' => 1890,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'publication_year' => 2011,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'title' => 'Uma Breve História do Tempo',
                'author' => 'Stephen Hawking',
                'publication_year' => 1988,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}