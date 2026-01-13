@extends('layouts.app')

@section('title', 'Edit Book - Admin')

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
        <h1 style="font-size: 1.875rem; font-weight: bold;">Edit Book</h1>
        <p style="color: #6b7280;">Update book information</p>
    </div>

    <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="background: white; border-radius: 0.5rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <!-- Title -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Title</label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title', $book->title) }}"
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
            <div style="margin-bottom: 1.5rem;">
                <a href="{{ URL::previous() }}"
                style="background: #f3f4f6; 
                        color: #374151; 
                        padding: 0.5rem 1rem; 
                        border-radius: 0.375rem; 
                        text-decoration: none; 
                        font-weight: 600;
                        display: inline-block;
                        margin-bottom: 1rem;">
                    Back
                </a>
            </div>

            <!-- Author -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Author</label>
                <input type="text" 
                       name="author" 
                       value="{{ old('author', $book->author) }}"
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
                       value="{{ old('isbn', $book->isbn) }}"
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
                       value="{{ old('publisher', $book->publisher) }}"
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
                       value="{{ old('publication_year', $book->publication_year) }}"
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
                       value="{{ old('pages', $book->pages) }}"
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
                                 font-size: 1rem;">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Current Cover Image -->
            @if($book->cover_image)
                <div style="margin-bottom: 1rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Current Cover</div>
                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                         alt="Current cover image"
                         style="width: 150px; 
                                height: 200px; 
                                object-fit: cover; 
                                border-radius: 0.375rem;">
                </div>
            @endif

            <!-- Cover Image -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">
                    {{ $book->cover_image ? 'Change Cover Image' : 'Cover Image (Optional)' }}
                </label>
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
                    <option value="draft" {{ old('status', $book->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ old('status', $book->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ old('status', $book->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ old('status', $book->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Categories -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Categories</label>
                <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    @foreach($categories as $category)
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}"
                                   {{ in_array($category->id, old('categories', $book->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span>{{ $category->name }}</span>
                        </label>
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
                    Update Book
                </button>
                <a href="{{ route('admin.books.show', $book) }}"
                   style="background: #f3f4f6; 
                          color: #374151; 
                          padding: 0.75rem 1.5rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection