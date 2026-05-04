<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class ProposalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'ormawa') {
            $proposals = Proposal::where('user_id', $user->id)->latest()->get();
        } else {
            $proposals = Proposal::with('user')->latest()->get();
        }
         
        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Hanya ORMAWA dan BEM yang dapat membuat proposal.');
        }
        return view('proposals.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Hanya ORMAWA dan BEM yang dapat membuat proposal.');
        }
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tipe_lokasi' => 'required|in:internal,eksternal',
            'tempat' => 'required|string|max:255',
            'barang_diperlukan' => 'required|string',
            'sewa_tempat' => 'required|string',
            'jasa' => 'required|string',
            'bahan' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'file_proposal' => 'required|file|mimes:pdf|max:5120',
        ]);

        $file = $request->file('file_proposal');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('proposals', $fileName, 'public');

        $proposal = Proposal::create([
            'user_id' => Auth::id(),
            'kode_proposal' => Proposal::generateKodeProposal(),
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'tipe_lokasi' => $validated['tipe_lokasi'],
            'tempat' => $validated['tempat'],
            'barang_diperlukan' => $validated['barang_diperlukan'],
            'sewa_tempat' => $validated['sewa_tempat'],
            'jasa' => $validated['jasa'],
            'bahan' => $validated['bahan'],
            'anggaran' => $validated['anggaran'],
            'file_proposal' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil diajukan dengan kode: ' . $proposal->kode_proposal);
    }

    public function show(Proposal $proposal)
    {
        $proposal->load('user', 'activity');
        return view('proposals.show', compact('proposal'));
    }

    public function approveBem(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'catatan_bem' => 'nullable|string'
        ]);

        $proposal->update([
            'status' => 'approved_bem',
            'catatan_bem' => $validated['catatan_bem']
        ]);

        return redirect()->back()->with('success', 'Proposal disetujui BEM');
    }

    public function approveAdmin(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string'
        ]);

        $proposal->update([
            'status' => 'approved_admin',
            'catatan_admin' => $validated['catatan_admin']
        ]);

        // Create activity
        Activity::create([
            'proposal_id' => $proposal->id,
            'user_id' => $proposal->user_id,
            'status' => 'scheduled'
        ]);

        return redirect()->back()->with('success', 'Proposal disetujui Admin');
    }

    public function reject(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'catatan' => 'required|string'
        ]);

        $field = Auth::user()->role === 'bem' ? 'catatan_bem' : 'catatan_admin';

        $proposal->update([
            'status' => 'rejected',
            $field => $validated['catatan']
        ]);

        return redirect()->back()->with('success', 'Proposal ditolak');
    }
}