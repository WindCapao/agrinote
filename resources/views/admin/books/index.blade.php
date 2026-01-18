@extends('layouts.app')

@section('title', 'Books - Admin')

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
    
    .books-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .books-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }
    
    .books-count {
        color: var(--text-light);
        font-size: 1rem;
        margin-top: 0.5rem;
    }
    
    .books-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .books-table th {
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
    
    .books-table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .books-table tr:last-child td {
        border-bottom: none;
    }
    
    .books-table tr:hover {
        background: var(--secondary);
    }
    
    .book-cover-cell {
        width: 80px;
        padding: 1rem !important;
    }
    
    .book-cover {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid var(--border);
    }
    
    .book-cover-placeholder {
        width: 60px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.5rem;
        border-radius: 0.25rem;
        border: 1px solid var(--border);
    }
    
    .book-title-cell {
        min-width: 250px;
        max-width: 350px;
    }
    
    .book-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }
    
    .book-author {
        font-size: 0.9rem;
        color: var(--text-light);
    }
    
    .book-categories {
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
    
    .no-books {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--white);
        border: 2px dashed var(--border);
        border-radius: 0.75rem;
        margin-top: 2rem;
    }
    
    .no-books-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .no-books-title {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .no-books-text {
        color: var(--text-light);
        margin-bottom: 2rem;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .books-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .books-table {
            display: block;
            overflow-x: auto;
        }
        
        .books-table th,
        .books-table td {
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
        <h1 class="page-title">Books Management</h1>
        <p class="page-subtitle">Manage all books in the Contently library</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.books.create') }}" class="btn-add">Add New Book</a>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">Back to Dashboard</a>
        </div>
    </div>
</div>

<div class="content-section">
    <!-- Books List -->
    <div class="books-header">
        <div>
            <h2 class="books-title">All Books</h2>
            @if($books->total() > 0)
                <p class="books-count">Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }} books</p>
            @endif
        </div>
        
    
    </div>
    
    @if($books->count() > 0)
        <table class="books-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Cover</th>
                    <th class="book-title-cell">Book Details</th>
                    <th>Categories</th>
                    <th>Status</th>
                    <th class="date-cell">Date Created</th>
                    <th class="date-cell">Last Updated</th>
                    <th class="actions-cell">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td class="book-cover-cell">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                     alt="{{ $book->title }}" 
                                     class="book-cover">
                            @else
                                <div class="book-cover-placeholder">📚</div>
                            @endif
                        </td>
                        <td class="book-title-cell">
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">by {{ $book->author }}</div>
                            @if($book->publication_year)
                                <div style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.25rem;">
                                    Published: {{ $book->publication_year }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($book->categories->count() > 0)
                                <div class="book-categories">
                                    @foreach($book->categories as $category)
                                        <span class="category-tag">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: var(--text-light); font-style: italic;">No categories</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ $book->status }}">
                                {{ ucfirst($book->status) }}
                            </span>
                        </td>
                        <td class="date-cell">
                            <div class="date-value">{{ $book->created_at->format('M d, Y') }}</div>
                            <div class="date-value" style="font-size: 0.8rem; color: var(--text-light);">
                                {{ $book->created_at->format('g:i A') }}
                            </div>
                        </td>
                        <td class="date-cell">
                            <div class="date-value">{{ $book->updated_at->format('M d, Y') }}</div>
                            <div class="date-value" style="font-size: 0.8rem; color: var(--text-light);">
                                {{ $book->updated_at->format('g:i A') }}
                            </div>
                        </td>
                        <td class="actions-cell">
                            <div class="actions-buttons">
                                <a href="{{ route('admin.books.show', $book) }}" class="btn-view">View</a>
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn-edit">Edit</a>
                                <form method="POST" 
                                      action="{{ route('admin.books.destroy', $book) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this book?')" 
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
        
        <!-- Pagination -->
        @if($books->hasPages())
            <div class="pagination">
                @if($books->onFirstPage())
                    <span class="pagination-link" style="opacity: 0.5;">Previous</span>
                @else
                    <a href="{{ $books->previousPageUrl() }}" class="pagination-link">Previous</a>
                @endif
                
                @foreach(range(1, $books->lastPage()) as $page)
                    @if($page == $books->currentPage())
                        <span class="pagination-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $books->url($page) }}" class="pagination-link">{{ $page }}</a>
                    @endif
                @endforeach
                
                @if($books->hasMorePages())
                    <a href="{{ $books->nextPageUrl() }}" class="pagination-link">Next</a>
                @else
                    <span class="pagination-link" style="opacity: 0.5;">Next</span>
                @endif
            </div>
        @endif
    @else
        <!-- No Books Found -->
        <div class="no-books">
            <h3 class="no-books-title">No Books Found</h3>
            <p class="no-books-text">
                There are no books in the library yet.
            </p>
            <a href="{{ route('admin.books.create') }}" class="btn-add">Add Your First Book</a>
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
                if (confirm('Are you sure you want to delete this book? This action cannot be undone.')) {
                    form.submit();
                }
            });
        }
    });
});
</script>
@endsection