@extends('layouts.app')

@section('title', 'Upload Image - Admin')

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
    
    .upload-text {
        font-size: 1rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
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
        <h1 class="form-title">Upload New Image</h1>
        <p class="form-subtitle">Add a new image to the Contently gallery</p>
    </div>
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <a href="{{ route('admin.images.index') }}" class="btn-back">Back to Images</a>
    </div>
    
    <form method="POST" action="{{ route('admin.images.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-card">
            <!-- Image Upload -->
            <div class="form-section">
                <label class="form-label">Image File</label>
                <div class="upload-zone" onclick="document.getElementById('imageUpload').click()">
                    <div class="upload-icon">🖼️</div>
                    <div class="upload-text">Click to select an image file</div>
                    <div style="font-size: 0.85rem; color: var(--text-light);">
                        or drag and drop your image here
                    </div>
                </div>
                <input type="file" 
                       name="image_path" 
                       id="imageUpload"
                       class="form-file" 
                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" 
                       required 
                       style="display: none;"
                       onchange="document.getElementById('fileName').textContent = this.files[0]?.name || 'No file selected'">
                <div style="margin-top: 1rem; font-size: 0.95rem; color: var(--primary);" id="fileName">
                    No file selected
                </div>
                <div class="form-help">JPEG, PNG, JPG, GIF, or WEBP. Maximum file size: 5MB</div>
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
                       value="{{ old('title') }}" 
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
                          placeholder="Describe the image, provide context, or tell a story...">{{ old('description') }}</textarea>
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
                           value="{{ old('photographer') }}" 
                           placeholder="Photographer's name...">
                    @error('photographer')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">License</label>
                    <select name="license" class="form-select">
                        <option value="">Select a license</option>
                        <option value="All Rights Reserved" {{ old('license') === 'All Rights Reserved' ? 'selected' : '' }}>All Rights Reserved</option>
                        <option value="CC BY" {{ old('license') === 'CC BY' ? 'selected' : '' }}>Creative Commons Attribution (CC BY)</option>
                        <option value="CC BY-SA" {{ old('license') === 'CC BY-SA' ? 'selected' : '' }}>Creative Commons ShareAlike (CC BY-SA)</option>
                        <option value="CC BY-ND" {{ old('license') === 'CC BY-ND' ? 'selected' : '' }}>Creative Commons NoDerivatives (CC BY-ND)</option>
                        <option value="CC BY-NC" {{ old('license') === 'CC BY-NC' ? 'selected' : '' }}>Creative Commons NonCommercial (CC BY-NC)</option>
                        <option value="CC0" {{ old('license') === 'CC0' ? 'selected' : '' }}>Public Domain (CC0)</option>
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
                    @foreach($categories as $category)
                        <div class="checkbox-item">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}" 
                                   id="category-{{ $category->id }}"
                                   {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
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
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Save as Draft</option>
                    <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Submit for Review</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publish Immediately</option>
                    <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Mark as Rejected</option>
                </select>
                <div class="form-help">As an admin, you can publish immediately or submit for review</div>
                @error('status')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-submit">Upload Image</button>
            <a href="{{ route('admin.images.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.querySelector('.upload-zone');
    const fileInput = document.getElementById('imageUpload');
    const fileName = document.getElementById('fileName');
    
    // Handle click
    uploadZone.addEventListener('click', function(e) {
        if (e.target !== fileInput) {
            fileInput.click();
        }
    });
    
    // Handle drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadZone.style.borderColor = 'var(--accent)';
        uploadZone.style.background = 'var(--white)';
    }
    
    function unhighlight() {
        uploadZone.style.borderColor = 'var(--border)';
        uploadZone.style.background = 'var(--secondary)';
    }
    
    uploadZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        fileName.textContent = files[0]?.name || 'No file selected';
    }
    
    // Handle file input change
    fileInput.addEventListener('change', function() {
        fileName.textContent = this.files[0]?.name || 'No file selected';
    });
});
</script>
@endsection