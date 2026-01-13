@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Manage Users</h1>
                <p style="color: #6b7280;">View and manage all users in the system</p>

               <a href="{{ URL::previous() }}"
       style="background: #f3f4f6; 
              color: #374151; 
              padding: 0.5rem 1rem; 
              border-radius: 0.375rem; 
              text-decoration: none; 
              font-weight: 600;
              display: inline-block;
              margin-bottom: 1rem;">
        Back to Dashboard
    </a>
</div> 
            </div>
            <a href="{{ route('admin.users.create') }}"
               style="background: #2563eb; 
                      color: white; 
                      padding: 0.5rem 1rem; 
                      border-radius: 0.375rem; 
                      text-decoration: none; 
                      font-weight: 600;">
                + New User
            </a>
        </div>
    </div>

    <div style="border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; background: white;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f9fafb;">
                <tr>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Name</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Email</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Role</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Content</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Joined</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr style="border-top: 1px solid #e5e7eb;">
                        <td style="padding: 1rem;">
                            <div style="font-weight: 600; color: #111827;">{{ $user->name }}</div>
                        </td>
                        <td style="padding: 1rem; color: #6b7280;">
                            {{ $user->email }}
                        </td>
                        <td style="padding: 1rem;">
                            @if($user->role === 'admin')
                                <span style="padding: 0.25rem 0.75rem; 
                                           border-radius: 9999px; 
                                           font-size: 0.875rem; 
                                           font-weight: 600;
                                           background: #dbeafe;
                                           color: #1e40af;">
                                    Admin
                                </span>
                            @else
                                <span style="padding: 0.25rem 0.75rem; 
                                           border-radius: 9999px; 
                                           font-size: 0.875rem; 
                                           font-weight: 600;
                                           background: #e5e7eb;
                                           color: #374151;">
                                    User
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 1rem; font-size: 0.875rem;">
                                <div>
                                    <span style="font-weight: 600; color: #374151;">{{ $user->articles_count ?? 0 }}</span>
                                    <span style="color: #6b7280;">articles</span>
                                </div>
                                <div>
                                    <span style="font-weight: 600; color: #374151;">{{ $user->books_count ?? 0 }}</span>
                                    <span style="color: #6b7280;">books</span>
                                </div>
                                <div>
                                    <span style="font-weight: 600; color: #374151;">{{ $user->images_count ?? 0 }}</span>
                                    <span style="color: #6b7280;">images</span>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem; color: #6b7280; font-size: 0.875rem;">
                            {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   style="padding: 0.375rem 0.75rem; 
                                          background: #2563eb; 
                                          color: white; 
                                          border-radius: 0.375rem; 
                                          text-decoration: none; 
                                          font-weight: 600;
                                          font-size: 0.875rem;">
                                    View
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   style="padding: 0.375rem 0.75rem; 
                                          background: #059669; 
                                          color: white; 
                                          border-radius: 0.375rem; 
                                          text-decoration: none; 
                                          font-weight: 600;
                                          font-size: 0.875rem;">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="padding: 0.375rem 0.75rem; 
                                                   background: #dc2626; 
                                                   color: white; 
                                                   border-radius: 0.375rem; 
                                                   border: none; 
                                                   font-weight: 600;
                                                   font-size: 0.875rem;
                                                   cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 3rem; text-align: center; color: #6b7280;">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $users->links() }}
    </div>
</div>
@endsection