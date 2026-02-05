@extends('layouts.app')

@section('title', 'Articles - Admin')

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
    
    .articles-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .articles-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }
    
    .articles-count {
        color: var(--text-light);
        font-size: 1rem;
        margin-top: 0.5rem;
    }
    
    .table-container {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }
    
    .articles-table {
        width: 100%;
        max-width: 1200px;
        border-collapse: collapse;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .articles-table th {
        background: var(--secondary);
        padding: 1.25rem 1.5rem;
        text-align: left;
        font-weight: 700;
        color: var(--primary);
        border-bottom: 2px solid var(--border);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .articles-table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        vertical-align: top;
    }
    
    .articles-table tr:last-child td {
        border-bottom: none;
    }
    
    .articles-table tr:hover {
        background: var(--secondary);
    }
    
    .article-title-cell {
        min-width: 250px;
        max-width: 350px;
    }
    
    .article-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .article-preview {
        font-size: 0.9rem;
        color: var(--text-light);
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }
    
    .article-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
        max-width: 200px;
    }
    
    .category-tag {
        padding: 0.25rem 0.5rem;
        background: var(--white);
        border: 1px solid var(--primary);
        color: var(--primary);
        font-weight: 500;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        white-space: nowrap;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
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
    
    .date-cell {
        min-width: 120px;
        white-space: nowrap;
    }
    
    .date-value {
        font-size: 0.9rem;
        color: var(--text);
    }
    
    .author-cell {
        min-width: 150px;
    }
    
    .author-name {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }
    
    .author-email {
        font-size: 0.8rem;
        color: var(--text-light);
    }
    
    .actions-cell {
        min-width: 180px;
    }
    
    .actions-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: nowrap;
    }
    
    .btn-view,
    .btn-edit,
    .btn-delete {
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        border: 2px solid;
        border-radius: 0.5rem;
        transition: all 0.3s;
        text-align: center;
        min-width: 70px;
    }
    
    .btn-view {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }
    
    .btn-view:hover {
        background: var(--white);
        color: var(--primary);
    }
    
    .btn-edit {
        background: var(--white);
        color: var(--primary);
        border-color: var(--primary);
    }
    
    .btn-edit:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .btn-delete {
        background: #dc2626;
        color: var(--white);
        border-color: #dc2626;
        cursor: pointer;
        font-family: inherit;
    }
    
    .btn-delete:hover {
        background: var(--white);
        color: #dc2626;
    }
    
    .btn-add {
        padding: 0.75rem 2rem;
        background: var(--primary);
        color: var(--white);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-add:hover {
        background: var(--white);
        color: var(--primary);
    }
    
    .btn-back {
        padding: 0.75rem 2rem;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
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
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }
    
    .pagination-link {
        padding: 0.5rem 1rem;
        border: 2px solid var(--border);
        color: var(--primary);
        text-decoration: none;
        border-radius: 0.25rem;
        transition: all 0.3s;
    }
    
    .pagination-link:hover,
    .pagination-link.active {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }
    
    .no-articles {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--white);
        border: 2px dashed var(--border);
        border-radius: 0.75rem;
        margin-top: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .no-articles-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .no-articles-title {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .no-articles-text {
        color: var(--text-light);
        margin-bottom: 2rem;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .articles-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .articles-table {
            display: block;
            overflow-x: auto;
        }
        
        .articles-table th,
        .articles-table td {
            padding: 1rem;
        }
        
        .actions-buttons {
            flex-direction: column;
        }
        
        .btn-view,
        .btn-edit,
        .btn-delete {
            min-width: 0;
            width: 100%;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">Articles Management</h1>
        <p class="page-subtitle">Manage all articles in the Contently library</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.articles.create') }}" class="btn-add">Create New Article</a>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">Back to Dashboard</a>
        </div>
    </div>
</div>

<div class="content-section">
    <!-- Articles List -->
    <div class="articles-header">
        <div>
            <h2 class="articles-title">All Articles</h2>
            @if($articles->total() > 0)
                <p class="articles-count">Showing {{ $articles->firstItem() }} to {{ $articles->lastItem() }} of {{ $articles->total() }} articles</p>
            @endif
        </div>
        
     
    </div>
    
    @if($articles->count() > 0)
        <div class="table-container">
            <table class="articles-table">
                <thead>
                    <tr>
                        <th class="article-title-cell">Article</th>
                        <th class="author-cell">Author</th>
                        <th>Categories</th>
                        <th>Status</th>
                        <th class="date-cell">Date Created</th>
                        <th class="date-cell">Last Updated</th>
                        <th class="actions-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td class="article-title-cell">
                                <div class="article-title">{{ $article->title }}</div>
                                <div class="article-preview">
                                    {{ Str::limit(strip_tags($article->content), 150) }}
                                </div>
                            </td>
                            <td class="author-cell">
                                <div class="author-name">{{ $article->user->name ?? 'Anonymous' }}</div>
                                @if($article->user->email)
                                    <div class="author-email">{{ $article->user->email }}</div>
                                @endif
                            </td>
                            <td>
                                @if($article->categories->count() > 0)
                                    <div class="article-categories">
                                        @foreach($article->categories as $category)
                                            <span class="category-tag">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color: var(--text-light); font-style: italic;">No categories</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $article->status }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td class="date-cell">
                                <div class="date-value">{{ $article->created_at->format('M d, Y') }}</div>
                                <div class="date-value" style="font-size: 0.8rem; color: var(--text-light);">
                                    {{ $article->created_at->format('g:i A') }}
                                </div>
                            </td>
                            <td class="date-cell">
                                <div class="date-value">{{ $article->updated_at->format('M d, Y') }}</div>
                                <div class="date-value" style="font-size: 0.8rem; color: var(--text-light);">
                                    {{ $article->updated_at->format('g:i A') }}
                                </div>
                            </td>
                            <td class="actions-cell">
                                <div class="actions-buttons">
                                    <a href="{{ route('admin.articles.show', $article) }}" class="btn-view">View</a>
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn-edit">Edit</a>
                                    <form method="POST" 
                                          action="{{ route('admin.articles.destroy', $article) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this article?')" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="pagination">
                @if($articles->onFirstPage())
                    <span class="pagination-link" style="opacity: 0.5;">Previous</span>
                @else
                    <a href="{{ $articles->previousPageUrl() }}" class="pagination-link">Previous</a>
                @endif
                
                @foreach(range(1, $articles->lastPage()) as $page)
                    @if($page == $articles->currentPage())
                        <span class="pagination-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $articles->url($page) }}" class="pagination-link">{{ $page }}</a>
                    @endif
                @endforeach
                
                @if($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}" class="pagination-link">Next</a>
                @else
                    <span class="pagination-link" style="opacity: 0.5;">Next</span>
                @endif
            </div>
        @endif
    @else
        <!-- No Articles Found -->
        <div class="no-articles">
            <h3 class="no-articles-title">No Articles Found</h3>
            <p class="no-articles-text">
                There are no articles in the system yet.
            </p>
            <a href="{{ route('admin.articles.create') }}" class="btn-add">Create Your First Article</a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation for all delete forms
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    
    deleteForms.forEach(form => {
        const button = form.querySelector('button[type="submit"]');
        if (button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) {
                    form.submit();
                }
            });
        }
    });
});
</script>
@endsection