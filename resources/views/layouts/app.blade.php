<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Contently')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1a1a1a;
            --secondary: #f5f5f0;
            --accent: #d4a574;
            --text: #2d2d2d;
            --text-light: #6b6b6b;
            --border: #e0e0d8;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--secondary);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            line-height: 1.2;
        }
        
        /* Header Styles */
        .site-header {
            background: var(--white);
            border-bottom: 2px solid var(--primary);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .site-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -0.02em;
        }
        
        .main-nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .main-nav a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 0.02em;
            transition: color 0.2s;
            text-transform: uppercase;
        }
        
        .main-nav a:hover {
            color: var(--accent);
        }
        
        .user-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .nav-divider {
            color: var(--border);
            font-size: 0.8rem;
            margin: 0 0.5rem;
        }
        
        .btn {
            padding: 0.6rem 1.5rem;
            background: var(--primary);
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: all 0.3s;
            border: 2px solid var(--primary);
            display: inline-block;
        }
        
        .btn:hover {
            background: var(--white);
            color: var(--primary);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
        }
        
        /* Footer */
        .site-footer {
            background: var(--primary);
            color: var(--white);
            padding: 3rem 2rem 2rem;
            margin-top: 6rem;
            border-top: 4px solid var(--accent);
        }
        
        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }
        
        .footer-section p,
        .footer-section a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .footer-section a:hover {
            color: var(--accent);
        }
        
        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }
        
        /* Alert Messages */
        .alert {
            max-width: 1400px;
            margin: 1.5rem auto;
            padding: 1rem 2rem;
            border-left: 4px solid;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        
        .alert-error {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .header-container {
                padding: 1rem;
            }
            
            .main-nav {
                gap: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .main-nav {
                flex-direction: column;
                gap: 0.5rem;
                width: 100%;
                text-align: center;
            }
            
            .nav-divider {
                display: none;
            }
            
            .user-nav {
                margin-top: 1rem;
                width: 100%;
                justify-content: center;
            }
            
            .footer-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .user-nav {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="site-logo">CONTENTLY</a>
            
            <nav class="main-nav">
                <!-- Always visible navigation links -->
                <a href="{{ route('articles.index') }}">Articles</a>
                <a href="{{ route('books.index') }}">Books</a>
                <a href="{{ route('images.index') }}">Images</a>
                
                <span class="nav-divider">|</span>
                
                <div class="user-nav">
                    @auth
                        <!-- User-specific links -->
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('my-content') }}">My Content</a>
                        @endif
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">Admin</a>
                        @endif
                        
                        <span style="color: var(--text-light); font-size: 0.85rem; white-space: nowrap;">
                            {{ auth()->user()->name }}
                        </span>
                        
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Logout</button>
                        </form>
                    @else
                        <!-- Public login/register -->
                        <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Register</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>About Contently</h3>
                <p>A curated platform for articles, books, and visual content. Discover, create, and share exceptional content in a beautifully designed space.</p>
            </div>
            
            <div class="footer-section">
                <h3>Explore</h3>
                <a href="{{ route('articles.index') }}">Articles</a>
                <a href="{{ route('books.index') }}">Books</a>
                <a href="{{ route('images.index') }}">Images</a>
            </div>
            
            <div class="footer-section">
                <h3>Create</h3>
                @auth
                    <a href="{{ route('articles.create') }}">Write Article</a>
                    <a href="{{ route('books.create') }}">Add Book</a>
                    <a href="{{ route('images.create') }}">Upload Image</a>
                @else
                    <a href="{{ route('login') }}">Login to Create</a>
                @endauth
            </div>
            
            <div class="footer-section">
                <h3>Account</h3>
                @auth
                    <a href="{{ route('profile.edit') }}">Profile</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Contently. A modern content platform.</p>
        </div>
    </footer>
</body>
</html>