<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Image;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function dashboard()
    {
        // Article statistics
        $articleCount = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        $pendingArticles = Article::where('status', 'pending')->count();
        $rejectedArticles = Article::where('status', 'rejected')->count();
        
        // Book statistics
        $bookCount = Book::count();
        $publishedBooks = Book::where('status', 'published')->count();
        $draftBooks = Book::where('status', 'draft')->count();
        $pendingBooks = Book::where('status', 'pending')->count();
        $rejectedBooks = Book::where('status', 'rejected')->count();
        
        // Image statistics
        $imageCount = Image::count();
        $publishedImages = Image::where('status', 'published')->count();
        $draftImages = Image::where('status', 'draft')->count();
        $pendingImages = Image::where('status', 'pending')->count();
        $rejectedImages = Image::where('status', 'rejected')->count();
        
        // User statistics
        $userCount = User::count();
        
        // Total pending items (for quick access)
        $totalPending = $pendingArticles + $pendingBooks + $pendingImages;

        return view('admin.dashboard', compact(
            'articleCount', 'publishedArticles', 'draftArticles', 'pendingArticles', 'rejectedArticles',
            'bookCount', 'publishedBooks', 'draftBooks', 'pendingBooks', 'rejectedBooks',
            'imageCount', 'publishedImages', 'draftImages', 'pendingImages', 'rejectedImages',
            'userCount', 'totalPending'
        ));
    }
    
    // REMOVED: public function articles() - This is now handled by the content() method
    // REMOVED: public function books() - This is now handled by the content() method
    // REMOVED: public function images() - This is now handled by the content() method

    /**
     * Show form to create new article
     */
    public function createArticle()
    {
        $categories = \App\Models\Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a new article
     */
    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,pending,published,rejected',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        }

        $article = Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'user_id' => auth()->id(),
            'status' => $validated['status']
        ]);

        $article->categories()->attach($validated['categories']);

        // Redirect to content page with articles tab
        return redirect()->route('admin.content.index', ['tab' => 'articles'])
            ->with('success', 'Article created successfully!');
    }

    /**
     * Show article details
     */
    public function showArticle(Article $article)
    {
        $article->load(['user', 'categories']);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show form to edit article
     */
    public function editArticle(Article $article)
    {
        $categories = \App\Models\Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update article
     */
    public function updateArticle(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,pending,published,rejected',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $oldImage = $article->featured_image;
        
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $article->update($validated);
        $article->categories()->sync($validated['categories']);

        // Delete old image if new one uploaded
        if ($request->hasFile('featured_image') && $oldImage) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImage);
        }

        // Redirect to content page with articles tab
        return redirect()->route('admin.content.index', ['tab' => 'articles'])
            ->with('success', 'Article updated successfully!');
    }

    /**
     * Delete article
     */
    public function destroyArticle(Article $article)
    {
        if ($article->featured_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($article->featured_image);
        }

        $articleTitle = $article->title;
        $article->delete();

        // Redirect to content page with articles tab
        return redirect()->route('admin.content.index', ['tab' => 'articles'])
            ->with('success', "Article '$articleTitle' has been deleted!");
    }
    
    /**
     * List all users with their article counts
     */
    public function users()
    {
        $users = User::withCount(['articles', 'books', 'images'])
            ->latest()
            ->paginate(15);
            
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete a user
     */
    public function destroyUser(Request $request, User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User '$userName' has been deleted successfully!");
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        // Load user with all their content
        $user->load(['articles', 'books', 'images']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show form to create new user
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,user',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show form to create new book
     */
    public function createBook()
    {
        $categories = \App\Models\Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a new book
     */
    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 5),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,pending,published,rejected',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
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
            'user_id' => auth()->id(),
            'status' => $validated['status']
        ]);

        $book->categories()->attach($validated['categories']);

        // Redirect to content page with books tab
        return redirect()->route('admin.content.index', ['tab' => 'books'])
            ->with('success', 'Book created successfully!');
    }

    /**
     * Show book details
     */
    public function showBook(Book $book)
    {
        $book->load(['user', 'categories']);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show form to edit book
     */
    public function editBook(Book $book)
    {
        $categories = \App\Models\Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update book
     */
    public function updateBook(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 5),
            'pages' => 'nullable|integer|min:1',
            'description' => 'required|string|min:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,pending,published,rejected',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $oldImage = $book->cover_image;
        
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($validated);
        $book->categories()->sync($validated['categories']);

        if ($request->hasFile('cover_image') && $oldImage) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImage);
        }

        // Redirect to content page with books tab
        return redirect()->route('admin.content.index', ['tab' => 'books'])
            ->with('success', 'Book updated successfully!');
    }

    /**
     * Delete book
     */
    public function destroyBook(Book $book)
    {
        if ($book->cover_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_image);
        }

        $bookTitle = $book->title;
        $book->delete();

        // Redirect to content page with books tab
        return redirect()->route('admin.content.index', ['tab' => 'books'])
            ->with('success', "Book '$bookTitle' has been deleted!");
    }

    /**
     * Show form to create new image
     */
    public function createImage()
    {
        $categories = \App\Models\Category::all();
        return view('admin.images.create', compact('categories'));
    }

    /**
     * Store a new image
     */
    public function storeImage(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'license' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:255',
            'status' => 'required|in:draft,pending,published,rejected',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $file = $request->file('image_path');
        $imagePath = $file->store('images', 'public');
        
        // Get image dimensions
        $imageSize = @getimagesize($file->getRealPath());
        $width = $imageSize[0] ?? null;
        $height = $imageSize[1] ?? null;

        $image = Image::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'width' => $width,
            'height' => $height,
            'file_size' => $file->getSize(),
            'license' => $validated['license'] ?? null,
            'photographer' => $validated['photographer'] ?? null,
            'user_id' => auth()->id(),
            'status' => $validated['status']
        ]);

        $image->categories()->attach($validated['categories']);

        // Redirect to content page with images tab
        return redirect()->route('admin.content.index', ['tab' => 'images'])
            ->with('success', 'Image uploaded successfully!');
    }

    /**
     * Show image details
     */
    public function showImage(Image $image)
    {
        $image->load(['user', 'categories']);
        return view('admin.images.show', compact('image'));
    }

    /**
     * Show form to edit image
     */
    public function editImage(Image $image)
    {
        $categories = \App\Models\Category::all();
        return view('admin.images.edit', compact('image', 'categories'));
    }

    /**
     * Update image
     */
    public function updateImage(Request $request, Image $image)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'license' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:255',
            'status' => 'required|in:draft,pending,published,rejected',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $oldImage = $image->image_path;
        
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $validated['image_path'] = $file->store('images', 'public');
            
            // Update dimensions
            $imageSize = @getimagesize($file->getRealPath());
            $validated['width'] = $imageSize[0] ?? null;
            $validated['height'] = $imageSize[1] ?? null;
            $validated['file_size'] = $file->getSize();
        }

        $image->update($validated);
        $image->categories()->sync($validated['categories']);

        if ($request->hasFile('image_path') && $oldImage) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImage);
        }

        // Redirect to content page with images tab
        return redirect()->route('admin.content.index', ['tab' => 'images'])
            ->with('success', 'Image updated successfully!');
    }

    /**
     * Delete image
     */
    public function destroyImage(Image $image)
    {
        if ($image->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        $imageTitle = $image->title;
        $image->delete();

        // Redirect to content page with images tab
        return redirect()->route('admin.content.index', ['tab' => 'images'])
            ->with('success', "Image '$imageTitle' has been deleted!");
    }

    /**
     * Display content management dashboard with tabs
     */
    public function content(Request $request)
    {
        $tab = $request->query('tab', 'articles');
        
        // Get items based on tab
        $query = null;
        $count = 0;
        
        if ($tab === 'articles') {
            $query = Article::with('user')->latest();
            $count = Article::count();
        } elseif ($tab === 'books') {
            $query = Book::with('user')->latest();
            $count = Book::count();
        } elseif ($tab === 'images') {
            $query = Image::with('user')->latest();
            $count = Image::count();
        }
        
        $items = $query->paginate(10, ['*'], $tab . '_page');
        
        // Get counts for all tabs
        $articlesCount = Article::count();
        $booksCount = Book::count();
        $imagesCount = Image::count();
        
        return view('admin.content.index', compact(
            'tab', 'items', 'count',
            'articlesCount', 'booksCount', 'imagesCount'
        ));
    }
}