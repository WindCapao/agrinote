@extends('layouts.app')

@section('title', 'Image Gallery - Contently')

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
    
    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2.5rem;
    }
    
    .image-card {
        background: var(--white);
        border: 1px solid var(--border);
        transition: all 0.3s;
        display: block;
        text-decoration: none;
        color: inherit;
        overflow: hidden;
    }
    
    .image-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
        border-color: var(--accent);
    }
    
    .image-container {
        width: 100%;
        height: 300px;
        position: relative;
        overflow: hidden;
    }
    
    .image-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .image-card:hover .image-preview {
        transform: scale(1.05);
    }
    
    .image-dimensions {
        position: absolute;
        bottom: 0.5rem;
        right: 0.5rem;
        background: rgba(0,0,0,0.7);
        color: var(--white);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .image-content {
        padding: 2rem;
    }
    
    .image-meta {
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
    
    .image-title {
        font-size: 1.75rem;
        margin-bottom: 1rem;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        line-height: 1.3;
    }
    
    .image-excerpt {
        font-size: 1rem;
        color: var(--text);
        line-height: 1.7;
        margin-bottom: 1.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .image-photographer {
        font-size: 0.9rem;
        color: var(--text-light);
        margin-bottom: 1rem;
        font-style: italic;
    }
    
    .image-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border);
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .image-uploader {
        font-weight: 600;
    }
    
    .image-date {
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
        margin-bottom: 1rem;
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
        
        .images-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">Image Gallery</h1>
        <p class="page-subtitle">Explore our collection of stunning visual creations</p>
        
        @auth
            <div class="page-actions">
                <a href="{{ route('images.create') }}" class="btn">Upload New Image</a>
            </div>
        @endauth
    </div>
</div>

<div class="content-section">
    @if($images->count() > 0)
        <div class="images-grid">
            @foreach($images as $image)
                <a href="{{ route('images.show', $image) }}" class="image-card">
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                             alt="{{ $image->title }}" 
                             class="image-preview">
                        @if($image->width && $image->height)
                            <div class="image-dimensions">{{ $image->width }} × {{ $image->height }}</div>
                        @endif
                    </div>
                    
                    <div class="image-content">
                        <div class="image-meta">
                            <span>Image</span>
                            @if($image->categories->count() > 0)
                                <span>•</span>
                                <span>{{ $image->categories->first()->name }}</span>
                            @endif
                        </div>
                        
                        <h2 class="image-title">{{ $image->title }}</h2>
                        
                        @if($image->photographer)
                            <div class="image-photographer">by {{ $image->photographer }}</div>
                        @endif
                        
                        @if($image->description)
                            <p class="image-excerpt">
                                {{ Str::limit($image->description, 120) }}
                            </p>
                        @endif
                        
                        @if($image->categories->count() > 1)
                            <div class="categories-tags">
                                @foreach($image->categories->skip(1) as $category)
                                    <span class="category-tag">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="image-footer">
                            <span class="image-uploader">{{ $image->user->name ?? 'Anonymous' }}</span>
                            <span class="image-date">{{ $image->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="pagination">
            {{ $images->links() }}
        </div>
    @else
        <div class="empty-state">
    
            <h2 class="empty-title">No Images Yet</h2>
            <p class="empty-text">Be the first to share your visual creations with the community.</p>
            @auth
                <a href="{{ route('images.create') }}" class="btn">Upload the First Image</a>
            @else
                <a href="{{ route('login') }}" class="btn">Login to Upload Images</a>
            @endauth
        </div>
    @endif
</div>
@endsection