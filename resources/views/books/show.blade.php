@extends('layouts.app')

@section('title', $book->title . ' - Contently')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 3rem;">
        <!-- Book Cover -->
        <div>
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" 
                     alt="{{ $book->title }}"
                     style="width: 100%; border-radius: 0.75rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            @else
                <div style="width: 100%; aspect-ratio: 2/3; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                    📚
                </div>
            @endif
        </div>
        
        <!-- Book Details -->
        <div>
            <!-- Title and Author -->
            <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem; line-height: 1.2;">
                {{ $book->title }}
            </h1>
            
            <p style="font-size: 1.5rem; color: #6b7280; margin-bottom: 1.5rem;">
                by {{ $book->author }}
            </p>
            
            <!-- Meta Information -->
            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                @if($book->publisher)
                    <div>
                        <span style="color: #9ca3af; font-size: 0.875rem; display: block;">Publisher</span>
                        <span style="font-weight: 600;">{{ $book->publisher }}</span>
                    </div>
                @endif
                
                @if($book->publication_year)
                    <div>
                        <span style="color: #9ca3af; font-size: 0.875rem; display: block;">Year</span>
                        <span style="font-weight: 600;">{{ $book->publication_year }}</span>
                    </div>
                @endif
                
                @if($book->pages)
                    <div>
                        <span style="color: #9ca3af; font-size: 0.875rem; display: block;">Pages</span>
                        <span style="font-weight: 600;">{{ $book->pages }}</span>
                    </div>
                @endif
                
                @if($book->isbn)
                    <div>
                        <span style="color: #9ca3af; font-size: 0.875rem; display: block;">ISBN</span>
                        <span style="font-weight: 600; font-family: monospace;">{{ $book->isbn }}</span>
                    </div>
                @endif
            </div>
            
            <!-- Status and Date -->
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <span style="padding: 0.5rem 1rem; 
                           border-radius: 9999px; 
                           font-weight: 500; 
                           font-size: 0.875rem;
                           background: {{ $book->status === 'published' ? '#d1fae5' : '#fef3c7' }};
                           color: {{ $book->status === 'published' ? '#065f46' : '#92400e' }};">
                    {{ ucfirst($book->status) }}
                </span>
                
                <span style="color: #6b7280; font-size: 0.875rem;">
                    Added by <strong>{{ $book->user->name }}</strong> on {{ $book->created_at->format('F j, Y') }}
                </span>
            </div>
            
            <!-- Categories -->
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 2rem;">
                @foreach($book->categories as $category)
                    <span style="background: #dbeafe; 
                               color: #1e40af; 
                               padding: 0.5rem 1rem; 
                               border-radius: 9999px; 
                               font-size: 0.875rem;
                               font-weight: 500;">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
            
            <!-- Description -->
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">About This Book</h2>
                <div style="font-size: 1.125rem; line-height: 1.8; color: #374151;">
                    {!! nl2br(e($book->description)) !!}
                </div>
            </div>
            
            <!-- Action Buttons -->
            @auth
                @if(Auth::id() === $book->user_id || Auth::user()->isAdmin())
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 2rem; display: flex; gap: 1rem;">
                        <a href="{{ route('books.edit', $book) }}" 
                           style="padding: 0.75rem 1.5rem; 
                                  background: #2563eb; 
                                  color: white; 
                                  border-radius: 0.5rem; 
                                  text-decoration: none;
                                  font-weight: 500;">
                            Edit Book
                        </a>
                        
                        <form method="POST" 
                              action="{{ route('books.destroy', $book) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this book?');"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="padding: 0.75rem 1.5rem; 
                                           background: #dc2626; 
                                           color: white; 
                                           border: none; 
                                           border-radius: 0.5rem; 
                                           cursor: pointer;
                                           font-weight: 500;">
                                Delete Book
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection