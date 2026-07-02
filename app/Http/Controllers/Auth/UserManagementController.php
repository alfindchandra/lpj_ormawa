<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    // 1. Tampilkan semua akun
    public function index()
    {
        $users = User::orderBy('role')->get();
        return view('profile.user-management.index', compact('users'));
    }

    // 2. Proses Update Informasi Akun & Password
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
        // 'ormawa_name' dihapus dari sini jika tidak digunakan
        'role' => ['required', 'string'],
        'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    // $user->ormawa_name = $request->ormawa_name; // dihapus dari sini jika tidak digunakan
    $user->role = $request->role;

    // Jika form password diisi, lakukan pembaruan password
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('status', 'user-updated');
}

    // 3. Proses Hapus Akun
    public function destroy(User $user)
    {
        // Cegah BEM menghapus akun dirinya sendiri di halaman manajemen ini
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'cannot-delete-self');
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'user-deleted');
    }
}