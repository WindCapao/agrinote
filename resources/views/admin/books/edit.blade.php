@extends('layouts.app')

@section('title', 'Edit Book - Admin')

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
        min-height: 200px;
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
    
    .current-cover {
        margin-top: 1rem;
        padding: 1rem;
        background: var(--secondary);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
    }
    
    .current-cover img {
        max-width: 200px;
        height: auto;
        border-radius: 0.5rem;
        display: block;
    }
    
    .current-cover-label {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        font-weight: 600;
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
    
    .cover-upload {
        border: 3px dashed var(--border);
        padding: 2rem;
        text-align: center;
        background: var(--secondary);
        transition: all 0.3s;
        cursor: pointer;
        margin-top: 0.5rem;
    }
    
    .cover-upload:hover {
        border-color: var(--accent);
        background: var(--white);
    }
    
    .upload-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.3;
    }
    
    .upload-text {
        font-size: 1rem;
        color: var(--text-light);
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
        <h1 class="form-title">Edit Book</h1>
        <p class="form-subtitle">Update book details and settings</p>
    </div>
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <a href="{{ route('admin.books.show', $book) }}" class="btn-back">Back to Book Details</a>
    </div>
    
    <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-card">
            <!-- Current Book Info -->
            <div class="form-section" style="background: var(--secondary); padding: 1.5rem; border-radius: 0.5rem;">
                <div style="font-weight: 600; color: var(--primary); margin-bottom: 0.5rem;">Currently Editing:</div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             alt="{{ $book->title }}"
                             style="width: 60px; height: 80px; object-fit: cover; border-radius: 0.25rem;">
                    @else
                        <div style="width: 60px; height: 80px; background: var(--primary); color: var(--white); display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; font-size: 1.5rem;">
                            📚
                        </div>
                    @endif
                    <div>
                        <div style="font-size: 1.25rem; font-weight: 600; color: var(--primary);">{{ $book->title }}</div>
                        <div style="color: var(--text-light);">by {{ $book->author }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Title -->
            <div class="form-section">
                <label class="form-label">Book Title</label>
                <input type="text" 
                       name="title" 
                       class="form-input"
                       value="{{ old('title', $book->title) }}"
                       placeholder="Enter the book title..."
                       required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Author -->
            <div class="form-section">
                <label class="form-label">Author</label>
                <input type="text" 
                       name="author" 
                       class="form-input"
                       value="{{ old('author', $book->author) }}"
                       placeholder="Enter the author's name..."
                       required>
                @error('author')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- ISBN & Publisher -->
            <div class="form-section form-grid">
                <div>
                    <label class="form-label">ISBN (Optional)</label>
                    <input type="text" 
                           name="isbn" 
                           class="form-input"
                           value="{{ old('isbn', $book->isbn) }}"
                           placeholder="ISBN-13 format (e.g., 978-3-16-148410-0)">
                    @error('isbn')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">Publisher (Optional)</label>
                    <input type="text" 
                           name="publisher" 
                           class="form-input"
                           value="{{ old('publisher', $book->publisher) }}"
                           placeholder="Publisher name...">
                    @error('publisher')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Publication Year & Pages -->
            <div class="form-section form-grid">
                <div>
                    <label class="form-label">Publication Year (Optional)</label>
                    <input type="number" 
                           name="publication_year" 
                           class="form-input"
                           value="{{ old('publication_year', $book->publication_year) }}"
                           min="1000" 
                           max="{{ date('Y') + 5 }}"
                           placeholder="{{ date('Y') }}">
                    @error('publication_year')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">Number of Pages (Optional)</label>
                    <input type="number" 
                           name="pages" 
                           class="form-input"
                           value="{{ old('pages', $book->pages) }}"
                           min="1"
                           placeholder="e.g., 320">
                    @error('pages')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Description -->
            <div class="form-section">
                <label class="form-label">Description</label>
                <textarea name="description" 
                          class="form-textarea"
                          placeholder="Describe the book, its themes, and why it's worth reading..."
                          required>{{ old('description', $book->description) }}</textarea>
                <div class="form-help">Minimum 100 characters required</div>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Current Cover Image -->
            @if($book->cover_image)
                <div class="form-section">
                    <label class="form-label">Current Cover</label>
                    <div class="current-cover">
                        <div class="current-cover-label">Current Book Cover</div>
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             alt="{{ $book->title }}">
                    </div>
                </div>
            @endif
            
            <!-- Change Cover Image -->
            <div class="form-section">
                <label class="form-label">{{ $book->cover_image ? 'Change Cover Image (Optional)' : 'Cover Image (Optional)' }}</label>
                <div class="cover-upload" onclick="document.getElementById('coverUpload').click()">
                    <div class="upload-icon">📚</div>
                    <div class="upload-text">Click to {{ $book->cover_image ? 'change' : 'upload' }} cover image</div>
                </div>
                <input type="file" 
                       name="cover_image" 
                       id="coverUpload"
                       class="form-file"
                       accept="image/jpeg,image/png,image/jpg"
                       style="display: none;">
                <div style="margin-top: 1rem; font-size: 0.95rem; color: var(--primary);" id="coverFileName">
                    {{ $book->cover_image ? 'No new file selected' : 'No file selected' }}
                </div>
                <div class="form-help">
                    @if($book->cover_image)
                        Leave empty to keep current image. 
                    @endif
                    JPEG, PNG, or JPG. Maximum file size: 2MB
                </div>
                @error('cover_image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Categories -->
            <div class="form-section">
                <label class="form-label">Categories</label>
                <div class="checkbox-group">
                    @php
                        $selectedCategories = old('categories', $book->categories->pluck('id')->toArray());
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
                <div class="form-help">Select one or more categories to organize the book</div>
                @error('categories')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Status -->
            <div class="form-section">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ old('status', $book->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ old('status', $book->status) === 'pending' ? 'selected' : '' }}>Pending Review</option>
                    <option value="published" {{ old('status', $book->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ old('status', $book->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <div class="form-help">As an admin, you can change the book status</div>
                @error('status')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-submit">Update Book</button>
            <a href="{{ route('admin.books.show', $book) }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const coverInput = document.getElementById('coverUpload');
    const coverFileName = document.getElementById('coverFileName');
    
    if (coverInput) {
        coverInput.addEventListener('change', function() {
            coverFileName.textContent = this.files[0]?.name || 'No file selected';
        });
    }
});
</script>
@endsection