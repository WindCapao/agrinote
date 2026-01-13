@extends('layouts.app')

@section('title', 'Edit Image - Admin')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <div style="margin-bottom: 1rem;">
            <a href="{{ URL::previous() }}"
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
        <h1 style="font-size: 1.875rem; font-weight: bold;">Edit Image</h1>
        <p style="color: #6b7280;">Update image information</p>
    </div>

    <form method="POST" action="{{ route('admin.images.update', $image) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="background: white; border-radius: 0.5rem; padding: 2rem; border: 1px solid #e5e7eb;">
            <!-- Current Image Preview -->
            <div style="margin-bottom: 1.5rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">Current Image</div>
                <img src="{{ asset('storage/' . $image->image_path) }}" 
                     alt="{{ $image->title }}"
                     style="max-width: 300px; 
                            max-height: 200px; 
                            object-fit: contain; 
                            border-radius: 0.375rem;">
            </div>

            <!-- Title -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Title</label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title', $image->title) }}"
                       required
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('title')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
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

            <!-- Description -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Description (Optional)</label>
                <textarea name="description" 
                          rows="4"
                          style="width: 100%; 
                                 padding: 0.75rem; 
                                 border: 1px solid #d1d5db; 
                                 border-radius: 0.375rem; 
                                 font-size: 1rem;">{{ old('description', $image->description) }}</textarea>
                @error('description')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Image File -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Change Image (Optional)</label>
                <input type="file" 
                       name="image_path"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                <div style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">
                    Leave empty to keep current image. Supported formats: JPEG, PNG, JPG, GIF, WEBP (Max: 5MB)
                </div>
                @error('image_path')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- License -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">License (Optional)</label>
                <input type="text" 
                       name="license" 
                       value="{{ old('license', $image->license) }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('license')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Photographer -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Photographer (Optional)</label>
                <input type="text" 
                       name="photographer" 
                       value="{{ old('photographer', $image->photographer) }}"
                       style="width: 100%; 
                              padding: 0.75rem; 
                              border: 1px solid #d1d5db; 
                              border-radius: 0.375rem; 
                              font-size: 1rem;">
                @error('photographer')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Status</label>
                <select name="status" 
                        required
                        style="width: 100%; 
                               padding: 0.75rem; 
                               border: 1px solid #d1d5db; 
                               border-radius: 0.375rem; 
                               font-size: 1rem;">
                    <option value="draft" {{ old('status', $image->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ old('status', $image->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ old('status', $image->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ old('status', $image->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Categories with checkboxes -->
<div style="margin-bottom: 2rem;">
    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Categories</label>
    <div style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 1rem; max-height: 200px; overflow-y: auto; background: white;">
        @php
            $selectedCategories = old('categories', $image->categories->pluck('id')->toArray());
        @endphp
        
        @foreach($categories as $category)
            <div style="margin-bottom: 0.5rem;">
                <label style="display: flex; align-items: center; cursor: pointer; padding: 0.25rem 0;">
                    <input type="checkbox" 
                           name="categories[]" 
                           value="{{ $category->id }}" 
                           {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}
                           style="margin-right: 0.75rem; width: 1rem; height: 1rem; cursor: pointer;">
                    <span style="font-size: 0.95rem;">{{ $category->name }}</span>
                </label>
            </div>
        @endforeach
    </div>
    @error('categories')
        <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
    @enderror
    <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">
        Select one or more categories from the list above
    </p>
</div>

            <!-- Buttons -->
            <div style="display: flex; gap: 1rem;">
                <button type="submit"
                        style="background: #2563eb; 
                               color: white; 
                               padding: 0.75rem 1.5rem; 
                               border-radius: 0.375rem; 
                               border: none; 
                               font-weight: 600; 
                               cursor: pointer;">
                    Update Image
                </button>
                <a href="{{ route('admin.images.show', $image) }}"
                   style="background: #f3f4f6; 
                          color: #374151; 
                          padding: 0.75rem 1.5rem; 
                          border-radius: 0.375rem; 
                          text-decoration: none; 
                          font-weight: 600;">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection