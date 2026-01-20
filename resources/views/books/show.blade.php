@extends('layouts.app')

@section('title', $book->title)

@section('content')
<style>
    .page-header {
        background: var(--white);
        padding: 4rem 2rem 3rem;
        text-align: center;
        border-bottom: 2px solid var(--primary);
    }
    
    .page-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .page-title {
        font-size: 4rem;
        color: var(--primary);
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    
    .page-subtitle {
        font-size: 1.25rem;
        color: var(--text-light);
        margin-bottom: 2rem;
    }
    
    .page-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        justify-content: center;
    }
    
    .content-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }
    
    .book-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    
    .book-content {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
    }
    
    .content-header {
        margin-bottom: 2rem;
    }
    
    .content-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .book-cover-large {
        width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        background: var(--secondary);
        padding: 2rem;
    }
    
    .cover-placeholder {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 6rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .book-body {
        line-height: 1.8;
        color: var(--text);
        font-size: 1.125rem;
        white-space: pre-line;
    }
    
    .book-body p {
        margin-bottom: 1.5rem;
    }
    
    .book-sidebar {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
    }
    
    .sidebar-section {
        margin-bottom: 2rem;
    }
    
    .sidebar-section:last-child {
        margin-bottom: 0;
    }
    
    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .info-item {
        margin-bottom: 1.25rem;
    }
    
    .info-label {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 0.25rem;
        display: block;
    }
    
    .info-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary);
    }
    
    .info-value.empty {
        color: var(--text-light);
        font-style: italic;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: 2px solid;
        border-radius: 4px;
    }
    
    .status-published {
        background: #d1fae5;
        border-color: #059669;
        color: #065f46;
    }
    
    .status-draft {
        background: #f3f4f6;
        border-color: #6b7280;
        color: #374151;
    }
    
    .status-pending {
        background: #fef3c7;
        border-color: #f59e0b;
        color: #92400e;
    }
    
    .status-rejected {
        background: #fee2e2;
        border-color: #dc2626;
        color: #991b1b;
    }
    
    .categories-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .category-tag {
        padding: 0.5rem 1rem;
        background: var(--white);
        border: 2px solid var(--primary);
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-radius: 0.5rem;
        transition: all 0.3s;
    }
    
    .category-tag:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .btn-edit {
        padding: 0.75rem 2rem;
        background: var(--primary);
        color: var(--white);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-edit:hover {
        background: var(--white);
        color: var(--primary);
    }
    
    .btn-delete {
        padding: 0.75rem 2rem;
        background: #dc2626;
        color: var(--white);
        border: 2px solid #dc2626;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-delete:hover {
        background: var(--white);
        color: #dc2626;
    }
    
    .btn-back {
        padding: 0.75rem 2rem;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.85rem;
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
        .page-title {
            font-size: 2.5rem;
        }
        
        .book-grid {
            grid-template-columns: 1fr;
        }
        
        .page-actions {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">{{ $book->title }}</h1>
        <p class="page-subtitle">Book Details</p>
        
        <div class="page-actions">
            <a href="{{ route('books.index') }}" class="btn-back">Back to Books</a>
            @auth
                @if(Auth::id() === $book->user_id)
                    <a href="{{ route('books.edit', $book) }}" class="btn-edit">Edit Book</a>
                @endif
            @endauth
        </div>
    </div>
</div>

<div class="content-section">
    <div class="book-grid">
        <!-- Book Content -->
        <div class="book-content">
            <div class="content-header">
                <h2 class="content-title">Book Description</h2>
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                         alt="{{ $book->title }}" 
                         class="book-cover-large">
                @else
                    <div class="cover-placeholder">📚</div>
                @endif
            </div>
            
            <div class="book-body">
                {{ $book->description }}
            </div>
        </div>
        
        <!-- Book Information -->
        <div class="book-sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Book Information</h3>
                
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="status-badge status-{{ $book->status }}">
                        {{ ucfirst($book->status) }}
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Author</span>
                    <div class="info-value">{{ $book->author }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">ISBN</span>
                    <div class="info-value {{ empty($book->isbn) ? 'empty' : '' }}">
                        {{ $book->isbn ?? 'Not specified' }}
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Publisher</span>
                    <div class="info-value {{ empty($book->publisher) ? 'empty' : '' }}">
                        {{ $book->publisher ?? 'Not specified' }}
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Publication Year</span>
                    <div class="info-value {{ empty($book->publication_year) ? 'empty' : '' }}">
                        {{ $book->publication_year ?? 'Not specified' }}
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Pages</span>
                    <div class="info-value {{ empty($book->pages) ? 'empty' : '' }}">
                        {{ $book->pages ? number_format($book->pages) . ' pages' : 'Not specified' }}
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Added by</span>
                    <div class="info-value">{{ $book->user->name ?? 'Unknown' }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Published</span>
                    <div class="info-value">{{ $book->created_at->format('F d, Y') }}</div>
                </div>
            </div>
            
            @if($book->categories->count() > 0)
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Categories</h3>
                    <div class="categories-list">
                        @foreach($book->categories as $category)
                            <span class="category-tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Actions for book owner -->
            @auth
                @if(Auth::id() === $book->user_id)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Your Actions</h3>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @if($book->status === 'draft')
                                <form method="POST" action="{{ route('books.update', $book) }}" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="pending">
                                    <input type="hidden" name="title" value="{{ $book->title }}">
                                    <input type="hidden" name="author" value="{{ $book->author }}">
                                    <input type="hidden" name="description" value="{{ $book->description }}">
                                    <input type="hidden" name="categories[]" value="{{ $book->categories->first()->id ?? '' }}">
                                    <button type="submit" class="btn-edit" style="width: 100%;">Submit for Review</button>
                                </form>
                            @endif
                            
                            @if($book->status === 'pending')
                                <div style="padding: 1rem; background: #fef3c7; border-radius: 0.5rem; text-align: center;">
                                    <p style="margin: 0; color: #92400e; font-weight: 600;">Awaiting approval from admin</p>
                                </div>
                            @endif
                            
                            @if($book->status === 'rejected')
                                <div style="padding: 1rem; background: #fee2e2; border-radius: 0.5rem; text-align: center;">
                                    <p style="margin: 0; color: #991b1b; font-weight: 600;">Your book was rejected. Please edit and resubmit.</p>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('books.destroy', $book) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" style="width: 100%;">Delete Book</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick action forms confirmation
    const quickActionForms = document.querySelectorAll('.sidebar-section form');
    
    quickActionForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const status = this.querySelector('input[name="status"]');
            if (status && status.value === 'pending') {
                if (!confirm('Submit this book for review?')) {
                    e.preventDefault();
                }
            }
        });
    });
});
</script>
@endsection