@extends('layouts.app')

@section('title', $article->title . ' - Contently')

@section('content')
<article style="max-width: 800px; margin: 0 auto;">
    <!-- Article Header -->
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem; line-height: 1.2;">
            {{ $article->title }}
        </h1>
        
        <!-- Meta Information -->
        <div style="display: flex; align-items: center; gap: 1rem; color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>By <strong>{{ $article->user->name }}</strong></span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $article->created_at->format('F j, Y') }}</span>
            </div>
            
            <div style="padding: 0.25rem 0.75rem; 
                       border-radius: 9999px; 
                       font-weight: 500;
                       background: {{ $article->status === 'published' ? '#d1fae5' : '#fef3c7' }};
                       color: {{ $article->status === 'published' ? '#065f46' : '#92400e' }};">
                {{ ucfirst($article->status) }}
            </div>
        </div>
        
        <!-- Categories -->
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
            @foreach($article->categories as $category)
                <span style="background: #dbeafe; 
                           color: #1e40af; 
                           padding: 0.375rem 1rem; 
                           border-radius: 9999px; 
                           font-size: 0.875rem;
                           font-weight: 500;">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>
    </div>
    
    <!-- Featured Image -->
    @if($article->featured_image)
        <div style="margin-bottom: 2rem;">
            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                 alt="{{ $article->title }}"
                 style="width: 100%; 
                        height: 400px; 
                        object-fit: cover; 
                        border-radius: 0.75rem;
                        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        </div>
    @endif
    
    <!-- Article Content -->
    <div style="font-size: 1.125rem; 
                line-height: 1.8; 
                color: #374151;
                margin-bottom: 3rem;">
        {!! nl2br(e($article->content)) !!}
    </div>
    
    <!-- Action Buttons (Edit/Delete for author or admin) -->
    @auth
        @if(Auth::id() === $article->user_id || Auth::user()->isAdmin())
            <div style="border-top: 1px solid #e5e7eb; 
                       padding-top: 2rem; 
                       display: flex; 
                       gap: 1rem;">
                <a href="{{ route('articles.edit', $article) }}" 
                   style="padding: 0.75rem 1.5rem; 
                          background: #2563eb; 
                          color: white; 
                          border-radius: 0.5rem; 
                          text-decoration: none;
                          font-weight: 500;">
                    Edit Article
                </a>
                
                <form method="POST" 
                      action="{{ route('articles.destroy', $article) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this article?');"
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
                        Delete Article
                    </button>
                </form>
            </div>
        @endif
    @endauth
</article>
@endsection