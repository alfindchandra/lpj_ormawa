<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    
    // Ambil semua data yang tervalidasi kecuali file 'logo'
    $validatedData = $request->safe()->except(['logo']);
    
    // Isi data teks (name, email, phone, dll)
    $user->fill($validatedData);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Proses upload logo secara terpisah
    if ($request->hasFile('logo')) {
        // Hapus logo lama dari disk public jika ada
        if ($user->logo && Storage::disk('public')->exists($user->logo)) {
            Storage::disk('public')->delete($user->logo);
        }

        // Simpan logo baru ke folder storage/app/public/logos
        $path = $request->file('logo')->store('logos', 'public');
        $user->logo = $path;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
