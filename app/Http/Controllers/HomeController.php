<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Book;
use App\Models\Image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with mixed content
     */
    public function index()
    {
        // Get latest 6 articles
        $articles = Article::published()
            ->with(['user', 'categories'])
            ->latest()
            ->limit(6)
            ->get();
        
        // Get latest 6 books
        $books = Book::where('status', 'published')
            ->with(['user', 'categories'])
            ->latest()
            ->limit(6)
            ->get();
        
        // Get latest 6 images
        $images = Image::where('status', 'published')
            ->with(['user', 'categories'])
            ->latest()
            ->limit(6)
            ->get();
        
        return view('home', compact('articles', 'books', 'images'));
    }
}