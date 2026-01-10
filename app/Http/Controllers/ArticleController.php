<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class ArticleController extends Controller
{
    /**
     * Display a listing of published articles
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
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created article
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

        DB::beginTransaction();
        
        try {
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
            
            DB::commit();

            return redirect()
                ->route('articles.show', $article)
                ->with('success', 'Article created successfully!');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            // Clean up uploaded image if article creation failed
            if (isset($imagePath) && $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create article. Please try again.']);
        }
    }

    /**
     * Display the specified article
     */
    public function show(Article $article)
    {
        $article->load(['user', 'categories']);
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article
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
     * Update the specified article
     */
    public function update(Request $request, Article $article)
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        DB::beginTransaction();
        
        try {
            $oldImage = $article->featured_image;
            
            if ($request->hasFile('featured_image')) {
                $validated['featured_image'] = $request->file('featured_image')
                    ->store('articles', 'public');
            }

            $article->update($validated);
            $article->categories()->sync($validated['categories']);
            
            // Delete old image only after successful update
            if ($request->hasFile('featured_image') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            
            DB::commit();

            return redirect()
                ->route('articles.show', $article)
                ->with('success', 'Article updated successfully!');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            // Clean up new image if update failed
            if (isset($validated['featured_image'])) {
                Storage::disk('public')->delete($validated['featured_image']);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update article. Please try again.']);
        }
    }

    /**
     * Remove the specified article
     */
    public function destroy(Article $article)
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }

            $article->delete();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Article deleted successfully!');
                
        } catch (Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to delete article. Please try again.']);
        }
    }
}