<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile info (read-only).
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information and password.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1) Update nama/email
        $user->fill($request->validated());
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Simpan perubahan profil
        $user->save();

        // Flash hanya jika nama/email berubah
        if ($user->wasChanged(['name', 'email'])) {
            session()->flash('status_profile', 'profile-updated');
        }

        // 2) Jika ada upaya ubah password
        if ($request->filled('current_password') || $request->filled('password')) {
            // Validasi current + new password
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password'         => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'current_password.current_password' => 'Password saat ini tidak cocok.',
            ]);

            // Update password
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // Flash hanya jika password benar-benar diganti
            session()->flash('status_password', 'password-updated');
        }

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
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
