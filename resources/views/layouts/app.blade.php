<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Contently')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; line-height: 1.6; color: #333; }
        .navbar { background: #2563eb; color: white; padding: 1rem 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin: 0 1rem; font-weight: 500; }
        .navbar a:hover { text-decoration: underline; }
        .nav-links { display: flex; align-items: center; }
        .alert { padding: 1rem; margin: 1rem 0; border-radius: 0.5rem; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        main { padding: 2rem 0; min-height: 60vh; }
        footer { background: #f3f4f6; padding: 2rem 0; text-align: center; margin-top: 4rem; }
        .btn { padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 0.375rem; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #1d4ed8; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" style="font-size: 1.5rem; font-weight: bold;">Contently</a>
            
            <div class="nav-links">
                <a href="{{ route('articles.index') }}">Articles</a>
                
                @auth
                    <a href="{{ route('articles.create') }}">Write Article</a>
                    
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
                    @endif
                    
                    <span style="margin: 0 1rem;">{{ Auth::user()->name }}</span>
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer; font-weight: 500;">Logout</button>
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