<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show profile edit form
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profile information
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Show user's content (drafts, pending, published)
     */
    public function myContent()
    {
        $user = auth()->user();
        
        // Get all user's articles grouped by status
        $articles = $user->articles()
            ->with('categories')
            ->latest()
            ->get()
            ->groupBy('status');
        
        // Get all user's books grouped by status
        $books = $user->books()
            ->with('categories')
            ->latest()
            ->get()
            ->groupBy('status');
        
        // Get all user's images grouped by status
        $images = $user->images()
            ->with('categories')
            ->latest()
            ->get()
            ->groupBy('status');
        
        return view('profile.my-content', compact('articles', 'books', 'images'));
    }

    /**
     * Delete user account
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}