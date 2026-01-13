@extends('layouts.app')

@section('title', $image->title . ' - Admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">{{ $image->title }}</h1>
                <p style="color: #6b7280;">Image Details</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.content.index', $image) }}"
                   style="background: #2563eb; 
                          color: white; 
                          padding: 0.5rem 1rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;">
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.images.destroy', $image) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this image?')">
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
        <!-- Image Preview -->
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <img src="{{ asset('storage/' . $image->image_path) }}" 
                     alt="{{ $image->title }}"
                     style="max-width: 100%; 
                            max-height: 500px; 
                            object-fit: contain; 
                            border-radius: 0.5rem;">
            </div>
            
            @if($image->description)
                <div style="margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Description</h2>
                    <div style="line-height: 1.6; color: #374151;">
                        {!! nl2br(e($image->description)) !!}
                    </div>
                </div>
            @endif
        </div>

        <!-- Image Info -->
        <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Image Information</h2>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Status</div>
                @php
                    $statusColors = [
                        'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                        'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                        'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                        'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                    ];
                    $color = $statusColors[$image->status] ?? $statusColors['draft'];
                @endphp
                <span style="padding: 0.5rem 1rem; 
                           border-radius: 0.375rem; 
                           font-size: 0.875rem; 
                           font-weight: 600;
                           background: {{ $color['bg'] }};
                           color: {{ $color['text'] }};
                           display: inline-block;">
                    {{ ucfirst($image->status) }}
                </span>
            </div>
            
            @if($image->width && $image->height)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Dimensions</div>
                    <div style="font-weight: 600;">{{ $image->width }} × {{ $image->height }}px</div>
                </div>
            @endif
            
            @if($image->file_size)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">File Size</div>
                    <div style="font-weight: 600;">{{ $image->getFileSizeFormatted() }}</div>
                </div>
            @endif
            
            @if($image->license)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">License</div>
                    <div style="font-weight: 600;">{{ $image->license }}</div>
                </div>
            @endif
            
            @if($image->photographer)
                <div style="margin-bottom: 1.5rem;">
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Photographer</div>
                    <div style="font-weight: 600;">{{ $image->photographer }}</div>
                </div>
            @endif
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Uploaded By</div>
                <div style="font-weight: 600;">{{ $image->user->name ?? 'Unknown' }}</div>
                <div style="color: #6b7280; font-size: 0.875rem;">{{ $image->user->email ?? '' }}</div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Uploaded</div>
                <div style="font-weight: 600;">{{ $image->created_at->format('M d, Y g:i A') }}</div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Last Updated</div>
                <div style="font-weight: 600;">{{ $image->updated_at->format('M d, Y g:i A') }}</div>
            </div>
            
            @if($image->categories->count() > 0)
                <div>
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Categories</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($image->categories as $category)
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