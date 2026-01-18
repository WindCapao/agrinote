@extends('layouts.app')

@section('title', $user->name . ' - Admin')

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
    
    .user-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
    }
    
    .user-profile {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
    }
    
    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        margin: 0 auto 1rem;
    }
    
    .profile-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-family: 'Playfair Display', serif;
    }
    
    .profile-email {
        font-size: 1rem;
        color: var(--text-light);
    }
    
    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .info-label {
        font-size: 0.85rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }
    
    .info-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary);
    }
    
    .role-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-radius: 4px;
    }
    
    .role-admin {
        background: #dbeafe;
        color: #1e40af;
        border: 2px solid #1e40af;
    }
    
    .role-user {
        background: #f3f4f6;
        color: #374151;
        border: 2px solid #6b7280;
    }
    
    .role-author {
        background: #fef3c7;
        color: #92400e;
        border: 2px solid #f59e0b;
    }
    
    .user-content {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 2rem;
    }
    
    .content-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }
    
    .content-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        font-family: 'Playfair Display', serif;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: var(--secondary);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.95rem;
        color: var(--text-light);
        font-weight: 600;
    }
    
    .recent-activity {
        margin-top: 2rem;
    }
    
    .activity-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
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
    
    .activity-title {
        font-size: 0.95rem;
        color: var(--text);
        margin-bottom: 0.25rem;
        line-height: 1.5;
        font-weight: 600;
    }
    
    .activity-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .activity-type {
        text-transform: capitalize;
        font-weight: 600;
    }
    
    .activity-time {
        font-style: italic;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-light);
    }
    
    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.2;
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
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .user-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .page-actions {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">{{ $user->name }}</h1>
        <p class="page-subtitle">User Profile - Admin View</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">Edit User</a>
            @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')" 
                      style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Delete User</button>
                </form>
            @endif
            <a href="{{ route('admin.users.index') }}" class="btn-back">Back to Users</a>
        </div>
    </div>
</div>

<div class="content-section">
    <div class="user-grid">
        <!-- User Profile -->
        <div class="user-profile">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="profile-name">{{ $user->name }}</h2>
                <div class="profile-email">{{ $user->email }}</div>
            </div>
            
            <div class="profile-info">
                <div class="info-item">
                    <span class="info-label">Role</span>
                    <span class="role-badge role-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Member Since</span>
                    <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
                    <div style="font-size: 0.95rem; color: var(--text-light);">{{ $user->created_at->diffForHumans() }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Last Updated</span>
                    <div class="info-value">{{ $user->updated_at->format('F d, Y') }}</div>
                    <div style="font-size: 0.95rem; color: var(--text-light);">{{ $user->updated_at->diffForHumans() }}</div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">User ID</span>
                    <div class="info-value" style="font-family: monospace; font-size: 1rem;">#{{ $user->id }}</div>
                </div>
            </div>
        </div>
        
        <!-- User Content & Activity -->
        <div class="user-content">
            <div class="content-header">
                <h2 class="content-title">Content Statistics</h2>
                <p style="color: var(--text-light); font-size: 0.95rem;">Summary of user's contributions</p>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $user->articles->count() }}</div>
                    <div class="stat-label">Articles</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">{{ $user->books->count() }}</div>
                    <div class="stat-label">Books</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-value">{{ $user->images->count() }}</div>
                    <div class="stat-label">Images</div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="recent-activity">
                <h3 class="activity-title">Recent Activity</h3>
                
                @php
                    $recentContent = collect()
                        ->merge($user->articles->take(3))
                        ->merge($user->books->take(3))
                        ->merge($user->images->take(3))
                        ->sortByDesc('created_at')
                        ->take(5);
                @endphp
                
                @if($recentContent->count() > 0)
                    <div class="activity-list">
                        @foreach($recentContent as $content)
                            <div class="activity-item">
                        
                                <div class="activity-content">
                                    <div class="activity-title">{{ $content->title }}</div>
                                    <div class="activity-meta">
                                        <span class="activity-type">{{ class_basename($content) }}</span>
                                        <span class="activity-time">{{ $content->created_at->format('M d, Y • g:i A') }}</span>
                                    </div>
                                </div>
                                @if(class_basename($content) === 'Article')
                                    <a href="{{ route('articles.show', $content) }}" 
                                       target="_blank"
                                       class="btn-edit" 
                                       style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                                        View
                                    </a>
                                @elseif(class_basename($content) === 'Book')
                                    <a href="{{ route('books.show', $content) }}" 
                                       target="_blank"
                                       class="btn-edit" 
                                       style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                                        View
                                    </a>
                                @elseif(class_basename($content) === 'Image')
                                    <a href="{{ route('images.show', $content) }}" 
                                       target="_blank"
                                       class="btn-edit" 
                                       style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                                        View
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p style="font-size: 1.125rem; color: var(--text-light); margin-bottom: 1rem;">No content found</p>
                        <p style="color: var(--text-light);">This user hasn't created any content yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection