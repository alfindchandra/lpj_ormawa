<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // PERBAIKAN: Validasi ditambahkan untuk file logo (maksimal 2MB, format gambar)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'in:operator,ormawa'], 
            'ormawa_name' => ['required', 'string', 'max:255'], 
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Validasi file logo
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Proses upload file logo jika ada
        $logoPath = null;
        if ($request->hasFile('logo')) {
            // File akan disimpan di folder storage/app/public/logos
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Menyimpan field role, ormawa_name, dan path logo ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'ormawa_name' => $request->ormawa_name,
            'logo' => $logoPath, // Simpan path gambar ke database
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}