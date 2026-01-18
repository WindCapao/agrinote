@extends('layouts.app')

@section('title', $book->title . ' - Contently')

@section('content')
<style>
    .book-hero {
        background: var(--white);
        padding: 4rem 2rem 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .book-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .book-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    
    .book-title {
        font-size: 4rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }
    
    .book-author {
        font-size: 1.5rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
        font-style: italic;
    }
    
    .book-meta-bar {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 1.5rem 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .meta-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-light);
        font-weight: 600;
    }
    
    .meta-value {
        font-size: 0.95rem;
        color: var(--primary);
        font-weight: 600;
    }
    
    .book-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .book-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 3rem;
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 2rem;
    }
    
    .book-cover {
        position: sticky;
        top: 2rem;
    }
    
    .book-cover-image {
        width: 100%;
        border-radius: 0.75rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        border: 1px solid var(--border);
    }
    
    .book-details {
        padding: 1rem 0;
    }
    
    .book-description {
        font-size: 1.15rem;
        line-height: 1.9;
        color: var(--text);
        margin-bottom: 3rem;
    }
    
    .book-description p {
        margin-bottom: 1.5rem;
    }
    
    .book-categories {