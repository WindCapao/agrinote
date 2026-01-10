<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Image;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function dashboard()
    {
        $articleCount = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        
        $bookCount = Book::count();
        $publishedBooks = Book::where('status', 'published')->count();
        $draftBooks = Book::where('status', 'draft')->count();
        
        $imageCount = Image::count();
        $publishedImages = Image::where('status', 'published')->count();
        $draftImages = Image::where('status', 'draft')->count();
        
        $userCount = User::count();

        return view('admin.dashboard', compact(
            'articleCount', 'publishedArticles', 'draftArticles',
            'bookCount', 'publishedBooks', 'draftBooks',
            'imageCount', 'publishedImages', 'draftImages', 'userCount'
        ));
    }
    
    /**
     * List all articles with pagination
     */
    public function articles()
    {
        $articles = Article::with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.articles', compact('articles'));
    }
    
    /**
     * List all users with their article counts
     */
    public function users()
    {
        $users = User::withCount('articles')
            ->latest()
            ->paginate(10);
            
        return view('admin.users', compact('users'));
    }

    /**
     * List all books with pagination
     */
    public function books()
    {
        $books = Book::with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.books', compact('books'));
    }

    /**
     * List all images with pagination
     */
    public function images()
    {
        $images = Image::with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.images', compact('images'));
    }
}