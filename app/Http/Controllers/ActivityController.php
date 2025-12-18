<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'ormawa') {
            $activities = Activity::where('user_id', $user->id)
                ->with('proposal')
                ->latest()
                ->get();
        } else {
            $activities = Activity::with(['proposal', 'user'])
                ->latest()
                ->get();
        }
        
        return view('activities.index', compact('activities'));
    }

    public function show(Activity $activity)
    {
        $activity->load(['proposal', 'user', 'documentations', 'lpj']);
        return view('activities.show', compact('activity'));
    }

    public function updateStatus(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'catatan_pelaksanaan' => 'nullable|string'
        ]);

        $activity->update($validated);

        return redirect()->back()->with('success', 'Status kegiatan berhasil diperbarui');
    }

    public function uploadDocumentation(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'keterangan' => 'nullable|string'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documentations', $fileName, 'public');

        Documentation::create([
            'activity_id' => $activity->id,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'keterangan' => $validated['keterangan']
        ]);

        return redirect()->back()->with('success', 'Dokumentasi berhasil diunggah');
    }
}