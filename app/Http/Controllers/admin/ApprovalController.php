<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Book;
use App\Models\Image;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    private function resolveModel(string $type)
    {
        return match ($type) {
            'articles' => Article::class,
            'books'    => Book::class,
            'images'   => Image::class,
            default    => abort(404, 'Invalid type.'),
        };
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'articles');

        $articles = Article::with('user')->where('status', 'pending')->latest()->paginate(10, ['*'], 'articles_page');
        $books    = Book::with('user')->where('status', 'pending')->latest()->paginate(10, ['*'], 'books_page');
        $images   = Image::with('user')->where('status', 'pending')->latest()->paginate(10, ['*'], 'images_page');

        return view('admin.approvals.index', compact('tab', 'articles', 'books', 'images'));
    }

    public function approve(string $type, int $id)
    {
        $modelClass = $this->resolveModel($type);
        $item = $modelClass::findOrFail($id);

        $item->update(['status' => 'published']);

        return back()->with('success', ucfirst(rtrim($type, 's')) . ' approved and published.');
    }

    public function reject(string $type, int $id)
    {
        $modelClass = $this->resolveModel($type);
        $item = $modelClass::findOrFail($id);

        $item->update(['status' => 'rejected']);

        return back()->with('success', ucfirst(rtrim($type, 's')) . ' rejected.');
    }
}