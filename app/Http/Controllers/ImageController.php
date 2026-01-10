<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class ImageController extends Controller
{
    /**
     * Display a listing of published images
     */
    public function index()
    {
        $images = Image::with(['user', 'categories']) 
            ->where('status', 'published')
            ->latest()
            ->paginate(12);
        
        return view('images.index', compact('images'));
    }

    /**
     * Show the form for uploading a new image
     */
    public function create()
    {
        $categories = Category::all();
        return view('images.create', compact('categories'));
    }

    /**
     * Store a newly uploaded image
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'license' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        DB::beginTransaction();
        
        try {
            $file = $request->file('image_path');
            $imagePath = $file->store('images', 'public');
            
            // Get image dimensions
            $imageSize = @getimagesize($file->getRealPath());
            $width = $imageSize[0] ?? null;
            $height = $imageSize[1] ?? null;

            $image = Image::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'image_path' => $imagePath,
                'width' => $width,
                'height' => $height,
                'file_size' => $file->getSize(),
                'license' => $validated['license'] ?? null,
                'photographer' => $validated['photographer'] ?? null,
                'user_id' => Auth::id(),
                'status' => $validated['status']
            ]);

            $image->categories()->attach($validated['categories']);
            
            DB::commit();

            return redirect()
                ->route('images.show', $image)
                ->with('success', 'Image uploaded successfully!');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            if (isset($imagePath) && $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to upload image. Please try again.']);
        }
    }

    /**
     * Display the specified image
     */
    public function show(Image $image)
    {
        $image->load(['user', 'categories']);
        return view('images.show', compact('image'));
    }

    /**
     * Show the form for editing the specified image
     */
    public function edit(Image $image)
    {
        if (Auth::id() !== $image->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('images.edit', compact('image', 'categories'));
    }

    /**
     * Update the specified image
     */
    public function update(Request $request, Image $image)
    {
        if (Auth::id() !== $image->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'license' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:draft,published'
        ]);

        DB::beginTransaction();
        
        try {
            $oldImage = $image->image_path;
            
            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $validated['image_path'] = $file->store('images', 'public');
                
                // Update dimensions
                $imageSize = @getimagesize($file->getRealPath());
                $validated['width'] = $imageSize[0] ?? null;
                $validated['height'] = $imageSize[1] ?? null;
                $validated['file_size'] = $file->getSize();
            }

            $image->update($validated);
            $image->categories()->sync($validated['categories']);
            
            if ($request->hasFile('image_path') && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            
            DB::commit();

            return redirect()
                ->route('images.show', $image)
                ->with('success', 'Image updated successfully!');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            if (isset($validated['image_path']) && $validated['image_path'] !== $oldImage) {
                Storage::disk('public')->delete($validated['image_path']);
            }
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update image. Please try again.']);
        }
    }

    /**
     * Remove the specified image
     */
    public function destroy(Image $image)
    {
        if (Auth::id() !== $image->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }

            $image->delete();

            return redirect()
                ->route('images.index')
                ->with('success', 'Image deleted successfully!');
                
        } catch (Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to delete image. Please try again.']);
        }
    }
}