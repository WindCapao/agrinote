@extends('layouts.app')

@section('title', 'Admin Dashboard - Contently')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Admin Dashboard</h1>
        <p style="color: #6b7280;">Welcome back! Here's an overview of your content management system.</p>
    </div>

    <!-- Quick Action Buttons -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
        <a href="{{ route('admin.approvals.index') }}" 
           style="padding: 0.75rem 1.5rem; 
                  background: #dc2626; 
                  color: white; 
                  border-radius: 0.5rem; 
                  text-decoration: none;
                  font-weight: 600;
                  position: relative;">
            Pending Approvals
            @if($totalPending > 0)
                <span style="position: absolute; 
                           top: -8px; 
                           right: -8px; 
                           background: white; 
                           color: #dc2626; 
                           border-radius: 9999px; 
                           padding: 0.25rem 0.5rem; 
                           font-size: 0.75rem;
                           font-weight: 700;
                           border: 2px solid #dc2626;">
                    {{ $totalPending }}
                </span>
            @endif
        </a>
        <a href="{{ route('admin.content.index') }}" 
           style="padding: 0.75rem 1.5rem; 
                  background: #2563eb; 
                  color: white; 
                  border-radius: 0.5rem; 
                  text-decoration: none;
                  font-weight: 600;">
            Manage Content
        </a>
        <a href="{{ route('admin.users.index') }}" 
           style="padding: 0.75rem 1.5rem; 
                  background: #7c3aed; 
                  color: white; 
                  border-radius: 0.5rem; 
                  text-decoration: none;
                  font-weight: 600;">
            Manage Users
        </a>
    </div>

    <!-- Pending Items Section -->
    <div style="margin-bottom: 3rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #dc2626;">Pending Approvals</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div style="border: 2px solid #fecaca; background: #fef2f2; padding: 1.5rem; border-radius: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                    <h3 style="font-weight: 700; color: #991b1b;">Articles</h3>
                    <span style="font-size: 0.875rem; color: #dc2626; background: white; padding: 0.25rem 0.75rem; border-radius: 9999px;">Pending</span>
                </div>
                <div style="font-size: 2.5rem; font-weight: 900; color: #dc2626; margin-bottom: 0.5rem;">{{ $pendingArticles }}</div>
            </div>

            <div style="border: 2px solid #fecaca; background: #fef2f2; padding: 1.5rem; border-radius: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                    <h3 style="font-weight: 700; color: #991b1b;">Books</h3>
                    <span style="font-size: 0.875rem; color: #dc2626; background: white; padding: 0.25rem 0.75rem; border-radius: 9999px;">Pending</span>
                </div>
                <div style="font-size: 2.5rem; font-weight: 900; color: #dc2626; margin-bottom: 0.5rem;">{{ $pendingBooks }}</div>
            </div>

            <div style="border: 2px solid #fecaca; background: #fef2f2; padding: 1.5rem; border-radius: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                    <h3 style="font-weight: 700; color: #991b1b;">Images</h3>
                    <span style="font-size: 0.875rem; color: #dc2626; background: white; padding: 0.25rem 0.75rem; border-radius: 9999px;">Pending</span>
                </div>
                <div style="font-size: 2.5rem; font-weight: 900; color: #dc2626; margin-bottom: 0.5rem;">{{ $pendingImages }}</div>
            </div>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Content Statistics</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <!-- Articles Stats -->
            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 0.75rem; background: white;">
                <h3 style="font-weight: 700; margin-bottom: 1rem; color: #374151;">Articles</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #6b7280;">Total:</span>
                    <span style="font-weight: 700;">{{ $articleCount }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #059669;">Published:</span>
                    <span style="font-weight: 600; color: #059669;">{{ $publishedArticles }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #6b7280;">Draft:</span>
                    <span style="font-weight: 600;">{{ $draftArticles }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #dc2626;">Rejected:</span>
                    <span style="font-weight: 600; color: #dc2626;">{{ $rejectedArticles }}</span>
                </div>
            </div>

            <!-- Books Stats -->
            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 0.75rem; background: white;">
                <h3 style="font-weight: 700; margin-bottom: 1rem; color: #374151;">Books</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #6b7280;">Total:</span>
                    <span style="font-weight: 700;">{{ $bookCount }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #059669;">Published:</span>
                    <span style="font-weight: 600; color: #059669;">{{ $publishedBooks }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #6b7280;">Draft:</span>
                    <span style="font-weight: 600;">{{ $draftBooks }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #dc2626;">Rejected:</span>
                    <span style="font-weight: 600; color: #dc2626;">{{ $rejectedBooks }}</span>
                </div>
            </div>

            <!-- Images Stats -->
            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 0.75rem; background: white;">
                <h3 style="font-weight: 700; margin-bottom: 1rem; color: #374151;">Images</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #6b7280;">Total:</span>
                    <span style="font-weight: 700;">{{ $imageCount }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #059669;">Published:</span>
                    <span style="font-weight: 600; color: #059669;">{{ $publishedImages }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #6b7280;">Draft:</span>
                    <span style="font-weight: 600;">{{ $draftImages }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: #dc2626;">Rejected:</span>
                    <span style="font-weight: 600; color: #dc2626;">{{ $rejectedImages }}</span>
                </div>
            </div>

            <!-- Users Stats -->
            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; border-radius: 0.75rem; background: white;">
                <h3 style="font-weight: 700; margin-bottom: 1rem; color: #374151;">Users</h3>
                <div style="font-size: 2.5rem; font-weight: 900; color: #7c3aed; margin-bottom: 0.5rem;">{{ $userCount }}</div>
            </div>
        </div>
    </div>
</div>
@endsection