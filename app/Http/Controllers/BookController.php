<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::published()
            ->with(['user', 'categories'])
            ->latest()
            ->paginate(12);
        
        return view('books.index', compact('books'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:50',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        $imagePath = null;
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('books', 'public');
        }

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'publisher' => $validated['publisher'] ?? null,
            'publication_year' => $validated['publication_year'] ?? null,
            'pages' => $validated['pages'] ?? null,
            'description' => $validated['description'],
            'cover_image' => $imagePath,
            'user_id' => Auth::id(),
            'status' => $validated['status']
        ]);

        $book->categories()->attach($validated['categories']);

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book added successfully!');
    }

    public function show(Book $book)
    {
        $book->load(['user', 'categories']);
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        if (Auth::id() !== $book->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        if (Auth::id() !== $book->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:50',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'status' => 'required|in:draft,published'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($validated);
        $book->categories()->sync($validated['categories']);

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        if (Auth::id() !== $book->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
}