<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Health check route for Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()
    ], 200);
});

// Redirect dashboard to home
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// PUBLIC ROUTES (anyone can access)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Books
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Images
Route::get('/images', [ImageController::class, 'index'])->name('images.index');

// AUTHENTICATED ROUTES (must be logged in)
Route::middleware(['auth'])->group(function () {
    // Articles - PUT CREATE ROUTES BEFORE {article} ROUTE!
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    
    // Books - PUT CREATE ROUTES BEFORE {book} ROUTE!
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    
    // Images - PUT CREATE ROUTES BEFORE {image} ROUTE!
    Route::get('/images/create', [ImageController::class, 'create'])->name('images.create');
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::get('/images/{image}/edit', [ImageController::class, 'edit'])->name('images.edit');
    Route::put('/images/{image}', [ImageController::class, 'update'])->name('images.update');
    Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');
    
    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Dashboard/My Content
    Route::get('/my-content', [ProfileController::class, 'myContent'])->name('my-content');
});

// PUBLIC SHOW ROUTES - These MUST come AFTER all /create routes
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/images/{image}', [ImageController::class, 'show'])->name('images.show');

// ADMIN ONLY ROUTES
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    
    // User Management - COMPLETE CRUD
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Articles - COMPLETE CRUD
    Route::get('/articles', [AdminController::class, 'articles'])->name('articles.index');
    Route::get('/articles/create', [AdminController::class, 'createArticle'])->name('articles.create');
    Route::post('/articles', [AdminController::class, 'storeArticle'])->name('articles.store');
    Route::get('/articles/{article}', [AdminController::class, 'showArticle'])->name('articles.show');
    Route::get('/articles/{article}/edit', [AdminController::class, 'editArticle'])->name('articles.edit');
    Route::put('/articles/{article}', [AdminController::class, 'updateArticle'])->name('articles.update');
    Route::delete('/articles/{article}', [AdminController::class, 'destroyArticle'])->name('articles.destroy');
    
    // Books - COMPLETE CRUD
    Route::get('/books', [AdminController::class, 'books'])->name('books.index');
    Route::get('/books/create', [AdminController::class, 'createBook'])->name('books.create');
    Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');
    Route::get('/books/{book}', [AdminController::class, 'showBook'])->name('books.show');
    Route::get('/books/{book}/edit', [AdminController::class, 'editBook'])->name('books.edit');
    Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{book}', [AdminController::class, 'destroyBook'])->name('books.destroy');
    
    // Images - COMPLETE CRUD
    Route::get('/images', [AdminController::class, 'images'])->name('images.index');
    Route::get('/images/create', [AdminController::class, 'createImage'])->name('images.create');
    Route::post('/images', [AdminController::class, 'storeImage'])->name('images.store');
    Route::get('/images/{image}', [AdminController::class, 'showImage'])->name('images.show');
    Route::get('/images/{image}/edit', [AdminController::class, 'editImage'])->name('images.edit');
    Route::put('/images/{image}', [AdminController::class, 'updateImage'])->name('images.update');
    Route::delete('/images/{image}', [AdminController::class, 'destroyImage'])->name('images.destroy');
    
    // Approval System
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{type}/{id}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{type}/{id}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
});


// AUTH ROUTES (Laravel Breeze provides these)
require __DIR__.'/auth.php';