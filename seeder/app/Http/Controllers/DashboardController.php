<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Throwable;

class DashboardController extends Controller
{
    public function index()
    {
        $books = collect();
        $categories = collect();
        $loans = collect();
        $stats = [
            'books' => 0,
            'categories' => 0,
            'active_loans' => 0,
            'users' => 0,
        ];

        try {
            $books = DB::table('books')
                ->join('categories', 'books.category_id', '=', 'categories.id')
                ->select('books.*', 'categories.name as category')
                ->orderByDesc('books.created_at')
                ->get();

            $categories = DB::table('categories')
                ->orderBy('name')
                ->get();

            $loans = DB::table('loans')
                ->join('books', 'loans.book_id', '=', 'books.id')
                ->join('users', 'loans.user_id', '=', 'users.id')
                ->select('loans.*', 'books.title', 'users.name as user_name')
                ->orderByDesc('loans.loan_date')
                ->limit(5)
                ->get();

            $stats = [
                'books' => DB::table('books')->count(),
                'categories' => DB::table('categories')->count(),
                'active_loans' => DB::table('loans')->whereNull('return_date')->count(),
                'users' => DB::table('users')->count(),
            ];
        } catch (Throwable $e) {
            // The visual dashboard can still be displayed before the database is migrated.
            $books = collect([
                (object) ['id' => 1, 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'publication_year' => 2008, 'category' => 'Tecnologia'],
                (object) ['id' => 2, 'title' => 'O Programador Pragmático', 'author' => 'Andrew Hunt e David Thomas', 'publication_year' => 1999, 'category' => 'Tecnologia'],
                (object) ['id' => 3, 'title' => 'Dom Casmurro', 'author' => 'Machado de Assis', 'publication_year' => 1899, 'category' => 'Literatura'],
                (object) ['id' => 4, 'title' => 'O Cortiço', 'author' => 'Aluísio Azevedo', 'publication_year' => 1890, 'category' => 'Literatura'],
                (object) ['id' => 5, 'title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'publication_year' => 2011, 'category' => 'História'],
                (object) ['id' => 6, 'title' => 'Uma Breve História do Tempo', 'author' => 'Stephen Hawking', 'publication_year' => 1988, 'category' => 'Ciência'],
            ]);
            $categories = collect([
                (object) ['name' => 'Tecnologia'], (object) ['name' => 'Literatura'],
                (object) ['name' => 'História'], (object) ['name' => 'Ciência'],
            ]);
            $stats = ['books' => 6, 'categories' => 4, 'active_loans' => 2, 'users' => 3];
        }

        return view('welcome', compact('books', 'categories', 'loans', 'stats'));
    }
}
