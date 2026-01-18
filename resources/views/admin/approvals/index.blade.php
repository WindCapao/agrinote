@extends('layouts.app')

@section('title', 'Content Approvals - Admin')

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
    
    .approvals-tabs {
        border-bottom: 2px solid var(--border);
        margin-bottom: 2.5rem;
    }
    
    .tabs-container {
        display: flex;
        gap: 0;
        overflow-x: auto;
    }
    
    .tab-item {
        padding: 1.25rem 2rem;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        color: var(--text-light);
        border-bottom: 3px solid transparent;
        white-space: nowrap;
        transition: all 0.3s;
        position: relative;
    }
    
    .tab-item:hover {
        color: var(--primary);
    }
    
    .tab-item.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }
    
    .tab-count {
        background: #dc2626;
        color: white;
        border-radius: 9999px;
        padding: 0.125rem 0.5rem;
        font-size: 0.75rem;
        margin-left: 0.5rem;
        font-weight: 700;
    }
    
    .approvals-table {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .table-header {
        background: var(--secondary);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .table-title {
        font-size: 1.5rem;
        color: var(--primary);
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }
    
    .table-subtitle {
        font-size: 0.95rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table thead {
        background: var(--secondary);
    }
    
    .table th {
        padding: 1.5rem 2rem;
        text-align: left;
        font-weight: 700;
        color: var(--primary);
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border);
    }
    
    .table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.3s;
    }
    
    .table tbody tr:hover {
        background: rgba(0, 0, 0, 0.02);
    }
    
    .table td {
        padding: 1.5rem 2rem;
        vertical-align: top;
    }
    
    .item-title {
        font-size: 1.125rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .item-preview {
        font-size: 0.95rem;
        color: var(--text-light);
        line-height: 1.6;
    }
    
    .author-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .author-name {
        font-weight: 600;
        color: var(--primary);
    }
    
    .author-email {
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .date-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .date-main {
        font-weight: 600;
        color: var(--primary);
    }
    
    .date-time {
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-radius: 4px;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-published {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-draft {
        background: #f3f4f6;
        color: #374151;
    }
    
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-approve {
        padding: 0.5rem 1rem;
        background: #16a34a;
        color: white;
        border: 2px solid #16a34a;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-approve:hover {
        background: white;
        color: #16a34a;
    }
    
    .btn-reject {
        padding: 0.5rem 1rem;
        background: #dc2626;
        color: white;
        border: 2px solid #dc2626;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-reject:hover {
        background: white;
        color: #dc2626;
    }
    
    .btn-view {
        padding: 0.5rem 1rem;
        background: var(--white);
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-view:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .btn-back {
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
    
    .btn-back:hover {
        background: var(--primary);
        color: var(--white);
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
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .table th,
        .table td {
            padding: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">Content Approvals</h1>
        <p class="page-subtitle">Review and manage pending submissions from the community</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-back">Back to Dashboard</a>
        </div>
    </div>
</div>

<div class="content-section">
    <!-- Tabs -->
    <div class="approvals-tabs">
        <div class="tabs-container">
            <a href="{{ route('admin.approvals.index', ['tab' => 'articles']) }}" 
               class="tab-item {{ $tab === 'articles' ? 'active' : '' }}">
                Articles
                @if($articles->total() > 0)
                    <span class="tab-count">{{ $articles->total() }}</span>
                @endif
            </a>
            <a href="{{ route('admin.approvals.index', ['tab' => 'books']) }}" 
               class="tab-item {{ $tab === 'books' ? 'active' : '' }}">
                Books
                @if($books->total() > 0)
                    <span class="tab-count">{{ $books->total() }}</span>
                @endif
            </a>
            <a href="{{ route('admin.approvals.index', ['tab' => 'images']) }}" 
               class="tab-item {{ $tab === 'images' ? 'active' : '' }}">
                Images
                @if($images->total() > 0)
                    <span class="tab-count">{{ $images->total() }}</span>
                @endif
            </a>
        </div>
    </div>

    @php
        $items = $tab === 'books' ? $books : ($tab === 'images' ? $images : $articles);
        $type  = $tab === 'books' ? 'books' : ($tab === 'images' ? 'images' : 'articles');
    @endphp

    @if($items->count() > 0)
        <div class="approvals-table">
            <div class="table-header">
                <h2 class="table-title">Pending {{ ucfirst($tab) }}</h2>
                <p class="table-subtitle">Review the details and approve or reject submissions</p>
            </div>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Submitted By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <div class="item-title">{{ $item->title ?? 'Untitled' }}</div>
                                    <div class="item-preview">
                                        @if($tab === 'articles')
                                            {{ Str::limit(strip_tags($item->content ?? ''), 100) }}
                                        @elseif($tab === 'books')
                                            by {{ $item->author ?? 'Unknown' }}
                                            @if($item->description)
                                                • {{ Str::limit($item->description, 80) }}
                                            @endif
                                        @elseif($tab === 'images')
                                            @if($item->description)
                                                {{ Str::limit($item->description, 80) }}
                                            @elseif($item->photographer)
                                                by {{ $item->photographer }}
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="author-info">
                                        <div class="author-name">{{ $item->user->name ?? 'Anonymous' }}</div>
                                        @if($item->user->email)
                                            <div class="author-email">{{ $item->user->email }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <div class="date-main">{{ $item->created_at->format('F d, Y') }}</div>
                                        <div class="date-time">{{ $item->created_at->format('g:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $item->status }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <form method="POST" action="{{ route('admin.approvals.approve', ['type' => $type, 'id' => $item->id]) }}" onsubmit="return confirm('Approve this {{ rtrim($type, 's') }}?')">
                                            @csrf
                                            <button type="submit" class="btn-approve">Approve</button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.approvals.reject', ['type' => $type, 'id' => $item->id]) }}" onsubmit="return confirm('Reject this {{ rtrim($type, 's') }}?')">
                                            @csrf
                                            <button type="submit" class="btn-reject">Reject</button>
                                        </form>

                                        @if($tab === 'articles')
                                            <a href="{{ route('admin.articles.show', $item) }}" 
                                               target="_blank"
                                               class="btn-view">
                                                View
                                            </a>
                                        @elseif($tab === 'books')
                                            <a href="{{ route('admin.books.show', $item) }}" 
                                               target="_blank"
                                               class="btn-view">
                                                View
                                            </a>
                                        @elseif($tab === 'images')
                                            <a href="{{ route('admin.images.show', $item) }}" 
                                               target="_blank"
                                               class="btn-view">
                                                View
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="pagination">
            {{ $items->appends(['tab' => $tab])->links() }}
        </div>
    @else
        <div class="empty-state">
            <h2 class="empty-title">All Caught Up!</h2>
            <p class="empty-text">There are no {{ $tab }} waiting for approval.</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('admin.approvals.index', ['tab' => 'articles']) }}" 
                   class="tab-item {{ $tab === 'articles' ? 'active' : '' }}">
                    Check Articles
                </a>
                <a href="{{ route('admin.approvals.index', ['tab' => 'books']) }}" 
                   class="tab-item {{ $tab === 'books' ? 'active' : '' }}">
                    Check Books
                </a>
                <a href="{{ route('admin.approvals.index', ['tab' => 'images']) }}" 
                   class="tab-item {{ $tab === 'images' ? 'active' : '' }}">
                    Check Images
                </a>
            </div>
        </div>
    @endif
</div>
@endsection