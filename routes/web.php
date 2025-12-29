<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES (anyone can access)
Route::get('/', [ArticleController::class, 'index'])->name('home');

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
});

// PUBLIC SHOW ROUTES - These MUST come AFTER all /create routes
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/images/{image}', [ImageController::class, 'show'])->name('images.show');

// ADMIN ONLY ROUTES
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
    Route::get('/books', [AdminController::class, 'books'])->name('admin.books');
    Route::get('/images', [AdminController::class, 'images'])->name('admin.images');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});

// AUTH ROUTES (Laravel Breeze provides these)
require __DIR__.'/auth.php';