<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles (homepage)
     */
    public function index()
    {
        $articles = Article::published()
            ->with(['user', 'categories'])
            ->latest()
            ->paginate(10);
        
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created article in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        }

        $article = Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'user_id' => Auth::id(),
            'status' => $validated['status']
        ]);

        $article->categories()->attach($validated['categories']);

        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Article created successfully!');
    }

    /**
     * Display a single article
     */
    public function show(Article $article)
    {
        $article->load(['user', 'categories']);
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing an article
     */
    public function edit(Article $article)
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the article in database
     */
    public function update(Request $request, Article $article)
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'status' => 'required|in:draft,published'
        ]);

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $article->update($validated);
        $article->categories()->sync($validated['categories']);

        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Article updated!');
    }

    /**
     * Remove article from database
     */
    public function destroy(Article $article)
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article deleted!');
    }
}