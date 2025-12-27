<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'total_users' => User::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    public function articles()
    {
        $articles = Article::with('user')->latest()->paginate(20);
        return view('admin.articles', compact('articles'));
    }
    
    public function users()
    {
        $users = User::withCount('articles')->paginate(20);
        return view('admin.users', compact('users'));
    }
}