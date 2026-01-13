@extends('layouts.app')

@section('title', $user->name . ' - Admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">{{ $user->name }}</h1>
                <p style="color: #6b7280;">User Details</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.users.edit', $user) }}"
                   style="background: #2563eb; 
                          color: white; 
                          padding: 0.5rem 1rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;">
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="background: #dc2626; 
                                   color: white; 
                                   padding: 0.5rem 1rem; 
                                   border-radius: 0.375rem; 
                                   border: none; 
                                   font-weight: 600; 
                                   cursor: pointer;">
                        Delete
                    </button>
                </form>
                <a href="{{ URL::previous() }}"
                   style="background: #f3f4f6; 
                          color: #374151; 
                          padding: 0.5rem 1rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;">
                    Back
                </a>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <!-- User Info -->
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">User Information</h2>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Email</div>
                <div style="font-weight: 600;">{{ $user->email }}</div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Role</div>
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
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Joined</div>
                <div style="font-weight: 600;">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</div>
            </div>
            
            <div>
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Last Updated</div>
                <div style="font-weight: 600;">{{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A' }}</div>
            </div>
        </div>

        <!-- User Content Stats -->
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Content Statistics</h2>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem;">
                <!-- Articles -->
                <div style="text-align: center; padding: 1.5rem; background: #f0f9ff; border-radius: 0.5rem;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: #0284c7;">{{ $user->articles->count() }}</div>
                    <div style="font-weight: 600; color: #0c4a6e;">Articles</div>
                </div>
                
                <!-- Books -->
                <div style="text-align: center; padding: 1.5rem; background: #fef2f2; border-radius: 0.5rem;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: #dc2626;">{{ $user->books->count() }}</div>
                    <div style="font-weight: 600; color: #7f1d1d;">Books</div>
                </div>
                
                <!-- Images -->
                <div style="text-align: center; padding: 1.5rem; background: #f0fdf4; border-radius: 0.5rem;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: #16a34a;">{{ $user->images->count() }}</div>
                    <div style="font-weight: 600; color: #14532d;">Images</div>
                </div>
            </div>

            <!-- Recent Activity -->
            <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Recent Activity</h3>
            
            @php
                $recentContent = collect()
                    ->merge($user->articles->take(3))
                    ->merge($user->books->take(3))
                    ->merge($user->images->take(3))
                    ->sortByDesc('created_at')
                    ->take(5);
            @endphp
            
            @if($recentContent->count() > 0)
                <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                    @foreach($recentContent as $content)
                        <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 600;">{{ $content->title }}</div>
                                <div style="color: #6b7280; font-size: 0.875rem;">
                                    {{ class_basename($content) }} • 
                                    {{ $content->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            <div>
                                @if(class_basename($content) === 'Article')
                                    <a href="{{ route('articles.show', $content) }}" 
                                       style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                        View →
                                    </a>
                                @elseif(class_basename($content) === 'Book')
                                    <a href="{{ route('books.show', $content) }}" 
                                       style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                        View →
                                    </a>
                                @elseif(class_basename($content) === 'Image')
                                    <a href="{{ route('images.show', $content) }}" 
                                       style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                        View →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; color: #6b7280;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                    <div>No content found for this user.</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection