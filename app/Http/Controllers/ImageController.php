<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::with(['user', 'categories']) 
            ->where('status', 'published')  //only published images
            ->latest()   //latest first
            ->paginate(12);  //12 images per page
        
        return view('images.index', compact('images')); //send to view
    }

    public function create()  //show image upload form
    {
        if (!Auth::check()) {  //check if logged in
            return redirect()->route('login');  //if not, redirect to login
        }

        $categories = Category::all();  //get all categories
        return view('images.create', compact('categories'));  //send to view
    }

    public function store(Request $request)  //save new image
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'license' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        $file = $request->file('image_path');  //handle image upload
        $imagePath = $file->store('images', 'public');  //Store in storage/app/public/images/
        
        // Get image dimensions
        $imageSize = getimagesize($file->getRealPath());
        $width = $imageSize[0] ?? null;  //get width
        $height = $imageSize[1] ?? null;  //get height

        $image = Image::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,  //path in storage
            'width' => $width,
            'height' => $height,
            'file_size' => $file->getSize(),  //in bytes
            'license' => $validated['license'] ?? null,
            'photographer' => $validated['photographer'] ?? null,  //optional
            'user_id' => Auth::id(),  //current user as uploader
            'status' => $validated['status']
        ]);

        $image->categories()->attach($validated['categories']);

        return redirect()
            ->route('images.show', $image)  //redirect to image view
            ->with('success', 'Image uploaded successfully!');  //success message
    }

    public function show(Image $image)
    {
        $image->load(['user', 'categories']);
        return view('images.show', compact('image'));
    }

    public function edit(Image $image)
    {
        if (Auth::id() !== $image->user_id && !Auth::user()->isAdmin()) {  //check ownership or admin
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('images.edit', compact('image', 'categories'));
    }

    public function update(Request $request, Image $image)
    {
        if (Auth::id() !== $image->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'license' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:255',
            'categories' => 'required|array|min:1',
            'status' => 'required|in:draft,published'
        ]);

        if ($request->hasFile('image_path')) {
            // Delete old image
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
            
            $file = $request->file('image_path');
            $validated['image_path'] = $file->store('images', 'public');
            
            // Update dimensions
            $imageSize = getimagesize($file->getRealPath());
            $validated['width'] = $imageSize[0] ?? null;
            $validated['height'] = $imageSize[1] ?? null;
            $validated['file_size'] = $file->getSize();
        }

        $image->update($validated);
        $image->categories()->sync($validated['categories']);

        return redirect()
            ->route('images.show', $image)
            ->with('success', 'Image updated successfully!');
    }

    public function destroy(Image $image)
    {
        if (Auth::id() !== $image->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()
            ->route('images.index')
            ->with('success', 'Image deleted successfully!');
    }
}
