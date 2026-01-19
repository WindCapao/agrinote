@extends('layouts.app')

@section('title', 'My Content - Contently')

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
    
    .content-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }
    
    .tabs-nav {
        display: flex;
        gap: 0;
        border-bottom: 2px solid var(--border);
        margin-bottom: 3rem;
        overflow-x: auto;
    }
    
    .tab-button {
        padding: 1rem 2rem;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--text-light);
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }
    
    .tab-button:hover {
        color: var(--primary);
    }
    
    .tab-button.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .status-section {
        margin-bottom: 3rem;
    }
    
    .status-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
    }
    
    .status-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }
    
    .status-count {
        background: var(--primary);
        color: var(--white);
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 0.9rem;
    }
    
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .content-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        overflow: hidden;
        transition: all 0.3s;
    }
    
    .content-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        border-color: var(--accent);
    }
    
    .card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid var(--border);
    }
    
    .card-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 3rem;
        border-bottom: 1px solid var(--border);
    }
    
    .card-content {
        padding: 1.5rem;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    
    .card-meta {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }
    
    .card-excerpt {
        font-size: 0.95rem;
        color: var(--text);
        line-height: 1.6;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .card-actions {
        display: flex;
        gap: 0.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }
    
    .btn-edit,
    .btn-delete,
    .btn-view {
        padding: 0.5rem 1rem;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        transition: all 0.3s;
        display: inline-block;
        border: 2px solid;
        font-family: inherit;
        text-decoration: none;
        line-height: 1.5;
        min-height: 36px;
        box-sizing: border-box;
        border-radius: 0.25rem;
        cursor: pointer;
        text-align: center;
    }
    
    .btn-view {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        flex: 1;
    }
    
    .btn-view:hover {
        background: var(--white);
        color: var(--primary);
    }
    
    .btn-edit {
        background: var(--white);
        color: var(--primary);
        border-color: var(--primary);
        flex: 1;
    }
    
    .btn-edit:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .btn-delete {
        background: #dc2626;
        color: var(--white);
        border-color: #dc2626);
    }
    
    .btn-delete:hover {
        background: var(--white);
        color: #dc2626;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--secondary);
        border: 2px dashed var(--border);
        border-radius: 0.75rem;
    }
    
    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .empty-title {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-family: 'Playfair Display', serif;
    }
    
    .empty-text {
        color: var(--text-light);
        margin-bottom: 1.5rem;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }
    
    .status-published {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-draft {
        background: #f3f4f6;
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
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .tabs-nav {
            flex-direction: column;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">My Content</h1>
        <p class="page-subtitle">Manage your articles, books, and images</p>
    </div>
</div>

<div class="content-section">
    <!-- Tabs Navigation -->
    <div class="tabs-nav">
        <button class="tab-button active" data-tab="articles">
            Articles ({{ $articles->flatten()->count() }})
        </button>
        <button class="tab-button" data-tab="books">
            Books ({{ $books->flatten()->count() }})
        </button>
        <button class="tab-button" data-tab="images">
            Images ({{ $images->flatten()->count() }})
        </button>
    </div>
    
    <!-- Articles Tab -->
    <div class="tab-content active" id="articles">
        @php
            $statuses = ['draft' => 'Drafts', 'pending' => 'Pending Approval', 'published' => 'Published', 'rejected' => 'Rejected'];
        @endphp
        
        @foreach($statuses as $status => $label)
            @if($articles->has($status) && $articles[$status]->count() > 0)
                <div class="status-section">
                    <div class="status-header">
                        <h2 class="status-title">{{ $label }}</h2>
                        <span class="status-count">{{ $articles[$status]->count() }}</span>
                    </div>
                    
                    <div class="content-grid">
                        @foreach($articles[$status] as $article)
                            <div class="content-card">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                         alt="{{ $article->title }}" 
                                         class="card-image">
                                @else
                                    <div class="card-placeholder"></div>
                                @endif
                                
                                <div class="card-content">
                                    <span class="status-badge status-{{ $status }}">{{ ucfirst($status) }}</span>
                                    <h3 class="card-title">{{ $article->title }}</h3>
                                    <div class="card-meta">
                                        Created: {{ $article->created_at->format('M d, Y') }}
                                    </div>
                                    <p class="card-excerpt">
                                        {{ Str::limit(strip_tags($article->content), 120) }}
                                    </p>
                                    
                                    <div class="card-actions">
                                        <a href="{{ route('articles.show', $article) }}" class="btn-view">View</a>
                                        <a href="{{ route('articles.edit', $article) }}" class="btn-edit">Edit</a>
                                        <form method="POST" 
                                              action="{{ route('articles.destroy', $article) }}" 
                                              onsubmit="return confirm('Delete this article?')"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        
        @if($articles->flatten()->count() === 0)
            <div class="empty-state">
                <h3 class="empty-title">No Articles Yet</h3>
                <p class="empty-text">Start writing your first article</p>
                <a href="{{ route('articles.create') }}" class="btn-view">Create Article</a>
            </div>
        @endif
    </div>
    
    <!-- Books Tab -->
    <div class="tab-content" id="books">
        @foreach($statuses as $status => $label)
            @if($books->has($status) && $books[$status]->count() > 0)
                <div class="status-section">
                    <div class="status-header">
                        <h2 class="status-title">{{ $label }}</h2>
                        <span class="status-count">{{ $books[$status]->count() }}</span>
                    </div>
                    
                    <div class="content-grid">
                        @foreach($books[$status] as $book)
                            <div class="content-card">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="card-image">
                                @else
                                    <div class="card-placeholder"></div>
                                @endif
                                
                                <div class="card-content">
                                    <span class="status-badge status-{{ $status }}">{{ ucfirst($status) }}</span>
                                    <h3 class="card-title">{{ $book->title }}</h3>
                                    <div class="card-meta">
                                        by {{ $book->author }} • Created: {{ $book->created_at->format('M d, Y') }}
                                    </div>
                                    <p class="card-excerpt">
                                        {{ Str::limit($book->description, 120) }}
                                    </p>
                                    
                                    <div class="card-actions">
                                        <a href="{{ route('books.show', $book) }}" class="btn-view">View</a>
                                        <a href="{{ route('books.edit', $book) }}" class="btn-edit">Edit</a>
                                        <form method="POST" 
                                              action="{{ route('books.destroy', $book) }}" 
                                              onsubmit="return confirm('Delete this book?')"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        
        @if($books->flatten()->count() === 0)
            <div class="empty-state">
                <h3 class="empty-title">No Books Yet</h3>
                <p class="empty-text">Add your first book to the collection</p>
                <a href="{{ route('books.create') }}" class="btn-view">Add Book</a>
            </div>
        @endif
    </div>
    
    <!-- Images Tab -->
    <div class="tab-content" id="images">
        @foreach($statuses as $status => $label)
            @if($images->has($status) && $images[$status]->count() > 0)
                <div class="status-section">
                    <div class="status-header">
                        <h2 class="status-title">{{ $label }}</h2>
                        <span class="status-count">{{ $images[$status]->count() }}</span>
                    </div>
                    
                    <div class="content-grid">
                        @foreach($images[$status] as $image)
                            <div class="content-card">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $image->title }}" 
                                     class="card-image">
                                
                                <div class="card-content">
                                    <span class="status-badge status-{{ $status }}">{{ ucfirst($status) }}</span>
                                    <h3 class="card-title">{{ $image->title }}</h3>
                                    <div class="card-meta">
                                        @if($image->photographer)
                                            by {{ $image->photographer }} • 
                                        @endif
                                        {{ $image->created_at->format('M d, Y') }}
                                    </div>
                                    @if($image->description)
                                        <p class="card-excerpt">
                                            {{ Str::limit($image->description, 120) }}
                                        </p>
                                    @endif
                                    
                                    <div class="card-actions">
                                        <a href="{{ route('images.show', $image) }}" class="btn-view">View</a>
                                        <a href="{{ route('images.edit', $image) }}" class="btn-edit">Edit</a>
                                        <form method="POST" 
                                              action="{{ route('images.destroy', $image) }}" 
                                              onsubmit="return confirm('Delete this image?')"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        
        @if($images->flatten()->count() === 0)
            <div class="empty-state">
                <h3 class="empty-title">No Images Yet</h3>
                <p class="empty-text">Upload your first image</p>
                <a href="{{ route('images.create') }}" class="btn-view">Upload Image</a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });
});
</script>
@endsection