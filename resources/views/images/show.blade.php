@extends('layouts.app')

@section('title', $image->title . ' - Contently')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <!-- Back button at the top -->
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('images.index') }}"
           style="background: #f3f4f6; 
                  color: #374151; 
                  padding: 0.5rem 1rem; 
                  border-radius: 0.375rem; 
                  text-decoration: none; 
                  font-weight: 600;
                  display: inline-block;">
            Back to Images
        </a>
    </div>

    <!-- Image Title -->
    <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem; text-align: center;">
        {{ $image->title }}
    </h1>
    
    <!-- Meta Information Bar -->
    <div style="display: flex; justify-content: center; align-items: center; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; color: #6b7280; font-size: 0.875rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span>Uploaded by <strong>{{ $image->user->name }}</strong></span>
        </div>
        
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>{{ $image->created_at->format('F j, Y') }}</span>
        </div>
        
        @if($image->photographer)
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span>{{ $image->photographer }}</span>
            </div>
        @endif
        
        @php
            $statusColors = [
                'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            ];
            $color = $statusColors[$image->status] ?? $statusColors['draft'];
        @endphp
        <span style="padding: 0.25rem 0.75rem; 
                   border-radius: 9999px; 
                   font-weight: 500;
                   background: {{ $color['bg'] }};
                   color: {{ $color['text'] }};">
            {{ ucfirst($image->status) }}
        </span>
    </div>
    
    <!-- Main Image -->
    <div style="margin-bottom: 2rem; text-align: center; background: #f9fafb; padding: 2rem; border-radius: 0.75rem;">
        <img src="{{ asset('storage/' . $image->image_path) }}" 
             alt="{{ $image->title }}"
             style="max-width: 100%; 
                    max-height: 80vh; 
                    border-radius: 0.5rem; 
                    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                    cursor: zoom-in;"
             onclick="openFullscreen(this)">
    </div>
    
    <!-- Image Details Grid -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <!-- Left Column: Description and Categories -->
        <div>
            @if($image->description)
                <div style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Description</h2>
                    <p style="font-size: 1.125rem; line-height: 1.8; color: #374151;">
                        {!! nl2br(e($image->description)) !!}
                    </p>
                </div>
            @endif
            
            <!-- Categories -->
            @if($image->categories->count() > 0)
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.75rem;">Categories</h3>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        @foreach($image->categories as $category)
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
                </div>
            @endif
        </div>
        
        <!-- Right Column: Technical Details -->
        <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.75rem;">
            <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Image Details</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @if($image->width && $image->height)
                    <div>
                        <span style="color: #6b7280; font-size: 0.875rem; display: block;">Dimensions</span>
                        <span style="font-weight: 600; font-size: 1.125rem;">{{ $image->width }} × {{ $image->height }}px</span>
                    </div>
                @endif
                
                @if($image->file_size)
                    <div>
                        <span style="color: #6b7280; font-size: 0.875rem; display: block;">File Size</span>
                        <span style="font-weight: 600; font-size: 1.125rem;">{{ $image->getFileSizeFormatted() }}</span>
                    </div>
                @endif
                
                @if($image->license)
                    <div>
                        <span style="color: #6b7280; font-size: 0.875rem; display: block;">License</span>
                        <span style="font-weight: 600; font-size: 1.125rem;">{{ $image->license }}</span>
                    </div>
                @endif
                
                <div>
                    <span style="color: #6b7280; font-size: 0.875rem; display: block;">Format</span>
                    <span style="font-weight: 600; font-size: 1.125rem; text-transform: uppercase;">
                        {{ pathinfo($image->image_path, PATHINFO_EXTENSION) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    @auth
        @if(Auth::id() === $image->user_id || Auth::user()->isAdmin())
            <div style="border-top: 1px solid #e5e7eb; padding-top: 2rem; display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('images.edit', $image) }}" 
                   style="padding: 0.75rem 1.5rem; 
                          background: #2563eb; 
                          color: white; 
                          border-radius: 0.5rem; 
                          text-decoration: none;
                          font-weight: 500;">
                    Edit Image
                </a>
                
                <form method="POST" 
                      action="{{ route('images.destroy', $image) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this image?');"
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
                        Delete Image
                    </button>
                </form>
            </div>
        @endif
    @endauth
</div>

<!-- Fullscreen Modal -->
<div id="fullscreenModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 9999; cursor: zoom-out;" onclick="closeFullscreen()">
    <img id="fullscreenImage" src="" style="max-width: 95%; max-height: 95%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <button onclick="closeFullscreen()" style="position: absolute; top: 20px; right: 20px; background: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: bold;">Close ✕</button>
</div>

<script>
function openFullscreen(img) {
    document.getElementById('fullscreenImage').src = img.src;
    document.getElementById('fullscreenModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeFullscreen() {
    document.getElementById('fullscreenModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}
</script>
@endsection