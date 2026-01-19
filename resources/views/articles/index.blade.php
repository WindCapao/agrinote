@extends('layouts.app')

@section('title', 'Articles - Contently')

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
    
    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2.5rem;
    }
    
    .article-card {
        background: var(--white);
        border: 1px solid var(--border);
        transition: all 0.3s;
        display: block;
        text-decoration: none;
        color: inherit;
        overflow: hidden;
    }
    
    .article-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
        border-color: var(--accent);
    }
    
    .article-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        display: block;
    }
    
    .article-content {
        padding: 2rem;
    }
    
    .article-meta {
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
    
    .article-title {
        font-size: 1.75rem;
        margin-bottom: 1rem;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        line-height: 1.3;
    }
    
    .article-excerpt {
        font-size: 1rem;
        color: var(--text);
        line-height: 1.7;
        margin-bottom: 1.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .article-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border);
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .article-author {
        font-weight: 600;
    }
    
    .article-date {
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
        
        .articles-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">Articles</h1>
        <p class="page-subtitle">Explore our collection of thoughtfully written perspectives and insights</p>
        
        @auth
            <div class="page-actions">
                <a href="{{ route('articles.create') }}" class="btn">Write an Article</a>
            </div>
        @endauth
    </div>
</div>

<div class="content-section">
    @if($articles->count() > 0)
        <div class="articles-grid">
            @foreach($articles as $article)
                <a href="{{ route('articles.show', $article) }}" class="article-card">
                    @if($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                             alt="{{ $article->title }}" 
                             class="article-image">
                    @else
                        <div class="article-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">
                        
                        </div>
                    @endif
                    
                    <div class="article-content">
                        <div class="article-meta">
                            <span>Article</span>
                            @if($article->categories->count() > 0)
                                <span>•</span>
                                <span>{{ $article->categories->first()->name }}</span>
                            @endif
                        </div>
                        
                        <h2 class="article-title">{{ $article->title }}</h2>
                        
                        <p class="article-excerpt">
                            {{ Str::limit(strip_tags($article->content), 150) }}
                        </p>
                        
                        @if($article->categories->count() > 1)
                            <div class="categories-tags">
                                @foreach($article->categories->skip(1) as $category)
                                    <span class="category-tag">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="article-footer">
                            <span class="article-author">{{ $article->user->name ?? 'Anonymous' }}</span>
                            <span class="article-date">{{ $article->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="pagination">
            {{ $articles->links() }}
        </div>
    @else
        <div class="empty-state">
            <h2 class="empty-title">No Articles Yet</h2>
            <p class="empty-text">Be the first to share your thoughts and insights with the community.</p>
            @auth
                <a href="{{ route('articles.create') }}" class="btn">Write the First Article</a>
            @else
                <a href="{{ route('login') }}" class="btn">Login to Write</a>
            @endauth
        </div>
    @endif
</div>
@endsection