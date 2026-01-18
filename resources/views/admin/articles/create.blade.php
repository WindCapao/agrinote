@extends('layouts.app')

@section('title', 'Create Article - Contently')

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
        min-height: 300px;
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
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">Create Article</h1>
        <p class="form-subtitle">Share your thoughts and insights with the community</p>
    </div>
    
    <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-card">
            <!-- Title -->
            <div class="form-section">
                <label class="form-label">Article Title</label>
                <input type="text" 
                       name="title" 
                       class="form-input"
                       value="{{ old('title') }}"
                       placeholder="Enter a compelling title..."
                       required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Content -->
            <div class="form-section">
                <label class="form-label">Content</label>
                <textarea name="content" 
                          class="form-textarea"
                          placeholder="Write your article here..."
                          required>{{ old('content') }}</textarea>
                <div class="form-help">Minimum 100 characters required</div>
                @error('content')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Featured Image -->
            <div class="form-section">
                <label class="form-label">Featured Image (Optional)</label>
                <input type="file" 
                       name="featured_image"
                       class="form-file"
                       accept="image/jpeg,image/png,image/jpg">
                <div class="form-help">JPEG, PNG, or JPG. Max 2MB.</div>
                @error('featured_image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
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
                <div class="form-help">Select at least one category</div>
                @error('categories')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Status -->
            <div class="form-section">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Submit for Review</option>
                    @if(auth()->user()->isAdmin())
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publish Immediately</option>
                        <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    @endif
                </select>
                <div class="form-help">
                    @if(auth()->user()->isAdmin())
                        Admins can publish immediately
                    @else
                        Select "Submit for Review" when ready for admin approval
                    @endif
                </div>
                @error('status')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn-submit">Create Article</button>
            <a href="{{ route('articles.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection