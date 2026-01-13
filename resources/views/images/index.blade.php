@extends('layouts.app')

@section('title', 'Image Gallery - Contently')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">Image Gallery</h1>
        
        @auth
            <a href="{{ route('images.create') }}" 
               style="padding: 0.5rem 1rem; 
                      background: #2563eb; 
                      color: white; 
                      border-radius: 0.375rem; 
                      text-decoration: none; 
                      font-weight: 600;
                      display: inline-block;">
                Upload New Image
            </a>
        @endauth
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($images as $image)
            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden; display: flex; flex-direction: column; background: white; transition: transform 0.2s;">
                <a href="{{ route('images.show', $image) }}" style="display: block; position: relative; overflow: hidden;">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="{{ $image->title }}"
                         style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s;"
                         onmouseover="this.style.transform='scale(1.05)'"
                         onmouseout="this.style.transform='scale(1)'">
                    
                    <!-- Image dimensions overlay -->
                    @if($image->width && $image->height)
                        <div style="position: absolute; bottom: 0.5rem; right: 0.5rem; background: rgba(0,0,0,0.7); color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                            {{ $image->width }} × {{ $image->height }}
                        </div>
                    @endif
                </a>
                
                <div style="padding: 1rem; flex-grow: 1; display: flex; flex-direction: column;">
                    <h3 style="font-size: 1.125rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <a href="{{ route('images.show', $image) }}" style="color: #2563eb; text-decoration: none;">
                            {{ $image->title }}
                        </a>
                    </h3>
                    
                    @if($image->description)
                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem; flex-grow: 1;">
                            {{ Str::limit($image->description, 80) }}
                        </p>
                    @endif
                    
                    <!-- Photographer -->
                    @if($image->photographer)
                        <p style="color: #9ca3af; font-size: 0.75rem; margin-bottom: 0.5rem;">
                            {{ $image->photographer }}
                        </p>
                    @endif
                    
                    <!-- Categories -->
                    <div style="margin-bottom: 0.75rem;">
                        @foreach($image->categories as $category)
                            <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; margin-right: 0.25rem;">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <!-- Status -->
                    @php
                        $statusColors = [
                            'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                            'draft' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                            'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                            'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                        ];
                        $color = $statusColors[$image->status] ?? $statusColors['draft'];
                    @endphp
                    <div style="margin-bottom: 0.75rem;">
                        <span style="text-transform: capitalize; 
                                     padding: 0.25rem 0.5rem; 
                                     border-radius: 0.25rem; 
                                     font-size: 0.75rem;
                                     background: {{ $color['bg'] }};
                                     color: {{ $color['text'] }};">
                            {{ $image->status }}
                        </span>
                    </div>
                    
                    <!-- Footer info -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; border-top: 1px solid #e5e7eb; font-size: 0.75rem;">
                        <span style="color: #9ca3af;">
                            {{ $image->created_at->format('M d, Y') }}
                        </span>
                        <span style="color: #9ca3af;">
                            {{ $image->getFileSizeFormatted() }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: #f9fafb; border-radius: 0.5rem;">
                <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 1rem;">No images found.</p>
                @auth
                    <a href="{{ route('images.create') }}" 
                       style="padding: 0.5rem 1rem; 
                              background: #2563eb; 
                              color: white; 
                              border-radius: 0.375rem; 
                              text-decoration: none; 
                              font-weight: 600;
                              display: inline-block;">
                        Upload the First Image
                    </a>
                @else
                    <p style="color: #9ca3af;">
                        <a href="{{ route('login') }}" style="color: #2563eb;">Login</a> to upload an image
                    </p>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 2rem;">
        {{ $images->links() }}
    </div>
</div>
@endsection