@extends('layouts.app') 
@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin! Here's an overview of your content.</p>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Articles</h5>
                    <p class="card-text">{{ $articleCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Published Articles</h5>
                    <p class="card-text">{{ $publishedArticles }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Draft Articles</h5>
                    <p class="card-text">{{ $draftArticles }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <p class="card-text">{{ $bookCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Published Books</h5>
                    <p class="card-text">{{ $publishedBooks }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Draft Books</h5>
                    <p class="card-text">{{ $draftBooks }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Images</h5>
                    <p class="card-text">{{ $imageCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Published Images</h5>
                    <p class="card-text">{{ $publishedImages }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Draft Images</h5>
                    <p class="card-text">{{ $draftImages }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $userCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add more admin features here, like links to manage content -->
    <a href="{{ route('admin.articles.index') }}" class="btn btn-primary mt-3">Manage Articles</a>
    <a href="{{ route('admin.books.index') }}" class="btn btn-primary mt-3">Manage Books</a>
    <a href="{{ route('admin.images.index') }}" class="btn btn-primary mt-3">Manage Images</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-3">Manage Users</a>
</div>
@endsection