@extends('layouts.app')

@section('title', 'Edit Image - Admin')

@section('content')
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid var(--primary);
    }
    
    .form-title {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .form-subtitle {
        color: var(--text-light);
        font-size: 1.1rem;
    }
    
    .form-card {
        background: var(--white);
        border: 1px solid var(--border);
        padding: 3rem;
        margin-bottom: 2rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section:last-child {
        margin-bottom: 0;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }
    
    .form-input,
    .form-textarea,
    .form-select,
    .form-file {
        width: 100%;
        padding: 1rem;
        border: 2px solid var(--border);
        font-size: 1rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s;
        background: var(--white);
    }
    
    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--accent);
    }
    
    .form-textarea {
        min-height: 150px;
        resize: vertical;
        line-height: 1.6;
    }
    
    .form-help {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    
    .current-image {
        margin-top: 1rem;
        padding: 1rem;
        background: var(--secondary);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
    }
    
    .current-image img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 0.5rem;
        display: block;
        margin: 0 auto;
    }
    
    .current-image-label {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .image-details {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .checkbox-group {
        border: 2px solid var(--border);
        padding: 1.5rem;
        max-height: 250px;
        overflow-y: auto;
        background: var(--secondary);
    }
    
    .checkbox-item {
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }
    
    .checkbox-item:last-child {
        margin-bottom: 0;
    }
    
    .checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 0.75rem;
        cursor: pointer;
    }
    
    .checkbox-item label {
        cursor: pointer;
        font-size: 0.95rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    
    .upload-zone {
        border: 3px dashed var(--border);
        padding: 3rem;
        text-align: center;
        background: var(--secondary);
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .upload-zone:hover {
        border-color: var(--accent);
        background: var(--white);
    }
    
    .upload-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }
    
    .btn-submit {
        padding: 1rem 2.5rem;
        background: var(--primary);
        color: var(--white);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-submit:hover {
        background: var(--white);
        color: var(--primary);
    }
    
    .btn-cancel {
        padding: 1rem 2.5rem;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-cancel:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .btn-back {
        padding: 0.75rem 2rem;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-back:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">Edit Image</h1>
        <p class="form-subtitle">Update image details and settings</p>
    </div>
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <a href="{{ route('admin.images.show', $image) }}" class="btn-back">Back to Image Details</a>
    </div>
    
    <form method="POST" action="{{ route('admin.images.update', $image) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-card">
            <!-- Current Image -->
            <div class="form-section">
                <label class="form-label">Current Image</label>
                <div class="current-image">
                    <div class="current-image-label">Currently Uploaded Image</div>
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="{{ $image->title }}">
                    @if($image->width && $image->height)
                        <div class="image-details">
                            Dimensions: {{ $image->width }} × {{ $image->height }} pixels | 
                            Size: {{ $image->getFileSizeFormatted() }}
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Replace Image -->
            <div class="form-section">
                <label class="form-label">Replace Image (Optional)</label>
                <div class="upload-zone" onclick="document.getElementById('imageUpload').click()">
                    <div class="upload-icon">🖼️</div>
                    <div style="font-size: 1rem; color: var(--text-light); margin-bottom: 0.5rem;">
                        Click to select a new image file
                    </div>
                </div>
                <input type="file" 
                       name="image_path" 
                       id="imageUpload"
                       class="form-file"
                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                       style="display: none;">
                <div style="margin-top: 1rem; font-size: 0.95rem; color: var(--primary);" id="fileName">
                    No new file selected
                </div>
                <div class="form-help">
                    Leave empty to keep current image. JPEG, PNG, JPG, GIF, or WEBP. Maximum file size: 5MB
                </div>
                @error('image_path')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Title -->
            <div class="form-section">
                <label class="form-label">Image Title</label>
                <input type="text" 
                       name="title" 
                       class="form-input"
                       value="{{ old('title', $image->title) }}"
                       placeholder="Enter a descriptive title for the image..."
                       required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Description -->
            <div class="form-section">
                <label class="form-label">Description</label>
                <textarea name="description" 
                          class="form-textarea"
                          placeholder="Describe the image, provide context, or tell a story...">{{ old('description', $image->description) }}</textarea>
                <div class="form-help">Optional: Add context or background information about the image</div>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Photographer & License -->
            <div class="form-section form-grid">
                <div>
                    <label class="form-label">Photographer / Credit</label>
                    <input type="text" 
                           name="photographer" 
                           class="form-input"
                           value="{{ old('photographer', $image->photographer) }}"
                           placeholder="Photographer's name...">
                    @error('photographer')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">License</label>
                    <select name="license" class="form-select">
                        <option value="">Select a license</option>
                        <option value="All Rights Reserved" {{ old('license', $image->license) === 'All Rights Reserved' ? 'selected' : '' }}>All Rights Reserved</option>
                        <option value="CC BY" {{ old('license', $image->license) === 'CC BY' ? 'selected' : '' }}>Creative Commons Attribution (CC BY)</option>
                        <option value="CC BY-SA" {{ old('license', $image->license) === 'CC BY-SA' ? 'selected' : '' }}>Creative Commons ShareAlike (CC BY-SA)</option>
                        <option value="CC BY-ND" {{ old('license', $image->license) === 'CC BY-ND' ? 'selected' : '' }}>Creative Commons NoDerivatives (CC BY-ND)</option>
                        <option value="CC BY-NC" {{ old('license', $image->license) === 'CC BY-NC' ? 'selected' : '' }}>Creative Commons NonCommercial (CC BY-NC)</option>
                        <option value="CC0" {{ old('license', $image->license) === 'CC0' ? 'selected' : '' }}>Public Domain (CC0)</option>
                    </select>
                    <div class="form-help">Optional: Specify the image license</div>
                    @error('license')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Categories -->
            <div class="form-section">
                <label class="form-label">Categories</label>
                <div class="checkbox-group">
                    @php
                        $selectedCategories = old('categories', $image->categories->pluck('id')->toArray());
                    @endphp
                    @foreach($categories as $category)
                        <div class="checkbox-item">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}"
                                   id="category-{{ $category->id }}"
                                   {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                            <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-help">Select one or more categories to organize the image</div>
                @error('categories')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Status -->
            <div class="form-section">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ old('status', $image->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ old('status', $image->status) === 'pending' ? 'selected' : '' }}>Pending Review</option>
                    <option value="published" {{ old('status', $image->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ old('status', $image->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <div class="form-help">As an admin, you can change the image status</div>
                @error('status')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-submit">Update Image</button>
            <a href="{{ route('admin.images.show', $image) }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('imageUpload');
    const fileName = document.getElementById('fileName');
    
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            fileName.textContent = this.files[0]?.name || 'No new file selected';
        });
    }
});
</script>
@endsection