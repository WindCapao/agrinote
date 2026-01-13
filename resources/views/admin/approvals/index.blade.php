@extends('layouts.app')

@section('title', 'Content Approvals - Admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <!-- Back to Dashboard Button -->
        <div style="margin-bottom: 1rem;">
            <a href="{{ route('admin.dashboard') }}"
               style="background: #f3f4f6; 
                      color: #374151; 
                      padding: 0.5rem 1rem; 
                      border-radius: 0.375rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      display: inline-block;">
                Back to Dashboard
            </a>
        </div>
        
        <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Content Approvals</h1>
        <p style="color: #6b7280;">Review and approve or reject pending submissions</p>
    </div>

    <!-- Tabs -->
    <div style="border-bottom: 2px solid #e5e7eb; margin-bottom: 2rem;">
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.approvals.index', ['tab' => 'articles']) }}" 
               style="padding: 1rem 1.5rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      border-bottom: 3px solid {{ $tab === 'articles' ? '#2563eb' : 'transparent' }};
                      color: {{ $tab === 'articles' ? '#2563eb' : '#6b7280' }};
                      position: relative;">
                Articles
                @if($articles->total() > 0)
                    <span style="background: #dc2626; 
                               color: white; 
                               border-radius: 9999px; 
                               padding: 0.125rem 0.5rem; 
                               font-size: 0.75rem; 
                               margin-left: 0.5rem;">
                        {{ $articles->total() }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.approvals.index', ['tab' => 'books']) }}" 
               style="padding: 1rem 1.5rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      border-bottom: 3px solid {{ $tab === 'books' ? '#2563eb' : 'transparent' }};
                      color: {{ $tab === 'books' ? '#2563eb' : '#6b7280' }};">
                Books
                @if($books->total() > 0)
                    <span style="background: #dc2626; 
                               color: white; 
                               border-radius: 9999px; 
                               padding: 0.125rem 0.5rem; 
                               font-size: 0.75rem; 
                               margin-left: 0.5rem;">
                        {{ $books->total() }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.approvals.index', ['tab' => 'images']) }}" 
               style="padding: 1rem 1.5rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      border-bottom: 3px solid {{ $tab === 'images' ? '#2563eb' : 'transparent' }};
                      color: {{ $tab === 'images' ? '#2563eb' : '#6b7280' }};">
                Images
                @if($images->total() > 0)
                    <span style="background: #dc2626; 
                               color: white; 
                               border-radius: 9999px; 
                               padding: 0.125rem 0.5rem; 
                               font-size: 0.75rem; 
                               margin-left: 0.5rem;">
                        {{ $images->total() }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    @php
        $items = $tab === 'books' ? $books : ($tab === 'images' ? $images : $articles);
        $type  = $tab === 'books' ? 'books' : ($tab === 'images' ? 'images' : 'articles');
    @endphp

    <!-- Content Table -->
    <div style="border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; background: white;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f9fafb;">
                <tr>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Title</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Submitted By</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Date</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Status</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 700; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr style="border-top: 1px solid #e5e7eb;">
                        <td style="padding: 1rem;">
                            <div style="font-weight: 600; color: #111827; margin-bottom: 0.25rem;">
                                {{ Str::limit($item->title ?? 'Untitled', 50) }}
                            </div>
                            @if($tab === 'articles')
                                <div style="color: #6b7280; font-size: 0.875rem;">
                                    {{ Str::limit(strip_tags($item->content ?? ''), 80) }}
                                </div>
                            @elseif($tab === 'books')
                                <div style="color: #6b7280; font-size: 0.875rem;">
                                    by {{ $item->author ?? 'Unknown' }}
                                </div>
                            @endif
                        </td>
                        <td style="padding: 1rem;">
                            <div style="font-weight: 500;">{{ $item->user->name ?? 'N/A' }}</div>
                            <div style="color: #6b7280; font-size: 0.875rem;">{{ $item->user->email ?? '' }}</div>
                        </td>
                        <td style="padding: 1rem; color: #6b7280; font-size: 0.875rem;">
                            {{ $item->created_at->format('M d, Y') }}<br>
                            {{ $item->created_at->format('g:i A') }}
                        </td>
                        <td style="padding: 1rem;">
                            <span style="padding: 0.25rem 0.75rem; 
                                       border-radius: 9999px; 
                                       font-size: 0.875rem; 
                                       font-weight: 600;
                                       background: #fef3c7;
                                       color: #92400e;">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <form method="POST" action="{{ route('admin.approvals.approve', ['type' => $type, 'id' => $item->id]) }}">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Approve this {{ rtrim($type, 's') }}?')"
                                            style="background: #16a34a; 
                                                   color: white; 
                                                   border: none; 
                                                   padding: 0.5rem 1rem; 
                                                   border-radius: 0.375rem; 
                                                   cursor: pointer;
                                                   font-weight: 600;
                                                   font-size: 0.875rem;">
                                        Approve
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.approvals.reject', ['type' => $type, 'id' => $item->id]) }}">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Reject this {{ rtrim($type, 's') }}?')"
                                            style="background: #dc2626; 
                                                   color: white; 
                                                   border: none; 
                                                   padding: 0.5rem 1rem; 
                                                   border-radius: 0.375rem; 
                                                   cursor: pointer;
                                                   font-weight: 600;
                                                   font-size: 0.875rem;">
                                        Reject
                                    </button>
                                </form>

                                @if($tab === 'articles')
                                    <a href="{{ route('articles.show', $item) }}" 
                                       target="_blank"
                                       style="padding: 0.5rem 1rem; 
                                              background: #f3f4f6; 
                                              color: #374151; 
                                              border-radius: 0.375rem; 
                                              text-decoration: none;
                                              font-weight: 600;
                                              font-size: 0.875rem;">
                                        View
                                    </a>
                                @elseif($tab === 'books')
                                    <a href="{{ route('books.show', $item) }}" 
                                       target="_blank"
                                       style="padding: 0.5rem 1rem; 
                                              background: #f3f4f6; 
                                              color: #374151; 
                                              border-radius: 0.375rem; 
                                              text-decoration: none;
                                              font-weight: 600;
                                              font-size: 0.875rem;">
                                        View
                                    </a>
                                @elseif($tab === 'images')
                                    <a href="{{ route('images.show', $item) }}" 
                                       target="_blank"
                                       style="padding: 0.5rem 1rem; 
                                              background: #f3f4f6; 
                                              color: #374151; 
                                              border-radius: 0.375rem; 
                                              text-decoration: none;
                                              font-weight: 600;
                                              font-size: 0.875rem;">
                                        View
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: #6b7280;">
                            <div style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">No pending {{ $tab }}</div>
                            <div style="font-size: 0.875rem;">All caught up! There are no items waiting for approval.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 1.5rem;">
        {{ $items->appends(['tab' => $tab])->links() }}
    </div>
</div>
@endsection