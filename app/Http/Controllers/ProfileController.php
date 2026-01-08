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

    public function edit(Request $request): View  //show profile edit form
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse //update profile info
    {
        $request->user()->fill($request->validated());  //fill user model with validated data

        if ($request->user()->isDirty('email')) {  // If email changed, require verification
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();  //save updated user info

        return Redirect::route('profile.edit')->with('status', 'profile-updated');  //redirect back with status
    }

    public function destroy(Request $request): RedirectResponse  //delete user account
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout(); //log out user

        $user->delete();  //delete user

        $request->session()->invalidate();  //delete session
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
