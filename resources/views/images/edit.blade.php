@extends('layouts.app')

@section('title', 'Edit Image - Contently')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem;">🖼️ Edit Image</h1>
    
    <form method="POST" action="{{ route('images.update', $image) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Current Image -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Current Image
            </label>
            <img src="{{ asset('storage/' . $image->image_path) }}" 
                 alt="{{ $image->title }}"
                 style="max-width: 100%; max-height: 400px; border-radius: 0.5rem; border: 1px solid #d1d5db;">
            @if($image->width && $image->height)
                <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">
                    Dimensions: {{ $image->width }} × {{ $image->height }} pixels | Size: {{ $image->getFileSizeFormatted() }}
                </p>
            @endif
        </div>
        
        <!-- Replace Image -->
        <div style="margin-bottom: 1.5rem;">
            <label for="image_path" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Replace Image (Optional)
            </label>
            <input type="file" 
                   name="image_path" 
                   id="image_path" 
                   accept="image/*"
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
                Leave empty to keep current image
            </p>
            
            <!-- New Image Preview -->
            <div id="imagePreview" style="margin-top: 1rem; display: none;">
                <p style="font-weight: 600; margin-bottom: 0.5rem; color: #374151;">New Preview:</p>
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
                   value="{{ old('title', $image->title) }}" 
                   required
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
                      style="width: 100%; 
                             padding: 0.75rem; 
                             border: 1px solid #d1d5db; 
                             border-radius: 0.5rem;
                             font-size: 1rem;
                             font-family: inherit;">{{ old('description', $image->description) }}</textarea>
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
                       value="{{ old('photographer', $image->photographer) }}" 
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.5rem;
                              font-size: 1rem;">
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
                    <option value="All Rights Reserved" {{ old('license', $image->license) === 'All Rights Reserved' ? 'selected' : '' }}>All Rights Reserved</option>
                    <option value="CC BY" {{ old('license', $image->license) === 'CC BY' ? 'selected' : '' }}>CC BY (Attribution)</option>
                    <option value="CC BY-SA" {{ old('license', $image->license) === 'CC BY-SA' ? 'selected' : '' }}>CC BY-SA (Share Alike)</option>
                    <option value="CC BY-ND" {{ old('license', $image->license) === 'CC BY-ND' ? 'selected' : '' }}>CC BY-ND (No Derivatives)</option>
                    <option value="CC BY-NC" {{ old('license', $image->license) === 'CC BY-NC' ? 'selected' : '' }}>CC BY-NC (Non-Commercial)</option>
                    <option value="CC0" {{ old('license', $image->license) === 'CC0' ? 'selected' : '' }}>CC0 (Public Domain)</option>
                </select>
            </div>
        </div>
        
        <!-- Categories -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Categories <span style="color: #dc2626;">*</span>
            </label>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                @foreach($categories as $category)
                    <label style="display: flex; align-items: center; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; cursor: pointer;">
                        <input type="checkbox" 
                               name="categories[]" 
                               value="{{ $category->id }}"
                               {{ in_array($category->id, old('categories', $image->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                               style="margin-right: 0.5rem; width: 18px; height: 18px; cursor: pointer;">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('categories')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
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
                <option value="draft" {{ old('status', $image->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $image->status) === 'published' ? 'selected' : '' }}>Published</option>
            </select>
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
                Update Image
            </button>
            <a href="{{ route('images.show', $image) }}" 
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