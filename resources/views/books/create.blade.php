@extends('layouts.app')

@section('title', 'Add New Book - Contently')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Back button at the top -->
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('books.index') }}"
           style="background: #f3f4f6; 
                  color: #374151; 
                  padding: 0.5rem 1rem; 
                  border-radius: 0.375rem; 
                  text-decoration: none; 
                  font-weight: 600;
                  display: inline-block;">
            Back to Books
        </a>
    </div>

        <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 2rem;">Add New Book</h1>
    
    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Title -->
        <div style="margin-bottom: 1.5rem;">
            <label for="title" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Book Title <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   value="{{ old('title') }}" 
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
        
        <!-- Author -->
        <div style="margin-bottom: 1.5rem;">
            <label for="author" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Author <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" 
                   name="author" 
                   id="author" 
                   value="{{ old('author') }}" 
                   required
                   style="width: 100%; 
                          padding: 0.75rem; 
                          border: 1px solid #d1d5db; 
                          border-radius: 0.5rem;
                          font-size: 1rem;
                          @error('author') border-color: #dc2626; @enderror">
            @error('author')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
        </div>
        
        <!-- ISBN and Publisher Row -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
            <!-- ISBN -->
            <div>
                <label for="isbn" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    ISBN
                </label>
                <input type="text" 
                       name="isbn" 
                       id="isbn" 
                       value="{{ old('isbn') }}" 
                       placeholder="978-0-123456-78-9"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.5rem;
                              font-size: 1rem;">
                @error('isbn')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Publisher -->
            <div>
                <label for="publisher" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    Publisher
                </label>
                <input type="text" 
                       name="publisher" 
                       id="publisher" 
                       value="{{ old('publisher') }}" 
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.5rem;
                              font-size: 1rem;">
                @error('publisher')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <!-- Publication Year and Pages Row -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
            <!-- Publication Year -->
            <div>
                <label for="publication_year" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    Publication Year
                </label>
                <input type="number" 
                       name="publication_year" 
                       id="publication_year" 
                       value="{{ old('publication_year') }}" 
                       min="1000" 
                       max="{{ date('Y') + 1 }}"
                       placeholder="{{ date('Y') }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.5rem;
                              font-size: 1rem;">
                @error('publication_year')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Pages -->
            <div>
                <label for="pages" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                    Number of Pages
                </label>
                <input type="number" 
                       name="pages" 
                       id="pages" 
                       value="{{ old('pages') }}" 
                       min="1"
                       placeholder="350"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.5rem;
                              font-size: 1rem;">
                @error('pages')
                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <!-- Description -->
        <div style="margin-bottom: 1.5rem;">
            <label for="description" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Description <span style="color: #dc2626;">*</span>
            </label>
            <textarea name="description" 
                      id="description" 
                      rows="8" 
                      required
                      placeholder="Write a brief description of the book..."
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
            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">
                Minimum 50 characters required
            </p>
        </div>
        
        <!-- Cover Image -->
        <div style="margin-bottom: 1.5rem;">
            <label for="cover_image" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">
                Book Cover Image
            </label>
            <input type="file" 
                   name="cover_image" 
                   id="cover_image" 
                   accept="image/*"
                   style="width: 100%; 
                          padding: 0.75rem; 
                          border: 1px solid #d1d5db; 
                          border-radius: 0.5rem;
                          font-size: 1rem;
                          @error('cover_image') border-color: #dc2626; @enderror">
            @error('cover_image')
                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
            @enderror
            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">
                Accepted formats: JPEG, PNG, JPG. Max size: 2MB
            </p>
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
                Add Book
            </button>
            <a href="{{ route('books.index') }}" 
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
@endsection