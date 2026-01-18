@extends('layouts.app')

@section('title', 'Book Collection - Contently')

@section('content')
<style>
    .page-header {
        background: var(--white);
        padding: 5rem 2rem 3rem;
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
    }
    
    .content-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2.5rem;
    }
    
    .book-card {
        background: var(--white);
        border: 1px solid var(--border);
        transition: all 0.3s;
        display: block;
        text-decoration: none;
        color: inherit;
        overflow: hidden;
    }
    
    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
        border-color: var(--accent);
    }
    
    .book-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
    }
    
    .book-content {
        padding: 2rem;
    }
    
    .book-meta {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--accent);
        font-weight: 600;
    }
    
    .book-title {
        font-size: 1.75rem;
        margin-bottom: 1rem;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        line-height: 1.3;
    }
    
    .book-author {
        font-size: 1.1rem;
        color: var(--text-light);
        margin-bottom: 1rem;
        font-style: italic;
    }
    
    .book-excerpt {
        font-size: 1rem;
        color: var(--text);
        line-height: 1.7;
        margin-bottom: 1.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .book-details {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .book-detail {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .book-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border);
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .book-uploader {
        font-weight: 600;
    }
    
    .book-date {
        color: var(--text-light);
    }
    
    .categories-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .category-tag {
        padding: 0.25rem 0.75rem;
        background: var(--secondary);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1px solid var(--border);
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-radius: 4px;
    }
    
    .status-published {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-draft {
        background: #e5e7eb;
        color: #374151;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .empty-state {
        text-align: center;
        padding: 6rem 2rem;
    }
    
    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.2;
    }
    
    .empty-title {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .empty-text {
        color: var(--text-light);
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .pagination {
        margin-top: 4rem;
        display: flex;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .books-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">Book Collection</h1>
        <p class="page-subtitle">Discover and share literary gems from our community</p>
        
        @auth
            <div class="page-actions">
                <a href="{{ route('books.create') }}" class="btn">Add New Book</a>
            </div>
        @endauth
    </div>
</div>

<div class="content-section">
    @if($books->count() > 0)
        <div class="books-grid">
            @foreach($books as $book)
                <a href="{{ route('books.show', $book) }}" class="book-card">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             alt="{{ $book->title }}" 
                             class="book-image">
                    @else
                        <div class="book-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">
                            📚
                        </div>
                    @endif
                    
                    <div class="book-content">
                        <div class="book-meta">
                            <span>Book</span>
                            @if($book->categories->count() > 0)
                                <span>•</span>
                                <span>{{ $book->categories->first()->name }}</span>
                            @endif
                        </div>
                        
                        <h2 class="book-title">{{ $book->title }}</h2>
                        <div class="book-author">by {{ $book->author }}</div>
                        
                        <div class="book-details">
                            @if($book->publisher)
                                <div class="book-detail">
                                    <span>📖</span>
                                    <span>{{ $book->publisher }}</span>
                                </div>
                            @endif
                            @if($book->publication_year)
                                <div class="book-detail">
                                    <span>📅</span>
                                    <span>{{ $book->publication_year }}</span>
                                </div>
                            @endif
                            @if($book->pages)
                                <div class="book-detail">
                                    <span>📄</span>
                                    <span>{{ $book->pages }} pages</span>
                                </div>
                            @endif
                        </div>
                        
                        <p class="book-excerpt">
                            {{ Str::limit($book->description, 150) }}
                        </p>
                        
                        @if($book->categories->count() > 1)
                            <div class="categories-tags">
                                @foreach($book->categories->skip(1) as $category)
                                    <span class="category-tag">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="book-footer">
                            <span class="book-uploader">{{ $book->user->name ?? 'Anonymous' }}</span>
                            <span class="book-date">{{ $book->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="pagination">
            {{ $books->links() }}
        </div>
    @else
        <div class="empty-state">
            <h2 class="empty-title">No Books Yet</h2>
            <p class="empty-text">Be the first to share your literary discoveries with the community.</p>
            @auth
                <a href="{{ route('books.create') }}" class="btn">Add the First Book</a>
            @else
                <a href="{{ route('login') }}" class="btn">Login to Add Books</a>
            @endauth
        </div>
    @endif
</div>
@endsection