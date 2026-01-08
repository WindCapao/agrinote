<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{

    public function index() //list all articles
    {
        $articles = Article::published()        //published lang makukuha
            ->with(['user', 'categories'])      //load w/ user and categories
            ->latest()                          //latest first
            ->paginate(10);                     //10 articles per page
        
        return view('articles.index', compact('articles'));  //send to view
    }

    public function create() //show create article form
    {
        if (!Auth::check()) {                       //check if logged in
            return redirect()->route('login');      //if not, redirect to login
        }

        $categories = Category::all();              //get all categories
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request) //save new article
    {
        $validated = $request->validate([           //validate data
            'title' => 'required|string|max:255',   //title is required, max 255 chars
            'content' => 'required|string|min:100', //content required, min 100 chars
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  //optional image
            'categories' => 'required|array|min:1',  //at least one category
            'categories.*' => 'exists:categories,id', //each category must exist
            'status' => 'required|in:draft,published'  //status must be draft or published
        ]);

        $imagePath = null;                        //handle image upload
        if ($request->hasFile('featured_image')) {  //Store in storage/app/public/articles/
            $imagePath = $request->file('featured_image')->store('articles', 'public');
        }
 
        $article = Article::create([            //create article in db
            'title' => $validated['title'],
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'user_id' => Auth::id(),            //current user as author
            'status' => $validated['status']
        ]);

        $article->categories()->attach($validated['categories']);   //attach categories

        return redirect()
            ->route('articles.show', $article)  //redirect to article view
            ->with('success', 'Article created successfully!');  //success message
    }

    public function show(Article $article) //view single article
    {
        $article->load(['user', 'categories']);   //load user and categories
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article) //show edit article form
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {  //check ownership or admin
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();  //get all categories
        return view('articles.edit', compact('article', 'categories'));  //send to view
    }

    public function update(Request $request, Article $article) //save edited article
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {  //check ownership or admin
            abort(403);
        }

        $validated = $request->validate([       //validate data
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array|min:1',
            'status' => 'required|in:draft,published'
        ]);

        if ($request->hasFile('featured_image')) {    //handle image replacement
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public'); //store new image
        }

        $article->update($validated);  //update article and db
        $article->categories()->sync($validated['categories']);  //sync categories

        return redirect()
            ->route('articles.show', $article)  //redirect to article view
            ->with('success', 'Article updated!');  //success message
    }

    /**
     * Remove article from database
     */
    public function destroy(Article $article) //delete article
    {
        if (Auth::id() !== $article->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image); //delete image from storage
        }

        $article->delete();

        return redirect()
            ->route('articles.index')  //redirect to articles list
            ->with('success', 'Article deleted!');  //success message
    }
}