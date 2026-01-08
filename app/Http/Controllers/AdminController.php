<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Image;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Define variables individually so compact() can find them
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
    
    public function articles()  //list all articles
    {
        $articles = Article::with('user')   //author info
            ->latest()                         //latest first   
            ->paginate(10);                   //10 per page
        return view('admin.articles', compact('articles'));  //send to view
    }
    
    public function users() //list all users
    {
        $users = User::withCount('articles')  //count of articles per user
            ->latest()                         //latest first   
            ->paginate(10);               //10 per page
        return view('admin.users', compact('users')); //send to view
    }

        public function books() //list all books
    {
        $books = Book::with('user')
            ->latest()  //latest first
            ->paginate(10);  //10 per page
        return view('admin.books', compact('books'));  //send to view
    }

    public function images()  //list all images
    {
        $images = Image::with('user')
            ->latest()  //latest first
            ->paginate(10);   //10 per page
        return view('admin.images', compact('images'));  //send to view
    }
}