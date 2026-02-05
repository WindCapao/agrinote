@extends('layouts.app')

@section('title', 'Admin Dashboard - Contently')

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
    
    .content-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }
    
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .dashboard-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
        transition: all 0.3s;
    }
    
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-color: var(--accent);
    }
    
    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
    }
    
    .card-content {
        margin-bottom: 1.5rem;
    }
    
    .card-stats {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .card-label {
        font-size: 0.95rem;
        color: var(--text-light);
    }
    
    .card-actions {
        border-top: 1px solid var(--border);
        padding-top: 1.5rem;
    }
    
    .card-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: color 0.3s;
    }
    
    .card-link:hover {
        color: var(--accent);
    }
    
    .link-icon {
        font-size: 1.25rem;
        transition: transform 0.3s;
    }
    
    .card-link:hover .link-icon {
        transform: translateX(4px);
    }
    
    .pending-items {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .pending-item {
        padding: 0.25rem 0.75rem;
        background: #fef3c7;
        color: #92400e;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .quick-actions {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
        margin-bottom: 3rem;
    }
    
    .actions-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
        font-family: 'Playfair Display', serif;
    }
    
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .action-button {
        padding: 1rem 1.5rem;
        background: var(--white);
        border: 2px solid var(--primary);
        color: var(--primary);
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
        display: block;
    }
    
    .action-button:hover {
        background: var(--primary);
        color: var(--white);
    }
    
    .recent-activity {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
    }
    
    .activity-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
        font-family: 'Playfair Display', serif;
    }
    
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        transition: background 0.3s;
    }
    
    .activity-item:hover {
        background: var(--secondary);
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-text {
        font-size: 0.95rem;
        color: var(--text);
        margin-bottom: 0.25rem;
        line-height: 1.5;
    }
    
    .activity-time {
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-light);
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">Admin Dashboard</h1>
        <p class="page-subtitle">Manage all content and user activity</p>
    </div>
</div>

<div class="content-section">
    <!-- Statistics Cards -->
    <div class="dashboard-grid">
        <!-- Articles -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Articles</div>
            </div>
            <div class="card-content">
                <div class="card-stats">{{ $totalArticles }}</div>
                <div class="card-label">Total Articles</div>
                <div class="pending-items">
                    <span class="pending-item">{{ $pendingArticles }} pending</span>
                </div>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.articles.index') }}" class="card-link">
                    Manage Articles
                    <span class="link-icon">→</span>
                </a>
            </div>
        </div>
        
        <!-- Books -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Books</div>
            </div>
            <div class="card-content">
                <div class="card-stats">{{ $totalBooks }}</div>
                <div class="card-label">Total Books</div>
                <div class="pending-items">
                    <span class="pending-item">{{ $pendingBooks }} pending</span>
                </div>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.books.index') }}" class="card-link">
                    Manage Books
                    <span class="link-icon">→</span>
                </a>
            </div>
        </div>
        
        <!-- Images -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Images</div>
            </div>
            <div class="card-content">
                <div class="card-stats">{{ $totalImages }}</div>
                <div class="card-label">Total Images</div>
                <div class="pending-items">
                    <span class="pending-item">{{ $pendingImages }} pending</span>
                </div>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.images.index') }}" class="card-link">
                    Manage Images
                    <span class="link-icon">→</span>
                </a>
            </div>
        </div>
        
        <!-- Users -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Users</div>
            </div>
            <div class="card-content">
                <div class="card-stats">{{ $totalUsers }}</div>
                <div class="card-label">Total Users</div>
                <div class="pending-items">
                    <span class="pending-item">{{ $recentUsers }} new this week</span>
                </div>
            </div>
            <div class="card-actions">
                <a href="{{ route('admin.users.index') }}" class="card-link">
                    Manage Users
                    <span class="link-icon">→</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
<div class="quick-actions">
    <h2 class="actions-title">Quick Actions</h2>
    <div class="actions-grid">
        <a href="{{ route('admin.approvals.index') }}" class="action-button">Review Approvals</a>
        <a href="{{ route('admin.articles.create') }}" class="action-button">Create Article</a>
        <a href="{{ route('admin.books.create') }}" class="action-button">Add Book</a>
        <a href="{{ route('admin.images.create') }}" class="action-button">Upload Image</a>
        <a href="{{ route('admin.users.create') }}" class="action-button">Add User</a>
    </div>
</div>
    
    <!-- Recent Activity -->
    <div class="recent-activity">
        <h2 class="activity-title">Recent Activity</h2>
        @if($recentActivity->count() > 0)
            <div class="activity-list">
                @foreach($recentActivity as $activity)
                    <div class="activity-item">
                        <div class="activity-content">
                            <div class="activity-text">{{ $activity->description }}</div>
                            <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>No recent activity to display.</p>
            </div>
        @endif
    </div>
</div>
@endsection