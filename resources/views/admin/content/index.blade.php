@extends('layouts.app')

@section('title', 'Manage Content - Admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <a href="{{ route('admin.dashboard') }}"
                   style="background: #f3f4f6; 
                          color: #374151; 
                          padding: 0.5rem 1rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;
                          display: inline-block;
                          margin-bottom: 2rem;">
                    Back to Dashboard
                </a>
                <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Manage Content</h1>
                <p style="color: #6b7280;">Manage all articles, books, and images in one place</p>
            </div>
            <div>
                @if($tab === 'articles')
                    <a href="{{ route('admin.articles.create') }}"
                       style="background: #2563eb; 
                              color: white; 
                              padding: 0.5rem 1rem; 
                              border-radius: 0.375rem; 
                              text-decoration: none; 
                              font-weight: 600;">
                        + New Article
                    </a>
                @elseif($tab === 'books')
                    <a href="{{ route('admin.books.create') }}"
                       style="background: #2563eb; 
                              color: white; 
                              padding: 0.5rem 1rem; 
                              border-radius: 0.375rem; 
                              text-decoration: none; 
                              font-weight: 600;">
                        + New Book
                    </a>
                @elseif($tab === 'images')
                    <a href="{{ route('admin.images.create') }}"
                       style="background: #2563eb; 
                              color: white; 
                              padding: 0.5rem 1rem; 
                              border-radius: 0.375rem; 
                              text-decoration: none; 
                              font-weight: 600;">
                        + New Image
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div style="border-bottom: 2px solid #e5e7eb; margin-bottom: 2rem;">
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.content.index', ['tab' => 'articles']) }}" 
               style="padding: 1rem 1.5rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      border-bottom: 3px solid {{ $tab === 'articles' ? '#2563eb' : 'transparent' }};
                      color: {{ $tab === 'articles' ? '#2563eb' : '#6b7280' }};
                      position: relative;">
                Articles
                <span style="background: #e5e7eb; 
                           color: #374151; 
                           border-radius: 9999px; 
                           padding: 0.125rem 0.5rem; 
                           font-size: 0.75rem; 
                           margin-left: 0.5rem;">
                    {{ $articlesCount }}
                </span>
            </a>
            <a href="{{ route('admin.content.index', ['tab' => 'books']) }}" 
               style="padding: 1rem 1.5rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      border-bottom: 3px solid {{ $tab === 'books' ? '#2563eb' : 'transparent' }};
                      color: {{ $tab === 'books' ? '#2563eb' : '#6b7280' }};">
                Books
                <span style="background: #e5e7eb; 
                           color: #374151; 
                           border-radius: 9999px; 
                           padding: 0.125rem 0.5rem; 
                           font-size: 0.75rem; 
                           margin-left: 0.5rem;">
                    {{ $booksCount }}
                </span>
            </a>
            <a href="{{ route('admin.content.index', ['tab' => 'images']) }}" 
               style="padding: 1rem 1.5rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      border-bottom: 3px solid {{ $tab === 'images' ? '#2563eb' : 'transparent' }};
                      color: {{ $tab === 'images' ? '#2563eb' : '#6b7280' }};">
                Images
                <span style="background: #e5e7eb; 
                           color: #374151; 
                           border-radius: 9999px; 
                           padding: 0.125rem 0.5rem; 
                           font-size: 0.75rem; 
                           margin-left: 0.5rem;">
                    {{ $imagesCount }}
                </span>
            </a>
        </div>
    </div>

    <!-- Content based on selected tab -->
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
        @if($tab === 'articles')
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">All Articles ({{ $count }})</h2>
        @elseif($tab === 'books')
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">All Books ({{ $count }})</h2>
        @elseif($tab === 'images')
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">All Images ({{ $count }})</h2>
        @endif
        
        @if($items->count() > 0)
            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                @foreach($items as $item)
                    <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            @if($tab === 'articles')
                                <div style="font-weight: 600; color: #111827;">{{ $item->title }}</div>
                                <div style="color: #6b7280; font-size: 0.875rem;">
                                    by {{ $item->user->name ?? 'Unknown' }} • 
                                    {{ $item->created_at->format('M d, Y') }}
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    @php
                                        $statusColors = [
                                            'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                            'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                                            'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                                            'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                        ];
                                        $color = $statusColors[$item->status] ?? $statusColors['draft'];
                                    @endphp
                                    <span style="padding: 0.25rem 0.5rem; 
                                               border-radius: 9999px; 
                                               font-size: 0.75rem; 
                                               font-weight: 600;
                                               background: {{ $color['bg'] }};
                                               color: {{ $color['text'] }};">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                            @elseif($tab === 'books')
                                <div style="font-weight: 600; color: #111827;">{{ $item->title }}</div>
                                <div style="color: #6b7280; font-size: 0.875rem;">
                                    by {{ $item->author }} • 
                                    {{ $item->created_at->format('M d, Y') }}
                                </div>
                                <div style="margin-top: 0.25rem;">
                                    @php
                                        $statusColors = [
                                            'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                            'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                                            'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                                            'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                        ];
                                        $color = $statusColors[$item->status] ?? $statusColors['draft'];
                                    @endphp
                                    <span style="padding: 0.25rem 0.5rem; 
                                               border-radius: 9999px; 
                                               font-size: 0.75rem; 
                                               font-weight: 600;
                                               background: {{ $color['bg'] }};
                                               color: {{ $color['text'] }};">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                            @elseif($tab === 'images')
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <img src="{{ asset('storage/' . $item->image_path) }}" 
                                         alt="{{ $item->title }}"
                                         style="width: 50px; 
                                                height: 50px; 
                                                object-fit: cover; 
                                                border-radius: 0.375rem;">
                                    <div>
                                        <div style="font-weight: 600; color: #111827;">{{ $item->title }}</div>
                                        <div style="color: #6b7280; font-size: 0.875rem;">
                                            {{ $item->created_at->format('M d, Y') }}
                                        </div>
                                        <div style="margin-top: 0.25rem;">
                                            @php
                                                $statusColors = [
                                                    'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                                    'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                                                    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                                                    'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                                ];
                                                $color = $statusColors[$item->status] ?? $statusColors['draft'];
                                            @endphp
                                            <span style="padding: 0.25rem 0.5rem; 
                                                       border-radius: 9999px; 
                                                       font-size: 0.75rem; 
                                                       font-weight: 600;
                                                       background: {{ $color['bg'] }};
                                                       color: {{ $color['text'] }};">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            @if($tab === 'articles')
                                <a href="{{ route('admin.articles.show', $item) }}" 
                                   style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                    View
                                </a>
                                <a href="{{ route('admin.articles.edit', $item) }}" 
                                   style="color: #059669; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $item) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this article?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="color: #dc2626; background: none; border: none; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            @elseif($tab === 'books')
                                <a href="{{ route('admin.books.show', $item) }}" 
                                   style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                    View
                                </a>
                                <a href="{{ route('admin.books.edit', $item) }}" 
                                   style="color: #059669; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.books.destroy', $item) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this book?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="color: #dc2626; background: none; border: none; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            @elseif($tab === 'images')
                                <a href="{{ route('admin.images.show', $item) }}" 
                                   style="color: #2563eb; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                    View
                                </a>
                                <a href="{{ route('admin.images.edit', $item) }}" 
                                   style="color: #059669; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.images.destroy', $item) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this image?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="color: #dc2626; background: none; border: none; font-weight: 600; font-size: 0.875rem; cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 1.5rem;">
                {{ $items->appends(['tab' => $tab])->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: #6b7280;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">
                    @if($tab === 'articles') 
                    @elseif($tab === 'books') 
                    @elseif($tab === 'images') 
                    @endif
                </div>
                <div>No {{ $tab }} found.</div>
                <div style="margin-top: 1rem;">
                    @if($tab === 'articles')
                        <a href="{{ route('admin.articles.create') }}"
                           style="background: #2563eb; 
                                  color: white; 
                                  padding: 0.5rem 1rem; 
                                  border-radius: 0.375rem; 
                                  text-decoration: none; 
                                  font-weight: 600;
                                  display: inline-block;">
                            Create your first article
                        </a>
                    @elseif($tab === 'books')
                        <a href="{{ route('admin.books.create') }}"
                           style="background: #2563eb; 
                                  color: white; 
                                  padding: 0.5rem 1rem; 
                                  border-radius: 0.375rem; 
                                  text-decoration: none; 
                                  font-weight: 600;
                                  display: inline-block;">
                            Create your first book
                        </a>
                    @elseif($tab === 'images')
                        <a href="{{ route('admin.images.create') }}"
                           style="background: #2563eb; 
                                  color: white; 
                                  padding: 0.5rem 1rem; 
                                  border-radius: 0.375rem; 
                                  text-decoration: none; 
                                  font-weight: 600;
                                  display: inline-block;">
                            Upload your first image
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection