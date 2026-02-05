@extends('layouts.app')

@section('title', 'Manage Users - Admin')

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
    
    .manage-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    
    .section-title {
        font-size: 1.5rem;
        color: var(--primary);
        font-weight: 700;
        font-family: 'Playfair Display', serif;
    }
    
    .section-subtitle {
        font-size: 0.95rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }
    
    .btn-create {
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
    
    .btn-create:hover {
        background: var(--white);
        color: var(--primary);
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
    
    .users-table {
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
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .user-details {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .user-name {
        font-weight: 600;
        color: var(--primary);
    }
    
    .user-email {
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    .user-stats {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0.5rem 0.75rem;
        background: var(--secondary);
        border-radius: 0.5rem;
        min-width: 70px;
    }
    
    .stat-value {
        font-weight: 700;
        color: var(--primary);
        font-size: 1.25rem;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
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
    }
    
    .role-user {
        background: #f3f4f6;
        color: #374151;
    }
    
    .role-author {
        background: #fef3c7;
        color: #92400e;
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
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-edit {
        padding: 0.5rem 1rem;
        background: var(--primary);
        color: white;
        border: 2px solid var(--primary);
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
        min-width: 70px;
    }
    
    .btn-edit:hover {
        background: white;
        color: var(--primary);
    }
    
    .btn-delete {
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
        min-width: 70px;
    }
    
    .btn-delete:hover {
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
        min-width: 70px;
    }
    
    .btn-view:hover {
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
        
        .manage-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        
        .table th,
        .table td {
            padding: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .user-stats {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .stat-item {
            min-width: 0;
            width: 100%;
        }
    }
</style>

<div class="page-header">
    <div class="page-container">
        <h1 class="page-title">Manage Users</h1>
        <p class="page-subtitle">Admin control panel for user management</p>
        
        <div class="page-actions">
            <a href="{{ route('admin.users.create') }}" class="btn-create">Add New User</a>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">Back to Dashboard</a>
        </div>
    </div>
</div>

<div class="content-section">
    <div class="manage-header">
        <div>
            <h2 class="section-title">All Users</h2>
            <p class="section-subtitle">Total: {{ $users->total() }} users</p>
        </div>
        
    </div>
    
    @if($users->count() > 0)
        <div class="users-table">
            <div class="table-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">User List</div>
                        <div style="font-size: 0.95rem; color: var(--text-light); margin-top: 0.25rem;">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Content Statistics</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">{{ $user->name }}</div>
                                            <div class="user-email">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge role-{{ strtolower($user->role) }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="user-stats">
                                        <div class="stat-item">
                                            <div class="stat-value">{{ $user->articles_count }}</div>
                                            <div class="stat-label">Articles</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-value">{{ $user->books_count }}</div>
                                            <div class="stat-label">Books</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-value">{{ $user->images_count }}</div>
                                            <div class="stat-label">Images</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <div class="date-main">{{ $user->created_at->format('M d, Y') }}</div>
                                        <div class="date-time">{{ $user->created_at->diffForHumans() }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn-view">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="btn-edit">Edit</a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" 
                                                  action="{{ route('admin.users.destroy', $user) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')"
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Delete</button>
                                            </form>
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
            {{ $users->links() }}
        </div>
    @else
        <div class="empty-state">
            <h2 class="empty-title">No Users Found</h2>
            <p class="empty-text">There are no users in the system yet.</p>
            <a href="{{ route('admin.users.create') }}" class="btn-create">Add First User</a>
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
                if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                    form.submit();
                }
            });
        }
    });
});
</script>
@endsection