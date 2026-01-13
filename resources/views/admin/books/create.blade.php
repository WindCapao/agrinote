@extends('layouts.app')

@section('title', 'Create Book - Admin')

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
                Back to Books
            </a>
        </div>
        <h1 style="font-size: 1.875rem; font-weight: bold;">Create New Book</h1>
        <p style="color: #6b7280;">Add a new book to the system</p>
    </div>

    <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="background: white; border-radius: 0.5rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <!-- Title -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Title</label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title') }}"
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

            <!-- Author -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Author</label>
                <input type="text" 
                       name="author" 
                       value="{{ old('author') }}"
                       required
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('author')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- ISBN -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">ISBN (Optional)</label>
                <input type="text" 
                       name="isbn" 
                       value="{{ old('isbn') }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('isbn')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Publisher -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Publisher (Optional)</label>
                <input type="text" 
                       name="publisher" 
                       value="{{ old('publisher') }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('publisher')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Publication Year -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Publication Year (Optional)</label>
                <input type="number" 
                       name="publication_year" 
                       value="{{ old('publication_year') }}"
                       min="1000"
                       max="{{ date('Y') + 5 }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('publication_year')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Pages -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Pages (Optional)</label>
                <input type="number" 
                       name="pages" 
                       value="{{ old('pages') }}"
                       min="1"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('pages')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Description</label>
                <textarea name="description" 
                          rows="6"
                          required
                          style="width: 100%; 
                                 padding: 0.75rem; 
                                 border: 1px solid #d1d5db; 
                                 border-radius: 0.375rem; 
                                 font-size: 1rem;">{{ old('description') }}</textarea>
                @error('description')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Cover Image -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Cover Image (Optional)</label>
                <input type="file" 
                       name="cover_image"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('cover_image')
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
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
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
                    Create Book
                </button>
                <a href="{{ route('admin.books.index') }}"
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