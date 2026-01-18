@extends('layouts.app')

@section('title', $book->title . ' - Admin')

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
    
    .book-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-item {
        text-align: center;
        padding: 1.5rem;
        background: var(--secondary);
        border-radius: 0.5rem;
        border: 1px solid var(--border);
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
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
        
        .book-stats {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">{{ $book->title }}</h1>
        <p class="page-subtitle">Book Details - Admin View</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.books.index') }}" class="btn-back">Back to Books</a>
        </div>
    </div>
</div>

<div class="content-section">
    <!-- Book Stats (Optional) -->
    @php
        // Example stats - you can customize these based on your actual data
        $stats = [
            ['value' => $book->views_count ?? '0', 'label' => 'Views'],
            ['value' => $book->likes_count ?? '0', 'label' => 'Likes'],
            ['value' => $book->comments_count ?? '0', 'label' => 'Comments'],
            ['value' => $book->downloads_count ?? '0', 'label' => 'Downloads'],
        ];
    @endphp
    
    <div class="book-stats">
        @foreach($stats as $stat)
            <div class="stat-item">
                <div class="stat-value">{{ $stat['value'] }}</div>
                <div class="stat-label">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>
    
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
                    <span class="info-label">Created</span>
                    <div class="info-value">{{ $book->created_at->format('F d, Y') }}</div>
                    <div style="font-size: 0.95rem; color: var(--text-light);">{{ $book->created_at->format('g:i A') }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Last Updated</span>
                    <div class="info-value">{{ $book->updated_at->format('F d, Y') }}</div>
                    <div style="font-size: 0.95rem; color: var(--text-light);">{{ $book->updated_at->format('g:i A') }}</div>
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
            
          
            
            <!-- Quick Actions -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Quick Actions</h3>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @if($book->status === 'draft')
                        <form method="POST" action="{{ route('admin.books.update', $book) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn-edit" style="width: 100%;">Submit for Review</button>
                        </form>
                    @endif
                    
                    @if($book->status === 'pending')
                        <form method="POST" action="{{ route('admin.books.update', $book) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="published">
                            <button type="submit" class="btn-edit" style="width: 100%; background: #059669; border-color: #059669;">Publish Now</button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.books.update', $book) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn-edit" style="width: 100%; background: #dc2626; border-color: #dc2626;">Reject</button>
                        </form>
                    @endif
                    
                    @if($book->status === 'published')
                        <form method="POST" action="{{ route('admin.books.update', $book) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="draft">
                            <button type="submit" class="btn-edit" style="width: 100%;">Move to Draft</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick action forms confirmation
    const quickActionForms = document.querySelectorAll('.sidebar-section form');
    
    quickActionForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const status = this.querySelector('input[name="status"]').value;
            let message = '';
            
            switch(status) {
                case 'pending':
                    message = 'Submit this book for review?';
                    break;
                case 'published':
                    message = 'Publish this book now?';
                    break;
                case 'rejected':
                    message = 'Reject this book?';
                    break;
                case 'draft':
                    message = 'Move this book to draft?';
                    break;
            }
            
            if (message && !confirm(message)) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection