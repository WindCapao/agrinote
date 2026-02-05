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
        $books = Book::published()
            ->with(['user', 'categories'])
            ->latest()
            ->paginate(10);
        
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get(); // CHANGED: Added orderBy
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 5),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ];

        // Status validation depends on user role
        if (Auth::user()->isAdmin()) {
            $rules['status'] = 'required|in:draft,pending,published,rejected';
        } else {
            $rules['status'] = 'required|in:draft,pending';
        }

        $validated = $request->validate($rules);

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

            $message = $validated['status'] === 'pending' 
                ? 'Book submitted for approval!' 
                : 'Book created successfully!';

            // FIXED: Redirect based on user role
            if (Auth::user()->isAdmin()) {
                return redirect()
                    ->route('admin.books.show', $book)  // Admin route
                    ->with('success', $message);
            } else {
                return redirect()
                    ->route('books.show', $book)  // Regular user route
                    ->with('success', $message);
            }
                
        } catch (Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded image if book creation failed
            if (isset($imagePath) && $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create book. Please try again.']);
        }
    }

    /**
     * Display the specified book
     */
    public function show(Book $book)
    {
        // Allow viewing if: published, or owner, or admin
        if ($book->status !== 'published' 
            && Auth::id() !== $book->user_id 
            && !Auth::user()?->isAdmin()) {
            abort(403, 'This book is not available.');
        }

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

        $categories = Category::orderBy('name')->get(); // CHANGED: Added orderBy
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

        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 5),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ];

        // Status validation depends on user role
        if (Auth::user()->isAdmin()) {
            $rules['status'] = 'required|in:draft,pending,published,rejected';
        } else {
            $rules['status'] = 'required|in:draft,pending';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        
        try {
            $oldImage = $book->cover_image;
            
            if ($request->hasFile('cover_image')) {
                $validated['cover_image'] = $request->file('cover_image')
                    ->store('books', 'public');
            }

            $book->update($validated);
            $book->categories()->sync($validated['categories']);
            
            // Delete old image only after successful update
            if ($request->hasFile('cover_image') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            
            DB::commit();

            $message = $validated['status'] === 'pending' 
                ? 'Book submitted for approval!' 
                : 'Book updated successfully!';

            // FIXED: Redirect based on user role
            if (Auth::user()->isAdmin()) {
                return redirect()
                    ->route('admin.books.show', $book)  // Admin route
                    ->with('success', $message);
            } else {
                return redirect()
                    ->route('books.show', $book)  // Regular user route
                    ->with('success', $message);
            }
                
        } catch (Exception $e) {
            DB::rollBack();
            
            // Clean up new image if update failed
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