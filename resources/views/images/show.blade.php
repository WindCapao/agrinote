@extends('layouts.app')

@section('title', $image->title . ' - Contently')

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
        font-size: 3rem;
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
        flex-wrap: wrap;
    }
    
    .content-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }
    
    .image-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }
    
    .image-display {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
    }
    
    .main-image {
        max-width: 100%;
        max-height: 600px;
        object-fit: contain;
        border-radius: 0.5rem;
        border: 1px solid var(--border);
    }
    
    .image-info {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
    }
    
    .info-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .info-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .info-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .image-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    
    .image-photographer {
        font-size: 1.25rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
        font-style: italic;
    }
    
    .image-description {
        line-height: 1.8;
        font-size: 1.1rem;
        color: var(--text);
        margin-bottom: 1.5rem;
    }
    
    .image-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .meta-item {
        background: var(--secondary);
        padding: 1rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border);
    }
    
    .meta-label {
        font-size: 0.85rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }
    
    .meta-value {
        font-weight: 600;
        color: var(--primary);
        font-size: 1.125rem;
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
        text-decoration: none;
    }
    
    .category-tag:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .license-info {
        background: #f8f9fa;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid var(--border);
        margin-top: 1rem;
    }
    
    .license-label {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }
    
    .license-description {
        font-size: 0.9rem;
        color: var(--text-light);
        line-height: 1.5;
    }
    
    .author-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.5rem;
    }
    
    .author-details {
        flex: 1;
    }
    
    .author-name {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }
    
    .author-stats {
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .btn-primary {
        padding: 0.75rem 2rem;
        background: var(--primary);
        color: var(--white);
        border: 2px solid var(--primary);
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-primary:hover {
        background: var(--white);
        color: var(--primary);
    }
    
    .btn-secondary {
        padding: 0.75rem 2rem;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-secondary:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .btn-edit {
        padding: 0.75rem 2rem;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-edit:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .btn-delete {
        padding: 0.75rem 2rem;
        background: #dc2626;
        color: var(--white);
        border: 2px solid #dc2626;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-delete:hover {
        background: var(--white);
        color: #dc2626;
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
        margin-bottom: 1rem;
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
    
    .related-images {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 2px solid var(--border);
    }
    
    .related-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 2rem;
        text-align: center;
        font-family: 'Playfair Display', serif;
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    
    .related-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        overflow: hidden;
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
    }
    
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        border-color: var(--accent);
    }
    
    .related-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid var(--border);
    }
    
    .related-content {
        padding: 1.5rem;
    }
    
    .related-image-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .related-image-photographer {
        font-size: 0.9rem;
        color: var(--text-light);
        font-style: italic;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .image-details {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .image-title {
            font-size: 2rem;
        }
        
        .page-actions {
            flex-direction: column;
            align-items: center;
        }
        
        .image-meta-grid {
            grid-template-columns: 1fr;
        }
        
        .related-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">{{ $image->title }}</h1>
        <p class="page-subtitle">Image Details</p>
        
        <div class="page-actions">
            <a href="{{ route('images.index') }}" class="btn-secondary">Back to Gallery</a>
            
            @auth
                @if(auth()->user()->id === $image->user_id || auth()->user()->isAdmin())
                    <a href="{{ route('images.edit', $image) }}" class="btn-edit">Edit Image</a>
                @endif
                
                @if(auth()->user()->isAdmin())
                    <form method="POST" 
                          action="{{ route('images.destroy', $image) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this image?')" 
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete Image</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>

<div class="content-section">
    <!-- Image Status (only show to uploader or admin) -->
    @auth
        @if(auth()->user()->id === $image->user_id || auth()->user()->isAdmin())
            @if($image->status !== 'published')
                <div style="text-align: center; margin-bottom: 2rem;">
                    <span class="status-badge status-{{ $image->status }}">
                        {{ ucfirst($image->status) }}
                    </span>
                    @if($image->status === 'pending')
                        <p style="color: var(--text-light); margin-top: 0.5rem;">
                            This image is awaiting admin approval
                        </p>
                    @endif
                </div>
            @endif
        @endif
    @endauth

    <div class="image-details">
        <!-- Image Display -->
        <div class="image-display">
            <img src="{{ asset('storage/' . $image->image_path) }}" 
                 alt="{{ $image->title }}" 
                 class="main-image">
        </div>
        
        <!-- Image Information -->
        <div class="image-info">
            <!-- Title & Photographer -->
            <div class="info-section">
                <h1 class="image-title">{{ $image->title }}</h1>
                @if($image->photographer)
                    <div class="image-photographer">by {{ $image->photographer }}</div>
                @endif
                
                @if($image->description)
                    <div class="image-description">
                        {{ nl2br(e($image->description)) }}
                    </div>
                @endif
            </div>
            
            <!-- Image Metadata -->
            <div class="info-section">
                <h3 class="info-title">Image Details</h3>
                <div class="image-meta-grid">
                    @if($image->width && $image->height)
                        <div class="meta-item">
                            <div class="meta-label">Dimensions</div>
                            <div class="meta-value">{{ $image->width }} × {{ $image->height }}</div>
                        </div>
                    @endif
                    
                    @if($image->file_size)
                        <div class="meta-item">
                            <div class="meta-label">File Size</div>
                            <div class="meta-value">{{ $image->getFileSizeFormatted() }}</div>
                        </div>
                    @endif
                    
                    <div class="meta-item">
                        <div class="meta-label">Uploaded</div>
                        <div class="meta-value">{{ $image->created_at->format('M d, Y') }}</div>
                    </div>
                    
                    @if($image->license)
                        <div class="meta-item">
                            <div class="meta-label">License</div>
                            <div class="meta-value">{{ $image->license }}</div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Categories -->
            @if($image->categories->count() > 0)
                <div class="info-section">
                    <h3 class="info-title">Categories</h3>
                    <div class="categories-list">
                        @foreach($image->categories as $category)
                            <a href="{{ route('images.index', ['category' => $category->id]) }}" 
                               class="category-tag">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Uploader Info -->
            <div class="info-section">
                <h3 class="info-title">Uploaded By</h3>
                <div class="author-info">
                    <div class="author-avatar">
                        {{ strtoupper(substr($image->user->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="author-details">
                        <div class="author-name">{{ $image->user->name ?? 'Anonymous' }}</div>
                        <div class="author-stats">
                            @if($image->user)
                                Member since {{ $image->user->created_at->format('M Y') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- License Information -->
            @if($image->license)
                <div class="license-info">
                    <div class="license-label">{{ $image->license }}</div>
                    @if($image->license === 'CC BY')
                        <div class="license-description">This work is licensed under a Creative Commons Attribution 4.0 International License.</div>
                    @elseif($image->license === 'CC BY-SA')
                        <div class="license-description">This work is licensed under a Creative Commons Attribution-ShareAlike 4.0 International License.</div>
                    @elseif($image->license === 'CC0')
                        <div class="license-description">This work has been dedicated to the public domain.</div>
                    @else
                        <div class="license-description">Please respect the copyright and licensing terms of this image.</div>
                    @endif
                </div>
            @endif
        </div>
    </div>
    
    <!-- Related Images -->
    @if($relatedImages->count() > 0)
        <div class="related-images">
            <h2 class="related-title">Related Images</h2>
            <div class="related-grid">
                @foreach($relatedImages as $relatedImage)
                    <a href="{{ route('images.show', $relatedImage) }}" class="related-card">
                        <img src="{{ asset('storage/' . $relatedImage->image_path) }}" 
                             alt="{{ $relatedImage->title }}" 
                             class="related-image">
                        <div class="related-content">
                            <h3 class="related-image-title">{{ $relatedImage->title }}</h3>
                            @if($relatedImage->photographer)
                                <div class="related-image-photographer">by {{ $relatedImage->photographer }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    
    deleteForms.forEach(form => {
        const button = form.querySelector('button[type="submit"]');
        if (button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this image? This action cannot be undone.')) {
                    form.submit();
                }
            });
        }
    });
});
</script>
@endsection