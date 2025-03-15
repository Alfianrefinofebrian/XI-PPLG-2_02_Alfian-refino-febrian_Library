<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::with(['user', 'category', 'reviews'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        return response()->json($book->load(['user', 'category', 'reviews']));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'string|max:255',
            'writer' => 'string|max:255',
            'publisher' => 'string|max:255',
            'year' => 'integer|min:1900|max:' . date('Y'),
        ]);

        $book->update($request->all());

        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }
}