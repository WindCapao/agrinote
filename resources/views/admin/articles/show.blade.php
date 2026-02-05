@extends('layouts.app')

@section('title', $article->title . ' - Admin')

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
    
    .article-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    
    .article-content {
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
    
    .featured-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .article-body {
        line-height: 1.8;
        color: var(--text);
        font-size: 1.125rem;
    }
    
    .article-body p {
        margin-bottom: 1.5rem;
    }
    
    .article-sidebar {
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
    
    /* Table Responsive Styles */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 1rem auto;
        border-radius: 0.5rem;
        border: 1px solid var(--border);
        max-width: 100%;
        display: block;
    }
    
    table {
        width: 100%;
        min-width: 600px;
        border-collapse: collapse;
        background: var(--white);
        margin: 0 auto;
    }
    
    table th {
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.85rem;
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 2px solid var(--primary);
    }
    
    table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        color: var(--text);
        vertical-align: middle;
    }
    
    table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    table tbody tr:hover {
        background-color: rgba(var(--primary-rgb), 0.05);
    }
    
    table tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Center table wrapper when table is smaller than container */
    .table-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
    }
    
    /* Prevent horizontal overflow on the entire page */
    html, body {
        overflow-x: hidden;
        max-width: 100%;
    }
    
    .page-container,
    .content-section {
        width: 100%;
        box-sizing: border-box;
    }
    
    /* Ensure images and other media don't cause overflow */
    img,
    .featured-image,
    video,
    iframe {
        max-width: 100%;
        height: auto;
        display: block;
    }
    
    /* Ensure long words/URLs break properly */
    .article-body {
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }
    
    /* Fix for potential overflow issues */
    * {
        box-sizing: border-box;
    }
    
    .article-content,
    .article-sidebar {
        max-width: 100%;
        overflow: hidden;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .article-grid {
            grid-template-columns: 1fr;
        }
        
        .page-actions {
            flex-direction: column;
            align-items: center;
        }
        
        /* Mobile table adjustments */
        .table-responsive {
            margin: 1rem auto;
            border-radius: 0.5rem;
            display: flex;
            justify-content: flex-start;
        }
        
        table {
            min-width: 500px;
        }
        
        table th,
        table td {
            padding: 0.75rem 1rem;
        }
    }
    
    @media (max-width: 640px) {
        .table-responsive {
            margin: 0.75rem auto;
        }
        
        table {
            min-width: 400px;
        }
        
        table th,
        table td {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }
        
        .article-content,
        .article-sidebar {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .page-header {
            padding: 3rem 1rem 2rem;
        }
        
        .content-section {
            padding: 2rem 1rem;
        }
        
        .article-content,
        .article-sidebar {
            padding: 1rem;
        }
        
        .table-responsive {
            margin: 0.5rem auto;
        }
        
        table {
            min-width: 350px;
        }
        
        table th,
        table td {
            padding: 0.5rem;
            font-size: 0.85rem;
        }
    }
    
    /* For extra small screens */
    @media (max-width: 360px) {
        table {
            min-width: 300px;
        }
        
        table th,
        table td {
            padding: 0.4rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">{{ $article->title }}</h1>
        <p class="page-subtitle">Article Details - Admin View</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.articles.index') }}" class="btn-back">Back to Articles</a>
        </div>
    </div>
</div>

<div class="content-section">
    <div class="article-grid">
        <!-- Article Content -->
        <div class="article-content">
            <div class="content-header">
                <h2 class="content-title">Article Content</h2>
                @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                         alt="{{ $article->title }}" 
                         class="featured-image">
                @endif
            </div>
            
            <div class="article-body">
                {!! nl2br(e($article->content)) !!}
                
                <!-- Example table in content - if you have tables -->
                @if(false) <!-- Change to true if you have tables -->
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Column 1</th>
                                    <th>Column 2</th>
                                    <th>Column 3</th>
                                    <th>Column 4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Data 1</td>
                                    <td>Data 2</td>
                                    <td>Data 3</td>
                                    <td>Data 4</td>
                                </tr>
                                <tr>
                                    <td>Data 5</td>
                                    <td>Data 6</td>
                                    <td>Data 7</td>
                                    <td>Data 8</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Article Information -->
        <div class="article-sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Article Information</h3>
                
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="status-badge status-{{ $article->status }}">
                        {{ ucfirst($article->status) }}
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Author</span>
                    <div class="info-value">{{ $article->user->name ?? 'Unknown' }}</div>
                    @if($article->user->email)
                        <div style="font-size: 0.95rem; color: var(--text-light);">{{ $article->user->email }}</div>
                    @endif
                </div>
                
                <div class="info-item">
                    <span class="info-label">Created</span>
                    <div class="info-value">{{ $article->created_at->format('F d, Y') }}</div>
                    <div style="font-size: 0.95rem; color: var(--text-light);">{{ $article->created_at->format('g:i A') }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Last Updated</span>
                    <div class="info-value">{{ $article->updated_at->format('F d, Y') }}</div>
                    <div style="font-size: 0.95rem; color: var(--text-light);">{{ $article->updated_at->format('g:i A') }}</div>
                </div>
            </div>
            
            @if($article->categories->count() > 0)
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Categories</h3>
                    <div class="categories-list">
                        @foreach($article->categories as $category)
                            <span class="category-tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Example table in sidebar -->
            @if(false) <!-- Change to true if you have tables in sidebar -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Related Articles</h3>
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sample Article 1</td>
                                    <td><span class="status-badge status-published">Published</span></td>
                                    <td>2024-01-20</td>
                                </tr>
                                <tr>
                                    <td>Sample Article 2</td>
                                    <td><span class="status-badge status-draft">Draft</span></td>
                                    <td>2024-01-19</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection