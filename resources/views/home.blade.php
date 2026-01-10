@extends('layouts.app')

@section('title', 'Home - Contently')

@section('content')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .exhibit-item {
        animation: fadeInUp 0.8s ease-out;
        animation-fill-mode: both;
    }
    
    .exhibit-item:nth-child(1) { animation-delay: 0.1s; }
    .exhibit-item:nth-child(2) { animation-delay: 0.2s; }
    .exhibit-item:nth-child(3) { animation-delay: 0.3s; }
    .exhibit-item:nth-child(4) { animation-delay: 0.4s; }
    
    .accent-line {
        position: relative;
        overflow: hidden;
    }
    
    .accent-line::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #d97706, #ea580c);
        transition: width 0.4s ease;
    }
    
    .accent-line:hover::after {
        width: 100%;
    }
</style>

<!-- Featured Highlight Bar -->
<section style="max-width: 1400px; margin: 3rem auto 4rem; padding: 0 2rem;">
    <div style="background: linear-gradient(135deg, #0c4a6e 0%, #075985 100%); padding: 2rem 3rem; border-left: 6px solid #fbbf24; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; width: 200px; height: 200px; background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 70%); animation: float 6s ease-in-out infinite;"></div>
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase; color: #fbbf24; margin-bottom: 0.5rem; font-weight: 700;">⭐ Current Spotlight</p>
            <h2 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.01em; line-height: 1.3;">Discover today's featured selections from our community of creators</h2>
        </div>
    </div>
</section>

