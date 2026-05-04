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

    public function create()
    {
        if (Auth::user()->role !== 'bem') {
            abort(403, 'Unauthorized action.');
        }
        return view('activities.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'bem') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        ]);

        $activity = Activity::create([
            'user_id' => Auth::id(),
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dibuat');
    }

    public function show(Activity $activity)
    {
        $activity->load(['proposal', 'user', 'documentations', 'lpj']);
        return view('activities.show', compact('activity'));
    }

    public function updateStatus(Request $request, Activity $activity)
    {
        $user = Auth::user();
        
        // Allow ORMAWA who owns the activity or BEM
        if ($user->role === 'ormawa' && $user->id !== $activity->user_id) {
            abort(403, 'Anda hanya dapat mengubah status kegiatan milik organisasi Anda.');
        }
        
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Unauthorized action.');
        }
        
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
        $user = Auth::user();
        
        // Allow ORMAWA who owns the activity or BEM
        if ($user->role === 'ormawa' && $user->id !== $activity->user_id) {
            abort(403, 'Anda hanya dapat mengupload dokumentasi kegiatan milik organisasi Anda.');
        }
        
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Unauthorized action.');
        }
        
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