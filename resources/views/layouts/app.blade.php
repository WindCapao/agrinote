<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Contently')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; line-height: 1.6; color: #333; background: #fefefe; }
        .navbar { background: #0c4a6e; color: white; padding: 1rem 0; border-bottom: 3px solid #e0f2fe; position: relative; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #fbbf24; text-decoration: none; margin: 0 1rem; font-weight: 700; letter-spacing: 0.03em; text-transform: uppercase; font-size: 0.85rem; transition: all 0.2s; }
        .navbar a:hover { color: #fde68a; transform: translateY(-1px); }
        .nav-links { display: flex; align-items: center; }
        .navbar .brand { font-size: 1.5rem; font-weight: 900; color: #fbbf24; text-transform: uppercase; letter-spacing: -0.02em; text-shadow: 1px 1px 0 #0369a1; }
        .navbar .brand:hover { color: #fbbf24; transform: none; }
        .navbar span { color: #fde68a; margin: 0 1rem; font-weight: 600; font-size: 0.85rem; }
        .navbar button { background: none; border: none; color: #fbbf24; cursor: pointer; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.03em; transition: all 0.2s; }
        .navbar button:hover { color: #fde68a; transform: translateY(-1px); }
        .alert { padding: 1rem; margin: 1rem 0; border-radius: 0.5rem; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        main { padding: 2rem 0; min-height: 60vh; }
        footer { background: #0c4a6e; color: #e0f2fe; padding: 2rem 0; text-align: center; margin-top: 4rem; border-top: 3px solid #e0f2fe; }
        .btn { padding: 0.5rem 1rem; background: #0c4a6e; color: white; border: none; border-radius: 0.375rem; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.03em; }
        .btn:hover { background: #075985; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
    </style>
</head>
<body>
        <!-- Navigation -->
        <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="brand">Contently</a>
            
            <div class="nav-links">
                <a href="{{ route('articles.index') }}">Articles</a>
                <a href="{{ route('books.index') }}">Books</a>
                <a href="{{ route('images.index') }}">Images</a>
                
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
                    @endif
                    
                    <span>{{ Auth::user()->name }}</span>
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; BSIT 3-1 Group 9. All Rights Reserved.</p>
    </footer>
</body>
</html>