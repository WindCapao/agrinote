@extends('layouts.app')

@section('title', 'Manage Images - Admin')

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
    
    .images-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .images-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }
    
    .images-count {
        color: var(--text-light);
        font-size: 1rem;
        margin-top: 0.5rem;
    }
    
    .images-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .images-table th {
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
    
    .images-table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .images-table tr:last-child td {
        border-bottom: none;
    }
    
    .images-table tr:hover {
        background: var(--secondary);
    }
    
    .image-preview-cell {
        width: 100px;
        padding: 1rem !important;
    }
    
    .image-preview {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid var(--border);
    }
    
    .image-details-cell {
        min-width: 250px;
        max-width: 350px;
    }
    
    .image-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .image-photographer {
        font-size: 0.9rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
    }
    
    .image-description {
        font-size: 0.9rem;
        color: var(--text-light);
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .image-categories {
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
    
    .no-images {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--white);
        border: 2px dashed var(--border);
        border-radius: 0.75rem;
        margin-top: 2rem;
    }
    
    .no-images-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .no-images-title {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .no-images-text {
        color: var(--text-light);
        margin-bottom: 2rem;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .images-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .images-table {
            display: block;
            overflow-x: auto;
        }
        
        .images-table th,
        .images-table td {
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
        <h1 class="page-title">Images Management</h1>
        <p class="page-subtitle">Manage all images in the Contently library</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.images.create') }}" class="btn-add">Upload New Image</a>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">Back to Dashboard</a>
        </div>
    </div>
</div>

<div class="content-section">
    <!-- Images List -->
    <div class="images-header">
        <div>
            <h2 class="images-title">All Images</h2>
            @if($images->total() > 0)
                <p class="images-count">Showing {{ $images->firstItem() }} to {{ $images->lastItem() }} of {{ $images->total() }} images</p>
            @endif
        </div>
        
        
    </div>
    
    @if($images->count() > 0)
        <table class="images-table">
            <thead>
                <tr>
                    <th style="width: 100px;">Preview</th>
                    <th class="image-details-cell">Image Details</th>
                    <th class="author-cell">Uploaded By</th>
                    <th>Categories</th>
                    <th>Status</th>
                    <th class="date-cell">Date Created</th>
                    <th class="actions-cell">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($images as $image)
                    <tr>
                        <td class="image-preview-cell">
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 alt="{{ $image->title }}" 
                                 class="image-preview">
                        </td>
                        <td class="image-details-cell">
                            <div class="image-title">{{ $image->title }}</div>
                            @if($image->photographer)
                                <div class="image-photographer">by {{ $image->photographer }}</div>
                            @endif
                            @if($image->description)
                                <div class="image-description">
                                    {{ Str::limit($image->description, 100) }}
                                </div>
                            @endif
                        </td>
                        <td class="author-cell">
                            <div class="author-name">{{ $image->user->name ?? 'Anonymous' }}</div>
                            @if($image->user->email)
                                <div class="author-email">{{ $image->user->email }}</div>
                            @endif
                        </td>
                        <td>
                            @if($image->categories->count() > 0)
                                <div class="image-categories">
                                    @foreach($image->categories as $category)
                                        <span class="category-tag">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color: var(--text-light); font-style: italic;">No categories</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ $image->status }}">
                                {{ ucfirst($image->status) }}
                            </span>
                        </td>
                        <td class="date-cell">
                            <div class="date-value">{{ $image->created_at->format('M d, Y') }}</div>
                            <div class="date-value" style="font-size: 0.8rem; color: var(--text-light);">
                                {{ $image->created_at->format('g:i A') }}
                            </div>
                        </td>
                        <td class="actions-cell">
                            <div class="actions-buttons">
                                <a href="{{ route('admin.images.show', $image) }}" class="btn-view">View</a>
                                <a href="{{ route('admin.images.edit', $image) }}" class="btn-edit">Edit</a>
                                <form method="POST" 
                                      action="{{ route('admin.images.destroy', $image) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this image?')" 
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
        @if($images->hasPages())
            <div class="pagination">
                @if($images->onFirstPage())
                    <span class="pagination-link" style="opacity: 0.5;">Previous</span>
                @else
                    <a href="{{ $images->previousPageUrl() }}" class="pagination-link">Previous</a>
                @endif
                
                @foreach(range(1, $images->lastPage()) as $page)
                    @if($page == $images->currentPage())
                        <span class="pagination-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $images->url($page) }}" class="pagination-link">{{ $page }}</a>
                    @endif
                @endforeach
                
                @if($images->hasMorePages())
                    <a href="{{ $images->nextPageUrl() }}" class="pagination-link">Next</a>
                @else
                    <span class="pagination-link" style="opacity: 0.5;">Next</span>
                @endif
            </div>
        @endif
    @else
        <!-- No Images Found -->
        <div class="no-images">
            <h3 class="no-images-title">No Images Found</h3>
            <p class="no-images-text">
                There are no images in the system yet.
            </p>
            <a href="{{ route('admin.images.create') }}" class="btn-add">Upload Your First Image</a>
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
                if (confirm('Are you sure you want to delete this image? This action cannot be undone.')) {
                    form.submit();
                }
            });
        }
    });
});
</script>
@endsection