<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class BookController extends Controller
{
    /**
     * Display a listing of published books
     */
    public function index()
    {
        $books = Book::with(['user', 'categories'])
            ->where('status', 'published')  
            ->latest()
            ->paginate(12);
        
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book
     */
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:books,isbn',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:50',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        DB::beginTransaction();
        
        try {
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
            
            DB::commit();

            return redirect()
                ->route('books.show', $book)
                ->with('success', 'Book added successfully!');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            if (isset($imagePath) && $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to add book. Please try again.']);
        }
    }

    /**
     * Display the specified book
     */
    public function show(Book $book)
    {
        $book->load(['user', 'categories']);
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book
     */
    public function edit(Book $book)
    {
        if (Auth::id() !== $book->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, Book $book)
    {
        if (Auth::id() !== $book->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:books,isbn,' . $book->id,
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:50',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        DB::beginTransaction();
        
        try {
            $oldImage = $book->cover_image;
            
            if ($request->hasFile('cover_image')) {
                $validated['cover_image'] = $request->file('cover_image')
                    ->store('books', 'public');
            }

            $book->update($validated);
            $book->categories()->sync($validated['categories']);
            
            if ($request->hasFile('cover_image') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            
            DB::commit();

            return redirect()
                ->route('books.show', $book)
                ->with('success', 'Book updated successfully!');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            if (isset($validated['cover_image'])) {
                Storage::disk('public')->delete($validated['cover_image']);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update book. Please try again.']);
        }
    }

    /**
     * Remove the specified book
     */
    public function destroy(Book $book)
    {
        if (Auth::id() !== $book->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $book->delete();

            return redirect()
                ->route('books.index')
                ->with('success', 'Book deleted successfully!');
                
        } catch (Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to delete book. Please try again.']);
        }
    }
}