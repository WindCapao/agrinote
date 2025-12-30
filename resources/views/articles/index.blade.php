@extends('layouts.app')

@section('title', 'Latest Articles - Contently')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">Latest Articles</h1>
    
    @auth
        <a href="{{ route('articles.create') }}" class="btn">Write New Article</a>
    @endauth
</div>

<div style="display: grid; gap: 2rem;">
    @forelse($articles as $article)
        <article style="border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 0.5rem;">
            @if($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                     alt="{{ $article->title }}"
                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1rem;">
            @endif
            
            <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem;">
                <a href="{{ route('articles.show', $article) }}" style="color: #2563eb; text-decoration: none;">
                    {{ $article->title }}
                </a>
            </h2>
            
            <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                <span>By {{ $article->user->name }}</span> • 
                <span>{{ $article->created_at->format('M d, Y') }}</span> • 
                <span style="text-transform: capitalize; 
                             padding: 0.25rem 0.5rem; 
                             border-radius: 0.25rem;
                             background: {{ $article->status === 'published' ? '#d1fae5' : '#fef3c7' }};
                             color: {{ $article->status === 'published' ? '#065f46' : '#92400e' }};">
                    {{ $article->status }}
                </span>
            </div>
            
            <div style="margin-bottom: 1rem;">
                @foreach($article->categories as $category)
                    <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; margin-right: 0.5rem;">
                        {{ $category->name }}
                    </span>
                @endforeach
            </div>
            
            <p style="color: #4b5563; margin-bottom: 1rem;">
                {{ Str::limit($article->content, 200) }}
            </p>
            
            <a href="{{ route('articles.show', $article) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">
                Read More →
            </a>
        </article>
    @empty
        <div style="text-align: center; padding: 3rem; background: #f9fafb; border-radius: 0.5rem;">
            <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 1rem;">No articles found.</p>
            @auth
                <a href="{{ route('articles.create') }}" class="btn">Write the First Article</a>
            @else
                <p style="color: #9ca3af;">
                    <a href="{{ route('login') }}" style="color: #2563eb;">Login</a> to write an article
                </p>
            @endauth
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div style="margin-top: 2rem;">
    {{ $articles->links() }}
</div>
@endsection