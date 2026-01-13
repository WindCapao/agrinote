@extends('layouts.app')

@section('title', $book->title . ' - Admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">{{ $book->title }}</h1>
                <p style="color: #6b7280;">Book Details</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.books.edit', $book) }}"
                   style="background: #2563eb; 
                          color: white; 
                          padding: 0.5rem 1rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;">
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this book?')">
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
    <div style="margin-bottom: 1.5rem;">
                <a href="{{ URL::previous() }}"
                style="background: #f3f4f6; 
                        color: #374151; 
                        padding: 0.5rem 1rem; 
                        border-radius: 0.375rem; 
                        text-decoration: none; 
                        font-weight: 600;
                        display: inline-block;
                        margin-bottom: 1rem;">
                    Back
                </a>
            </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Book Content -->
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                     alt="{{ $book->title }}"
                     style="width: 200px; 
                            height: 300px; 
                            object-fit: cover; 
                            border-radius: 0.5rem; 
                            margin-bottom: 1.5rem;">
            @endif
            
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Description</h2>
                <div style="line-height: 1.6; color: #374151;">
                    {!! nl2br(e($book->description)) !!}
                </div>
            </div>
        </div>

        <!-- Book Info -->
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Book Information</h2>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Author</div>
                <div style="font-weight: 600;">{{ $book->author }}</div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Status</div>
                @php
                    $statusColors = [
                        'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                        'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                        'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                        'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                    ];
                    $color = $statusColors[$book->status] ?? $statusColors['draft'];
                @endphp
                <span style="padding: 0.5rem 1rem; 
                           border-radius: 0.375rem; 
                           font-size: 0.875rem; 
                           font-weight: 600;
                           background: {{ $color['bg'] }};
                           color: {{ $color['text'] }};
                           display: inline-block;">
                    {{ ucfirst($book->status) }}
                </span>
            </div>
            
            @if($book->isbn)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">ISBN</div>
                    <div style="font-weight: 600;">{{ $book->isbn }}</div>
                </div>
            @endif
            
            @if($book->publisher)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Publisher</div>
                    <div style="font-weight: 600;">{{ $book->publisher }}</div>
                </div>
            @endif
            
            @if($book->publication_year)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Publication Year</div>
                    <div style="font-weight: 600;">{{ $book->publication_year }}</div>
                </div>
            @endif
            
            @if($book->pages)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages</div>
                    <div style="font-weight: 600;">{{ $book->pages }}</div>
                </div>
            @endif
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Submitted By</div>
                <div style="font-weight: 600;">{{ $book->user->name ?? 'Unknown' }}</div>
                <div style="color: #6b7280; font-size: 0.875rem;">{{ $book->user->email ?? '' }}</div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Created</div>
                <div style="font-weight: 600;">{{ $book->created_at->format('M d, Y g:i A') }}</div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Last Updated</div>
                <div style="font-weight: 600;">{{ $book->updated_at->format('M d, Y g:i A') }}</div>
            </div>
            
            @if($book->categories->count() > 0)
                <div>
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Categories</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($book->categories as $category)
                            <span style="padding: 0.25rem 0.75rem; 
                                       background: #e5e7eb; 
                                       color: #374151; 
                                       border-radius: 9999px; 
                                       font-size: 0.875rem;">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection