<?php

namespace App\Http\Controllers;

use App\Models\Lpj;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LpjController extends Controller
{
    public function create(Activity $activity)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Hanya ORMAWA dan BEM yang dapat membuat LPJ.');
        }
        
        if ($activity->lpj) {
            return redirect()->route('activities.show', $activity)
                ->with('error', 'LPJ sudah pernah dibuat untuk kegiatan ini');
        }

        return view('lpj.create', compact('activity'));
    }

    public function store(Request $request, Activity $activity)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Hanya ORMAWA dan BEM yang dapat membuat LPJ.');
        }
        $validated = $request->validate([
            'laporan_kegiatan' => 'required|string',
            'realisasi_anggaran' => 'required|numeric|min:0',
            'kendala' => 'nullable|string',
            'solusi' => 'nullable|string',
            'file_lpj' => 'required|file|mimes:pdf|max:5120'
        ]);

        $file = $request->file('file_lpj');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('lpj', $fileName, 'public');

        Lpj::create([
            'activity_id' => $activity->id,
            'user_id' => Auth::id(),
            'laporan_kegiatan' => $validated['laporan_kegiatan'],
            'realisasi_anggaran' => $validated['realisasi_anggaran'],
            'kendala' => $validated['kendala'],
            'solusi' => $validated['solusi'],
            'file_lpj' => $filePath,
            'status' => 'pending',
            'submitted_at' => now()
        ]);

        return redirect()->route('activities.show', $activity)
            ->with('success', 'LPJ berhasil diajukan');
    }

    public function verify(Request $request, Lpj $lpj)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'catatan_verifikasi' => 'nullable|string'
        ]);

        $lpj->update([
            'status' => $validated['status'],
            'catatan_verifikasi' => $validated['catatan_verifikasi'],
            'verified_at' => now()
        ]);

        if ($validated['status'] === 'approved') {
            $lpj->activity->update(['status' => 'completed']);
        }

        return redirect()->back()->with('success', 'LPJ berhasil diverifikasi');
    }
}