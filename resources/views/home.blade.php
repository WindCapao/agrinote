@extends('layouts.app')

@section('title', 'Home - Contently')

@section('content')
<style>
    .hero {
        background: var(--white);
        padding: 6rem 2rem 4rem;
        text-align: center;
        border-bottom: 1px solid var(--border);
    }
    
    .hero-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .hero h1 {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: var(--primary);
        letter-spacing: -0.02em;
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-light);
        margin-bottom: 2.5rem;
        line-height: 1.8;
    }
    
    .section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 5rem 2rem;
    }
    
    .section-header {
        margin-bottom: 3rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--primary);
    }
    
    .section-title {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
    }
    
    .section-subtitle {
        color: var(--text-light);
        font-size: 1.1rem;
    }
    
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    
    .gallery-item {
        background: var(--white);
        border: 1px solid var(--border);
        transition: all 0.3s;
        display: block;
        text-decoration: none;
        color: inherit;
    }
    
    .gallery-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        border-color: var(--accent);
    }
    
    .gallery-image {
        width: 100%;
        height: 280px;
        object-fit: cover;
        display: block;
    }
    
    .gallery-content {
        padding: 1.5rem;
    }
    
    .gallery-type {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--accent);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .gallery-title {
        font-size: 1.35rem;
        margin-bottom: 0.75rem;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
        font-weight: 700;
    }
    
    .gallery-meta {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 0.75rem;
    }
    
    .gallery-excerpt {
        font-size: 0.95rem;
        color: var(--text);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .cta-section {
        background: var(--primary);
        color: var(--white);
        padding: 5rem 2rem;
        text-align: center;
        margin-top: 4rem;
    }
    
    .cta-content {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .cta-title {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        color: var(--white);
    }
    
    .cta-text {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        color: rgba(255,255,255,0.9);
    }
    
    .btn-cta {
        padding: 1rem 2.5rem;
        background: var(--accent);
        color: var(--white);
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        transition: all 0.3s;
        border: 2px solid var(--accent);
        display: inline-block;
    }
    
    .btn-cta:hover {
        background: transparent;
        color: var(--accent);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-light);
    }
    
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    @media (max-width: 1024px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 640px) {
        .hero h1 {
            font-size: 2.5rem;
        }
        
        .gallery-grid {
            grid-template-columns: 1fr;
        }
        
        .cta-title {
            font-size: 2rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-container">
        <h1>Contently</h1>
        <p class="hero-subtitle">
            A platform where content meets curation.
        </p>
    </div>
</section>

<!-- Articles Section -->
@if($articles->count() > 0)
<section class="section">
    <div class="section-header">
        <h2 class="section-title">Latest Articles</h2>
        <p class="section-subtitle">Thoughtfully written perspectives and insights</p>
    </div>
    
    <div class="gallery-grid">
        @foreach($articles->take(3) as $article)
        <a href="{{ route('articles.show', $article) }}" class="gallery-item">
            @if($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                     alt="{{ $article->title }}" 
                     class="gallery-image">
            @else
                <div class="gallery-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
            @endif
            
            <div class="gallery-content">
                <div class="gallery-type">Article</div>
                <h3 class="gallery-title">{{ Str::limit($article->title, 60) }}</h3>
                <div class="gallery-meta">
                    By {{ $article->user->name ?? 'Unknown' }} • {{ $article->created_at->format('M d, Y') }}
                </div>
                <p class="gallery-excerpt">{{ Str::limit(strip_tags($article->content), 100) }}</p>
            </div>
        </a>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('articles.index') }}" class="btn">View All Articles</a>
    </div>
</section>
@endif

<!-- Books Section -->
@if($books->count() > 0)
<section class="section" style="background: var(--white);">
    <div class="section-header">
        <h2 class="section-title">Featured Books</h2>
        <p class="section-subtitle">Carefully selected literary works</p>
    </div>
    
    <div class="gallery-grid">
        @foreach($books->take(3) as $book)
        <a href="{{ route('books.show', $book) }}" class="gallery-item">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                     alt="{{ $book->title }}" 
                     class="gallery-image" style="object-fit: contain; background: #f9f9f9;">
            @else
                <div class="gallery-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></div>
            @endif
            
            <div class="gallery-content">
                <div class="gallery-type">Book</div>
                <h3 class="gallery-title">{{ Str::limit($book->title, 50) }}</h3>
                <div class="gallery-meta">
                    By {{ $book->author }} 
                    @if($book->publication_year)
                        • {{ $book->publication_year }}
                    @endif
                </div>
                <p class="gallery-excerpt">{{ Str::limit($book->description, 100) }}</p>
            </div>
        </a>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('books.index') }}" class="btn">View All Books</a>
    </div>
</section>
@endif

<!-- Images Section -->
@if($images->count() > 0)
<section class="section">
    <div class="section-header">
        <h2 class="section-title">Visual Collection</h2>
        <p class="section-subtitle">Stunning imagery and creative works</p>
    </div>
    
    <div class="gallery-grid">
        @foreach($images->take(3) as $image)
        <a href="{{ route('images.show', $image) }}" class="gallery-item">
            <img src="{{ asset('storage/' . $image->image_path) }}" 
                 alt="{{ $image->title }}" 
                 class="gallery-image">
            
            <div class="gallery-content">
                <div class="gallery-type">Image</div>
                <h3 class="gallery-title">{{ Str::limit($image->title, 50) }}</h3>
                @if($image->photographer)
                    <div class="gallery-meta">By {{ $image->photographer }}</div>
                @endif
                @if($image->description)
                    <p class="gallery-excerpt">{{ Str::limit($image->description, 100) }}</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('images.index') }}" class="btn">View Full Collection</a>
    </div>
</section>
@endif

<!-- Empty State -->
@if($articles->count() === 0 && $books->count() === 0 && $images->count() === 0)
<section class="section">
    <div class="empty-state">
        <div class="empty-state-icon">📚</div>
        <h2 style="font-size: 2rem; margin-bottom: 1rem;">Nothing Here Yet</h2>
        <p style="font-size: 1.1rem;">Be the first to contribute to our collection.</p>
    </div>
</section>
@endif

<!-- CTA Section -->
@guest
<section class="cta-section">
    <div class="cta-content">
        <h2 class="cta-title">Join Our Community</h2>
        <p class="cta-text">
            Share your stories, showcase your work, and connect with fellow creators. 
            Start contributing to our curated collection today.
        </p>
        <a href="{{ route('register') }}" class="btn-cta">Get Started</a>
    </div>
</section>
@endguest
@endSection