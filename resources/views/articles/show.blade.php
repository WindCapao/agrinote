@extends('layouts.app')

@section('title', $article->title . ' - Contently')

@section('content')
<style>
    .article-hero {
        background: var(--white);
        padding: 4rem 2rem 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .article-container {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .article-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    
    .article-title {
        font-size: 4rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }
    
    .article-meta-bar {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 1.5rem 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        margin-bottom: 2rem;
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .meta-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-light);
        font-weight: 600;
    }
    
    .meta-value {
        font-size: 0.95rem;
        color: var(--primary);
        font-weight: 600;
    }
    
    .article-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .article-featured-image {
        width: 100%;
        max-height: 600px;
        object-fit: cover;
        margin: 3rem 0;
        border: 1px solid var(--border);
    }
    
    .article-body {
        max-width: 900px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }
    
    .article-content {
        font-size: 1.15rem;
        line-height: 1.9;
        color: var(--text);
        margin-bottom: 3rem;
    }
    
    .article-content p {
        margin-bottom: 1.5rem;
    }
    
    .article-tags {
        padding: 2rem 0;
        border-top: 2px solid var(--border);
        border-bottom: 2px solid var(--border);
    }
    
    .tags-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-light);
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .tags-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .tag {
        padding: 0.5rem 1.25rem;
        background: var(--white);
        border: 2px solid var(--primary);
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s;
    }
    
    .tag:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .article-footer {
        max-width: 900px;
        margin: 3rem auto;
        padding: 3rem 2rem;
        background: var(--secondary);
        border: 1px solid var(--border);
    }
    
    .author-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .author-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }
    
    .author-details {
        flex: 1;
    }
    
    .author-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .author-name {
        font-size: 1.5rem;
        font-family: 'Playfair Display', serif;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }
    
    .author-email {
        color: var(--text-light);
        font-size: 0.9rem;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: 2px solid;
        margin-top: 1rem;
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
    
    .btn-edit,
.btn-delete,
.btn-back,
.btn-submit,
.btn-cancel,
.btn-view,
.btn-primary,
.btn-secondary {
    padding: 0.75rem 2rem;
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    transition: all 0.3s ease;
    display: inline-block;
    border: 2px solid;
    border-radius: 0.5rem;
    font-family: inherit;
    text-decoration: none;
    line-height: 1.5;
    min-height: 44px;
    box-sizing: border-box;
    cursor: pointer;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-edit {
    background: var(--white);
    color: var(--primary);
    border-color: var(--primary);
}

.btn-edit:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-delete {
    background: #dc2626;
    color: var(--white);
    border-color: #dc2626;
}

.btn-delete:hover {
    background: #b91c1c;
    border-color: #b91c1c;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220,38,38,0.3);
}

.btn-back,
.btn-secondary {
    background: var(--white);
    color: var(--primary);
    border-color: var(--primary);
}

.btn-back:hover,
.btn-secondary:hover {
    background: var(--secondary);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-submit,
.btn-primary {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.btn-submit:hover,
.btn-primary:hover {
    background: #000000;
    border-color: #000000;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.btn-cancel {
    background: var(--white);
    color: var(--primary);
    border-color: var(--primary);
}

.btn-cancel:hover {
    background: var(--secondary);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-view {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.btn-view:hover {
    background: #000000;
    border-color: #000000;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}
    
    @media (max-width: 768px) {
        .article-title {
            font-size: 2.5rem;
        }
        
        .article-meta-bar {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .article-actions {
            flex-direction: column;
        }
    }
</style>

<article>
    <!-- Article Hero -->
    <div class="article-hero">
        <div class="article-container">
            @if($article->categories->count() > 0)
                <div class="article-category">
                    {{ $article->categories->pluck('name')->join(' • ') }}
                </div>
            @endif
            
            <h1 class="article-title">{{ $article->title }}</h1>
            
            <div class="article-meta-bar">
                <div class="meta-item">
                    <span class="meta-label">Author</span>
                    <span class="meta-value">{{ $article->user->name ?? 'Anonymous' }}</span>
                </div>
                
                <div class="meta-item">
                    <span class="meta-label">Published</span>
                    <span class="meta-value">{{ $article->created_at->format('F d, Y') }}</span>
                </div>
                
                @if($article->updated_at->ne($article->created_at))
                    <div class="meta-item">
                        <span class="meta-label">Updated</span>
                        <span class="meta-value">{{ $article->updated_at->format('F d, Y') }}</span>
                    </div>
                @endif
            </div>
            
            <!-- Status Badge (only visible to author and admin) -->
            @if(auth()->check() && (auth()->id() === $article->user_id || auth()->user()->isAdmin()))
                <span class="status-badge status-{{ $article->status }}">
                    {{ ucfirst($article->status) }}
                </span>
            @endif
            
            <!-- Action Buttons (only for author and admin) -->
            @if(auth()->check() && (auth()->id() === $article->user_id || auth()->user()->isAdmin()))
                <div class="article-actions">
                    <a href="{{ route('articles.edit', $article) }}" class="btn-edit">Edit</a>
                    
                    <form method="POST" action="{{ route('articles.destroy', $article) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this article?')" 
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                    
                    <a href="{{ route('articles.index') }}" class="btn-back">Back to Articles</a>
                </div>
            @else
                <div class="article-actions">
                    <a href="{{ route('articles.index') }}" class="btn-back">Back to Articles</a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Featured Image -->
    @if($article->featured_image)
        <div class="article-container">
            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                 alt="{{ $article->title }}" 
                 class="article-featured-image">
        </div>
    @endif
    
    <!-- Article Body -->
    <div class="article-body">
        <div class="article-content">
            {!! nl2br(e($article->content)) !!}
        </div>
        
        <!-- Tags/Categories -->
        @if($article->categories->count() > 0)
            <div class="article-tags">
                <div class="tags-label">Filed Under</div>
                <div class="tags-list">
                    @foreach($article->categories as $category)
                        <span class="tag">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    <!-- Author Info -->
    <div class="article-footer">
        <div class="author-info">
            <div class="author-avatar">
                {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
            </div>
            <div class="author-details">
                <div class="author-label">Written By</div>
                <div class="author-name">{{ $article->user->name ?? 'Anonymous' }}</div>
                @if($article->user->email)
                    <div class="author-email">{{ $article->user->email }}</div>
                @endif
            </div>
        </div>
    </div>
</article>
@endsection