<!-- Mixed Gallery Section - Newspaper/Magazine Layout -->
<section style="max-width: 1400px; margin: 0 auto 6rem; padding: 0 2rem;">
    <div style="margin-bottom: 4rem;">
        <div style="border-left: 6px solid #d97706; padding-left: 1.5rem; margin-bottom: 1rem;">
            <p style="font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase; color: #92400e; margin-bottom: 0.5rem; font-weight: 700;">Latest Edition</p>
            <h2 style="font-size: 2.5rem; font-weight: 900; color: #1c1917; letter-spacing: -0.02em; text-transform: uppercase;">Fresh From The Collection</h2>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(12, 1fr); gap: 2rem; margin-bottom: 6rem;">
        @php
            // Reorganize content with alternating patterns per row
            $articles = $articles->take(2);
            $images = $images->take(2);
            $books = $books->take(2);
            
            $orderedContent = collect();
            
            // Row 1: Article, Image, Book
            if (isset($articles[0])) {
                $orderedContent->push(['type' => 'article', 'item' => $articles[0]]);
            }
            if (isset($images[0])) {
                $orderedContent->push(['type' => 'image', 'item' => $images[0]]);
            }
            if (isset($books[0])) {
                $orderedContent->push(['type' => 'book', 'item' => $books[0]]);
            }
            
            // Row 2: Image, Book, Article
            if (isset($images[1])) {
                $orderedContent->push(['type' => 'image', 'item' => $images[1]]);
            }
            if (isset($books[1])) {
                $orderedContent->push(['type' => 'book', 'item' => $books[1]]);
            }
            if (isset($articles[1])) {
                $orderedContent->push(['type' => 'article', 'item' => $articles[1]]);
            }
        @endphp
        
        @forelse($orderedContent as $index => $content)
            @php
                // Define sizes based on content type - smaller to fit 3 per row
                if ($content['type'] === 'article') {
                    $size = ['span' => 5, 'height' => '240px']; // Wide for articles
                } elseif ($content['type'] === 'book') {
                    $size = ['span' => 3, 'height' => '280px']; // Narrow/tall for book covers
                } else { // image
                    $size = ['span' => 4, 'height' => 'auto']; // Variable height for images
                }
            @endphp
            @if($content['type'] === 'article')
                <!-- Article Exhibit -->
                <div class="exhibit-item" style="grid-column: span {{ $size['span'] }}; background: white; border: 3px solid #1c1917; padding: 0; transition: all 0.3s; position: relative; box-shadow: 6px 6px 0 #fef3c7; text-align: left; cursor: pointer;" onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='10px 10px 0 #d97706'" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='6px 6px 0 #fef3c7'">
                    <a href="{{ route('articles.show', $content['item']) }}" style="display: block; position: relative; height: {{ $size['height'] }}; overflow: hidden; background: #fafaf9;">
                        @if($content['item']->featured_image)
                            <img src="{{ asset('storage/' . $content['item']->featured_image) }}" 
                                 alt="{{ $content['item']->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #d97706 0%, #ea580c 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem;">
                                📰
                            </div>
                        @endif
                    </a>
                    
                    <div style="padding: 1.5rem; background: #fafaf9;">
                        <h3 class="accent-line" style="font-size: 1.1rem; font-weight: 800; margin-bottom: 0.75rem; color: #1c1917; line-height: 1.3;">
                            <a href="{{ route('articles.show', $content['item']) }}" style="color: #1c1917; text-decoration: none;">
                                {{ $content['item']->title }}
                            </a>
                        </h3>
                        
                        <p style="color: #78716c; font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $content['item']->excerpt ?? strip_tags($content['item']->content) }}
                        </p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; color: #a8a29e; font-size: 0.75rem; padding-top: 1rem; border-top: 2px solid #e7e5e4;">
                            <span style="font-weight: 600;">{{ $content['item']->author }}</span>
                            <span>{{ $content['item']->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            
            @elseif($content['type'] === 'image')
                <!-- Image Exhibit -->
                <div class="exhibit-item" style="grid-column: span {{ $size['span'] }}; background: white; border: 3px solid #1c1917; padding: 0; transition: all 0.3s; position: relative; box-shadow: 6px 6px 0 #dbeafe; text-align: left; cursor: pointer;" onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='10px 10px 0 #0c4a6e'" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='6px 6px 0 #dbeafe'">
                    <a href="{{ route('images.show', $content['item']) }}" style="display: block; position: relative; background: #fafaf9;">
                        <img src="{{ asset('storage/' . $content['item']->image_path) }}" 
                             alt="{{ $content['item']->title }}"
                             style="width: 100%; height: auto; display: block;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    </a>
                    
                    <div style="padding: 1.5rem; background: #fafaf9;">
                        <h3 class="accent-line" style="font-size: 1.1rem; font-weight: 800; margin-bottom: 0.5rem; color: #1c1917; line-height: 1.3;">
                            <a href="{{ route('images.show', $content['item']) }}" style="color: #1c1917; text-decoration: none;">
                                {{ Str::limit($content['item']->title, 40) }}
                            </a>
                        </h3>
                        
                        @if($content['item']->photographer)
                            <p style="color: #78716c; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">
                                {{ $content['item']->photographer }}
                            </p>
                        @endif
                        
                        <p style="color: #a8a29e; font-size: 0.75rem; margin-top: 0.5rem;">
                            {{ $content['item']->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            
            @elseif($content['type'] === 'book')
                <!-- Book Exhibit -->
                <div class="exhibit-item" style="grid-column: span {{ $size['span'] }}; background: white; border: 3px solid #1c1917; padding: 0; transition: all 0.3s; position: relative; box-shadow: 6px 6px 0 #e0e7ff; text-align: left; cursor: pointer;" onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='10px 10px 0 #4338ca'" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='6px 6px 0 #e0e7ff'">
                    <div style="position: relative; overflow: hidden; height: {{ $size['height'] }}; background: #fafaf9; display: flex; align-items: center; justify-content: center;">
                        @if($content['item']->cover_image)
                            <img src="{{ asset('storage/' . $content['item']->cover_image) }}" 
                                 alt="{{ $content['item']->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem;">
                                📚
                            </div>
                        @endif
                    </div>
                    
                    <div style="padding: 1.5rem; background: #fafaf9;">
                        <h3 class="accent-line" style="font-size: 1.1rem; font-weight: 800; margin-bottom: 0.5rem; color: #1c1917; line-height: 1.3;">
                            <a href="{{ route('books.show', $content['item']) }}" style="color: #1c1917; text-decoration: none;">
                                {{ Str::limit($content['item']->title, 50) }}
                            </a>
                        </h3>
                        
                        <p style="color: #78716c; font-size: 0.875rem; font-weight: 600;">
                            by {{ $content['item']->author }}
                        </p>
                    </div>
                </div>
            @endif
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: #fef3c7; border: 3px dashed #d97706;">
                <p style="color: #92400e; font-size: 1.25rem; font-weight: 700;">🎨 Gallery Opening Soon</p>
            </div>
        @endforelse
    </div>
    
    <!-- Navigation to Collections - Modern Cards -->
    <div style="margin-top: 5rem;">
        <div style="border-left: 6px solid #0c4a6e; padding-left: 1.5rem; margin-bottom: 3rem;">
            <p style="font-size: 0.7rem; letter-spacing: 0.15em; text-transform: uppercase; color: #0c4a6e; margin-bottom: 0.5rem; font-weight: 700;">Explore More</p>
            <h2 style="font-size: 2.5rem; font-weight: 900; color: #1c1917; letter-spacing: -0.02em; text-transform: uppercase;">Browse Collections</h2>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <a href="{{ route('articles.index') }}" style="text-decoration: none; background: white; border: 3px solid #1c1917; padding: 3rem 2rem; transition: all 0.3s; position: relative; box-shadow: 6px 6px 0 #fef3c7; text-align: center;" onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='10px 10px 0 #d97706'" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='6px 6px 0 #fef3c7'">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📰</div>
                <p style="font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: #d97706; margin-bottom: 0.5rem; font-weight: 800;">Collection</p>
                <h3 style="font-size: 1.5rem; font-weight: 900; color: #1c1917; text-transform: uppercase; letter-spacing: -0.01em;">Articles</h3>
                <div style="width: 60px; height: 3px; background: #d97706; margin: 1rem auto 0;"></div>
            </a>
            
            <a href="{{ route('books.index') }}" style="text-decoration: none; background: white; border: 3px solid #1c1917; padding: 3rem 2rem; transition: all 0.3s; position: relative; box-shadow: 6px 6px 0 #e0e7ff; text-align: center;" onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='10px 10px 0 #4338ca'" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='6px 6px 0 #e0e7ff'">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                <p style="font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: #6366f1; margin-bottom: 0.5rem; font-weight: 800;">Collection</p>
                <h3 style="font-size: 1.5rem; font-weight: 900; color: #1c1917; text-transform: uppercase; letter-spacing: -0.01em;">Literature</h3>
                <div style="width: 60px; height: 3px; background: #6366f1; margin: 1rem auto 0;"></div>
            </a>
            
            <a href="{{ route('images.index') }}" style="text-decoration: none; background: white; border: 3px solid #1c1917; padding: 3rem 2rem; transition: all 0.3s; position: relative; box-shadow: 6px 6px 0 #dbeafe; text-align: center;" onmouseover="this.style.transform='translate(-4px, -4px)'; this.style.boxShadow='10px 10px 0 #0c4a6e'" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='6px 6px 0 #dbeafe'">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🖼️</div>
                <p style="font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: #0c4a6e; margin-bottom: 0.5rem; font-weight: 800;">Collection</p>
                <h3 style="font-size: 1.5rem; font-weight: 900; color: #1c1917; text-transform: uppercase; letter-spacing: -0.01em;">Visual Art</h3>
                <div style="width: 60px; height: 3px; background: #0c4a6e; margin: 1rem auto 0;"></div>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
@guest
    <div style="max-width: 1400px; margin: 0 auto 4rem; padding: 0 2rem;">
        <div style="background: linear-gradient(135deg, #1c1917 0%, #292524 100%); padding: 5rem 3rem; border: 4px solid #fbbf24; position: relative; overflow: hidden; box-shadow: 8px 8px 0 #fef3c7;">
            <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 70%); animation: float 8s ease-in-out infinite;"></div>
            <div style="position: absolute; bottom: -80px; left: -80px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(217, 119, 6, 0.1) 0%, transparent 70%);"></div>
            
            <div style="position: relative; z-index: 1; text-align: center;">
                <p style="font-size: 0.75rem; letter-spacing: 0.2em; text-transform: uppercase; color: #fbbf24; margin-bottom: 1rem; font-weight: 800;">✨ Join The Movement</p>
                <h2 style="font-size: 3rem; font-weight: 900; margin-bottom: 1rem; color: white; text-transform: uppercase; letter-spacing: -0.02em;">Become A Contributor</h2>
                <p style="color: #d6d3d1; font-size: 1.125rem; margin-bottom: 2.5rem; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.7; font-weight: 500;">Share your stories, showcase your art, and connect with a community of passionate creators</p>
                <a href="{{ route('register') }}" style="padding: 1.25rem 3.5rem; background: #fbbf24; color: #1c1917; text-decoration: none; font-weight: 900; letter-spacing: 0.05em; font-size: 0.95rem; text-transform: uppercase; transition: all 0.3s; display: inline-block; border: 3px solid #fbbf24; box-shadow: 6px 6px 0 #d97706;" onmouseover="this.style.transform='translate(-3px, -3px)'; this.style.boxShadow='9px 9px 0 #d97706'" onmouseout="this.style.transform='translate(0, 0)'; this.style.boxShadow='6px 6px 0 #d97706'">Start Creating Today</a>
            </div>
        </div>
    </div>
@endguest
@endsection