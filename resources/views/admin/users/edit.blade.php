@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="margin-bottom: 1rem;">
            <a href="{{ URL::previous() }}"
               style="background: #f3f4f6; 
                      color: #374151; 
                      padding: 0.5rem 1rem; 
                      border-radius: 0.375rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      display: inline-block;">
                Back to Users
            </a>
        </div>
        <h1 style="font-size: 1.875rem; font-weight: bold;">Edit User</h1>
        <p style="color: #6b7280;">Update user information</p>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        <div style="background: white; border-radius: 0.5rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <!-- Name -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Name</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $user->name) }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('name')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Email</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('email')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Role -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Role</label>
                <select name="role" 
                        style="width: 100%; 
                               padding: 0.75rem; 
                               border: 1px solid #d1d5db; 
                               border-radius: 0.375rem; 
                               font-size: 1rem;">
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Password (leave blank to keep unchanged)</label>
                <input type="password" 
                       name="password" 
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('password')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Confirm Password</label>
                <input type="password" 
                       name="password_confirmation" 
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 1rem;">
                <button type="submit"
                        style="background: #2563eb; 
                               color: white; 
                               padding: 0.75rem 1.5rem; 
                               border-radius: 0.375rem; 
                               border: none; 
                               font-weight: 600; 
                               cursor: pointer;">
                    Update User
                </button>
                <a href="{{ route('admin.users.index') }}"
                   style="background: #f3f4f6; 
                          color: #374151; 
                          padding: 0.75rem 1.5rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection