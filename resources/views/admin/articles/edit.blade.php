@extends('layouts.app')

@section('title', 'Edit Article - Admin')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="margin-bottom: 1rem;">
            <a href="{{ URL::previous() }}"
               style="background: #f3f4f6; 
                      color: #374151; 
                      padding: 0.5rem 1rem; 
                      border-radius: 0.375rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      display: inline-block;">
                Back to Article
            </a>
        </div>
        <h1 style="font-size: 1.875rem; font-weight: bold;">Edit Article</h1>
        <p style="color: #6b7280;">Update article information</p>
    </div>

    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="background: white; border-radius: 0.5rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <!-- Title -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Title</label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title', $article->title) }}"
                       required
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('title')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Content -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Content</label>
                <textarea name="content" 
                          rows="10"
                          required
                          style="width: 100%; 
                                 padding: 0.75rem; 
                                 border: 1px solid #d1d5db; 
                                 border-radius: 0.375rem; 
                                 font-size: 1rem;">{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Current Featured Image -->
            @if($article->featured_image)
                <div style="margin-bottom: 1rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Current Image</div>
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="Current featured image"
                         style="width: 200px; 
                                height: 150px; 
                                object-fit: cover; 
                                border-radius: 0.375rem;">
                </div>
            @endif

            <!-- Featured Image -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                    {{ $article->featured_image ? 'Change Featured Image' : 'Featured Image' }}
                </label>
                <input type="file" 
                       name="featured_image"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('featured_image')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Status</label>
                <select name="status" 
                        required
                        style="width: 100%; 
                               padding: 0.75rem; 
                               border: 1px solid #d1d5db; 
                               border-radius: 0.375rem; 
                               font-size: 1rem;">
                    <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ old('status', $article->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ old('status', $article->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Categories with checkboxes -->
<div style="margin-bottom: 2rem;">
    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Categories</label>
    <div style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 1rem; max-height: 200px; overflow-y: auto; background: white;">
        @php
            $selectedCategories = old('categories', $article->categories->pluck('id')->toArray());
        @endphp
        
        @foreach($categories as $category)
            <div style="margin-bottom: 0.5rem;">
                <label style="display: flex; align-items: center; cursor: pointer; padding: 0.25rem 0;">
                    <input type="checkbox" 
                           name="categories[]" 
                           value="{{ $category->id }}" 
                           {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                           style="margin-right: 0.75rem; width: 1rem; height: 1rem; cursor: pointer;">
                    <span style="font-size: 0.95rem;">{{ $category->name }}</span>
                </label>
            </div>
        @endforeach
    </div>
    @error('categories')
        <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
    @enderror
    <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">
        Select one or more categories from the list above
    </p>
</div>
            <!-- Buttons -->
            <div style="display: flex; gap: 1rem;">
                <button type="submit"
                        style="background: #2563eb; 
                               color: white; 
                               padding: 0.75rem 1.5rem; 
                               border-radius: 0.375rem; 
                               border: none; 
                               font-weight: 600; 
                               cursor: pointer;">
                    Update Article
                </button>
                <a href="{{ route('admin.articles.show', $article) }}"
                   style="background: #f3f4f6; 
                          color: #374151; 
                          padding: 0.75rem 1.5rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;
                          display: inline-flex;
                          align-items: center;">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection