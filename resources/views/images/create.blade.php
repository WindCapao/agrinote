@extends('layouts.app')

@section('title', 'Upload New Image - Contently')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Back button at the top -->
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('images.index') }}"
           style="background: #f3f4f6; 
                  color: #374151; 
                  padding: 0.5rem 1rem; 
                  border-radius: 0.375rem; 
                  text-decoration: none; 
                  font-weight: 600;
                  display: inline-block;">
            Back to Images
        </a>
    </div>

    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem;">Upload New Image</h1>
    
    <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Image File -->
        <div style="margin-bottom: 1.5rem;">
            <label for="image_path" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Image File <span style="color: #dc2626;">*</span>
            </label>
            <input type="file" 
                   name="image_path" 
                   id="image_path" 
                   accept="image/*"
                   required
                   onchange="previewImage(event)"
                   style="width: 100%; 
                          padding: 0.75rem; 
                          border: 1px solid #d1d5db; 
                          border-radius: 0.5rem;
                          font-size: 1rem;
                          @error('image_path') border-color: #dc2626; @enderror">
            @error('image_path')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">
                Accepted formats: JPEG, PNG, JPG, GIF, WebP. Max size: 5MB
            </p>
            
            <!-- Image Preview -->
            <div id="imagePreview" style="margin-top: 1rem; display: none;">
                <p style="font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Preview:</p>
                <img id="preview" src="" alt="Preview" style="max-width: 100%; max-height: 400px; border-radius: 0.5rem; border: 1px solid #d1d5db;">
            </div>
        </div>
        
        <!-- Title -->
        <div style="margin-bottom: 1.5rem;">
            <label for="title" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Image Title <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   value="{{ old('title') }}" 
                   required
                   placeholder="e.g., Sunset over Mountains"
                   style="width: 100%; 
                          padding: 0.75rem; 
                          border: 1px solid #d1d5db; 
                          border-radius: 0.5rem;
                          font-size: 1rem;
                          @error('title') border-color: #dc2626; @enderror">
            @error('title')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Description -->
        <div style="margin-bottom: 1.5rem;">
            <label for="description" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Description
            </label>
            <textarea name="description" 
                      id="description" 
                      rows="4" 
                      placeholder="Add a description for this image..."
                      style="width: 100%; 
                             padding: 0.75rem; 
                             border: 1px solid #d1d5db; 
                             border-radius: 0.5rem;
                             font-size: 1rem;
                             font-family: inherit;
                             @error('description') border-color: #dc2626; @enderror">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Photographer and License Row -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
            <!-- Photographer -->
            <div>
                <label for="photographer" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    Photographer / Credit
                </label>
                <input type="text" 
                       name="photographer" 
                       id="photographer" 
                       value="{{ old('photographer') }}" 
                       placeholder="Your name or photographer name"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.5rem;
                              font-size: 1rem;">
                @error('photographer')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- License -->
            <div>
                <label for="license" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    License
                </label>
                <select name="license" 
                        id="license" 
                        style="width: 100%; 
                               padding: 0.75rem; 
                               border: 1px solid #d1d5db; 
                               border-radius: 0.5rem;
                               font-size: 1rem;">
                    <option value="">Select a license</option>
                    <option value="All Rights Reserved" {{ old('license') === 'All Rights Reserved' ? 'selected' : '' }}>All Rights Reserved</option>
                    <option value="CC BY" {{ old('license') === 'CC BY' ? 'selected' : '' }}>CC BY (Attribution)</option>
                    <option value="CC BY-SA" {{ old('license') === 'CC BY-SA' ? 'selected' : '' }}>CC BY-SA (Share Alike)</option>
                    <option value="CC BY-ND" {{ old('license') === 'CC BY-ND' ? 'selected' : '' }}>CC BY-ND (No Derivatives)</option>
                    <option value="CC BY-NC" {{ old('license') === 'CC BY-NC' ? 'selected' : '' }}>CC BY-NC (Non-Commercial)</option>
                    <option value="CC0" {{ old('license') === 'CC0' ? 'selected' : '' }}>CC0 (Public Domain)</option>
                </select>
                @error('license')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <!-- Categories with checkboxes -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Categories</label>
            <div style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 1rem; max-height: 200px; overflow-y: auto;">
                @foreach($categories as $category)
                    <div style="margin-bottom: 0.5rem;">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}" 
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                style="margin-right: 0.5rem;">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('categories')
                <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Status -->
        <div style="margin-bottom: 1.5rem;">
            <label for="status" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Status <span style="color: #dc2626;">*</span>
            </label>
            <select name="status" 
                    id="status" 
                    required
                    style="width: 100%; 
                           padding: 0.75rem; 
                           border: 1px solid #d1d5db; 
                           border-radius: 0.5rem;
                           font-size: 1rem;">
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Save as Draft</option>
                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Submit for Approval</option>
                @if(Auth::user()->isAdmin())
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publish Immediately (Admin)</option>
                    <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Reject (Admin)</option>
                @endif
            </select>
            @error('status')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">
                @if(Auth::user()->isAdmin())
                    As an admin, you can publish immediately or submit for review.
                @else
                    Submit for approval to have your content reviewed by an admin.
                @endif
            </p>
        </div>
        <!-- Submit Buttons -->
        <div style="display: flex; gap: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <button type="submit" 
                    style="padding: 0.75rem 2rem; 
                           background: #2563eb; 
                           color: white; 
                           border: none; 
                           border-radius: 0.5rem; 
                           cursor: pointer;
                           font-weight: 600;
                           font-size: 1rem;">
                Upload Image
            </button>
            <a href="{{ route('images.index') }}" 
               style="padding: 0.75rem 2rem; 
                      background: #f3f4f6; 
                      color: #374151; 
                      border-radius: 0.5rem; 
                      text-decoration: none;
                      font-weight: 600;
                      font-size: 1rem;
                      display: inline-block;
                      text-align: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection