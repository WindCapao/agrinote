@extends('layouts.app')

@section('title', 'Book Collection - Contently')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">Book Collection</h1>
        
        @auth
            <a href="{{ route('books.create') }}" 
               style="padding: 0.5rem 1rem; 
                      background: #2563eb; 
                      color: white; 
                      border-radius: 0.375rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      display: inline-block;">
                Add New Book
            </a>
        @endauth
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 2rem;">
        @forelse($books as $book)
            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; display: flex; flex-direction: column;">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                         alt="{{ $book->title }}"
                         style="width: 100%; height: 300px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">
                        📚
                    </div>
                @endif
                
                <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <a href="{{ route('books.show', $book) }}" style="color: #2563eb; text-decoration: none;">
                            {{ $book->title }}
                        </a>
                    </h3>
                    
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                        by {{ $book->author }}
                    </p>
                    
                    @if($book->publisher || $book->publication_year)
                        <p style="color: #9ca3af; font-size: 0.75rem; margin-bottom: 1rem;">
                            @if($book->publisher){{ $book->publisher }}@endif
                            @if($book->publisher && $book->publication_year), @endif
                            @if($book->publication_year){{ $book->publication_year }}@endif
                        </p>
                    @endif
                    
                    <div style="margin-bottom: 1rem;">
                        @foreach($book->categories as $category)
                            <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; margin-right: 0.25rem;">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <p style="color: #4b5563; font-size: 0.875rem; margin-bottom: 1rem; flex-grow: 1;">
                        {{ Str::limit($book->description, 100) }}
                    </p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                        <span style="font-size: 0.75rem; color: #9ca3af;">
                            {{ $book->created_at->format('M d, Y') }}
                        </span>
                        @php
                            $statusColors = [
                                'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                                'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                                'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                            ];
                            $color = $statusColors[$book->status] ?? $statusColors['draft'];
                        @endphp
                        <span style="text-transform: capitalize; 
                                     padding: 0.25rem 0.5rem; 
                                     border-radius: 0.25rem; 
                                     font-size: 0.75rem;
                                     background: {{ $color['bg'] }};
                                     color: {{ $color['text'] }};">
                            {{ $book->status }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: #f9fafb; border-radius: 0.5rem;">
                <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 1rem;">No books found.</p>
                @auth
                    <a href="{{ route('books.create') }}" 
                       style="padding: 0.5rem 1rem; 
                              background: #2563eb; 
                              color: white; 
                              border-radius: 0.375rem; 
                              text-decoration: none; 
                              font-weight: 600;
                              display: inline-block;">
                        Add the First Book
                    </a>
                @else
                    <p style="color: #9ca3af;">
                        <a href="{{ route('login') }}" style="color: #2563eb;">Login</a> to add a book
                    </p>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 2rem;">
        {{ $books->links() }}
    </div>
</div>
@endsection