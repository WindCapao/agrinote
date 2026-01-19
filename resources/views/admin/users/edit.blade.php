@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('content')
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid var(--primary);
    }
    
    .form-title {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .form-subtitle {
        color: var(--text-light);
        font-size: 1.1rem;
    }
    
    .form-card {
        background: var(--white);
        border: 1px solid var(--border);
        padding: 3rem;
        margin-bottom: 2rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section:last-child {
        margin-bottom: 0;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }
    
    .form-input,
    .form-select {
        width: 100%;
        padding: 1rem;
        border: 2px solid var(--border);
        font-size: 1rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s;
        background: var(--white);
    }
    
    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--accent);
    }
    
    .form-help {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }
    
    .btn-submit {
        padding: 1rem 2.5rem;
        background: var(--primary);
        color: var(--white);
        border: 2px solid var(--primary);
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-submit:hover {
        background: var(--white);
        color: var(--primary);
    }
    
    .btn-cancel {
        padding: 1rem 2.5rem;
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
    
    .btn-cancel:hover {
        background: var(--primary);
        color: var(--white);
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
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">Edit User</h1>
        <p class="form-subtitle">Update user information and permissions</p>
    </div>
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <a href="{{ route('admin.users.show', $user) }}" class="btn-back">Back to User Details</a>
    </div>
    
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        
        <div class="form-card">
            <!-- Current User Info -->
            <div class="form-section" style="background: var(--secondary); padding: 1.5rem; border-radius: 0.5rem;">
                <div style="font-weight: 600; color: var(--primary); margin-bottom: 0.5rem;">Currently Editing:</div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: var(--white); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size: 1.25rem; font-weight: 600; color: var(--primary);">{{ $user->name }}</div>
                        <div style="color: var(--text-light);">{{ $user->email }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Name -->
            <div class="form-section">
                <label class="form-label">Full Name</label>
                <input type="text" 
                       name="name" 
                       class="form-input"
                       value="{{ old('name', $user->name) }}"
                       placeholder="Enter user's full name..."
                       required>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Email -->
            <div class="form-section">
                <label class="form-label">Email Address</label>
                <input type="email" 
                       name="email" 
                       class="form-input"
                       value="{{ old('email', $user->email) }}"
                       placeholder="user@example.com"
                       required>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Role -->
            <div class="form-section">
                <label class="form-label">User Role</label>
                <select name="role" class="form-select" required>
                    <option value="">Select a role</option>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Regular User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                <div class="form-help">
                    • User: Can create and manage their own content<br>
                    • Admin: Full system access and permissions<br>
                </div>
                @error('role')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Password Fields -->
            <div class="form-section">
                <label class="form-label">Change Password (Optional)</label>
                <div class="form-grid">
                    <div>
                        <input type="password" 
                               name="password" 
                               class="form-input"
                               placeholder="New password...">
                        <div class="form-help">Leave empty to keep current password</div>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <input type="password" 
                               name="password_confirmation" 
                               class="form-input"
                               placeholder="Confirm new password...">
                        @error('password_confirmation')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn-submit">Update User</button>
            <a href="{{ route('admin.users.show', $user) }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection