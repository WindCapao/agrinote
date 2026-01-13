@extends('layouts.app')

@section('title', 'Edit Article - Contently')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Back button at the top -->
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('articles.show', $article) }}"
           style="background: #f3f4f6; 
                  color: #374151; 
                  padding: 0.5rem 1rem; 
                  border-radius: 0.375rem; 
                  text-decoration: none; 
                  font-weight: 600;
                  display: inline-block;">
            Back to Articles
        </a>
    </div>

    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem;">Edit Article</h1>
    
    <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Title -->
        <div style="margin-bottom: 1.5rem;">
            <label for="title" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Title <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   value="{{ old('title', $article->title) }}" 
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
        
        <!-- Content -->
        <div style="margin-bottom: 1.5rem;">
            <label for="content" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Content <span style="color: #dc2626;">*</span>
            </label>
            <textarea name="content" 
                      id="content" 
                      rows="15" 
                      required
                      style="width: 100%; 
                             padding: 0.75rem; 
                             border: 1px solid #d1d5db; 
                             border-radius: 0.5rem;
                             font-size: 1rem;
                             font-family: inherit;
                             @error('content') border-color: #dc2626; @enderror">{{ old('content', $article->content) }}</textarea>
            @error('content')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- Current Featured Image -->
        @if($article->featured_image)
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    Current Featured Image
                </label>
                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                     alt="Current featured image"
                     style="max-width: 300px; height: auto; border-radius: 0.5rem; border: 1px solid #d1d5db;">
            </div>
        @endif
        
        <!-- New Featured Image -->
        <div style="margin-bottom: 1.5rem;">
            <label for="featured_image" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Change Featured Image
            </label>
            <input type="file" 
                   name="featured_image" 
                   id="featured_image" 
                   accept="image/*"
                   style="width: 100%; 
                          padding: 0.75rem; 
                          border: 1px solid #d1d5db; 
                          border-radius: 0.5rem;
                          font-size: 1rem;
                          @error('featured_image') border-color: #dc2626; @enderror">
            @error('featured_image')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
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
                               {{ in_array($category->id, old('categories', $article->categories->pluck('id')->toArray())) ? 'checked' : '' }}
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
                <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
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
                Update Article
            </button>
            <a href="{{ route('articles.show', $article) }}" 
               style="padding: 0.75rem 2rem; 
                      background: #f3f4f6; 
                      color: #374151; 
                      border-radius: 0.5rem; 
                      text-decoration: none;
                      font-weight: 600;
                      font-size: 1rem;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection