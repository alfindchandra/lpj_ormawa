<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Period;
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
            $proposals = Proposal::where('user_id', $user->id)->with('period')->latest()->get();
        } else {
            $proposals = Proposal::with(['user', 'period'])->latest()->get();
        }

        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Hanya ORMAWA dan BEM yang dapat membuat proposal.');
        }

        $periods = Period::orderBy('is_active', 'desc')->orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();

        return view('proposals.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ormawa', 'bem'])) {
            abort(403, 'Hanya ORMAWA dan BEM yang dapat membuat proposal.');
        }

        $validated = $request->validate([
            'period_id'      => 'required|exists:periods,id',
            'nama_kegiatan'  => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
            'tipe_lokasi'    => 'required|in:internal,eksternal',
            'tempat'         => 'required|string|max:255',
            'anggaran'       => 'required|numeric|min:0',
            'file_proposal'  => 'required|file|mimes:pdf|max:5120',
            'barang_internal_items'          => 'nullable|array',
            'barang_internal_items.*.nama'   => 'nullable|string',
            'barang_internal_items.*.jumlah' => 'nullable|numeric|min:1',
            'barang_internal_items.*.harga'  => 'nullable|numeric|min:0',
            'external_items'              => 'nullable|array',
            'external_items.*.jasa'       => 'nullable|string',
            'external_items.*.jumlah'     => 'nullable|numeric|min:1',
            'external_items.*.harga'      => 'nullable|numeric|min:0',
            'barang_items'                => 'nullable|array',
            'barang_items.*.nama'         => 'nullable|string',
            'barang_items.*.jumlah'       => 'nullable|numeric|min:1',
            'barang_items.*.harga'        => 'nullable|numeric|min:0',
        ]);

        $file = $request->file('file_proposal');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('proposals', $fileName, 'public');

        $internal_items = array_filter($request->input('internal_items', []), function ($item) {
            return !empty($item['item']) || !empty($item['harga']);
        });

        $external_items = array_filter($request->input('external_items', []), function ($item) {
            return !empty($item['jasa']) || !empty($item['jumlah']) || !empty($item['harga']);
        });

        $barang_items = array_filter($request->input('barang_items', []), function ($item) {
            return !empty($item['nama']) || !empty($item['jumlah']) || !empty($item['harga']);
        });

        $proposal = Proposal::create([
            'user_id'        => Auth::id(),
            'period_id'      => $validated['period_id'],
            'kode_proposal'  => Proposal::generateKodeProposal(),
            'nama_kegiatan'  => $validated['nama_kegiatan'],
            'deskripsi'      => $validated['deskripsi'],
            'tanggal_mulai'  => $validated['tanggal_mulai'],
            'tanggal_selesai'=> $validated['tanggal_selesai'],
            'tipe_lokasi'    => $validated['tipe_lokasi'],
            'tempat'         => $validated['tempat'],
            'barang_diperlukan' => '',
            'sewa_tempat'    => '',
            'jasa'           => '',
            'bahan'          => '',
            'anggaran'       => $validated['anggaran'],
            'file_proposal'  => $filePath,
            'status'         => 'pending',
            'internal_items' => array_values($internal_items),
            'external_items' => array_values($external_items),
            'barang_items'   => array_values($barang_items),
        ]);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil diajukan dengan kode: ' . $proposal->kode_proposal);
    }

    public function show(Proposal $proposal)
    {
        $proposal->load(['user', 'activity', 'period']);
        return view('proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        $user = Auth::user();
        if ($user->id !== $proposal->user_id && !in_array($user->role, ['bem', 'admin'])) {
            abort(403, 'Anda tidak berhak mengedit proposal ini.');
        }

        $periods = Period::orderBy('is_active', 'desc')->orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();

        return view('proposals.edit', compact('proposal', 'periods', 'activePeriod'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $user = Auth::user();
        if ($user->id !== $proposal->user_id && !in_array($user->role, ['bem', 'admin'])) {
            abort(403, 'Anda tidak berhak mengupdate proposal ini.');
        }

        // --- Bagian Validasi di store() dan update() ---
        $validated = $request->validate([
            'period_id'      => 'required|exists:periods,id',
            'nama_kegiatan'  => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
            'tipe_lokasi'    => 'required|in:internal,eksternal',
            'tempat'         => 'required|string|max:255',
            'anggaran'       => 'required|numeric|min:0',
            'file_proposal'  => $request->isMethod('html') ? 'required|file|mimes:pdf|max:5120' : 'nullable|file|mimes:pdf|max:5120', // sesuaikan store/update
            
            // Validasi baru untuk internal_items (Sama seperti eksternal)
            'internal_items'          => 'nullable|array',
            'internal_items.*.nama'   => 'nullable|string',
            'internal_items.*.jumlah' => 'nullable|numeric|min:1',
            'internal_items.*.harga'  => 'nullable|numeric|min:0',

            'external_items'          => 'nullable|array',
            'external_items.*.jasa'   => 'nullable|string',
            'external_items.*.jumlah' => 'nullable|numeric|min:1',
            'external_items.*.harga'  => 'nullable|numeric|min:0',
            
            'barang_items'            => 'nullable|array',
            'barang_items.*.nama'     => 'nullable|string',
            'barang_items.*.jumlah'   => 'nullable|numeric|min:1',
            'barang_items.*.harga'    => 'nullable|numeric|min:0',
        ]);

        // --- Bagian Array Filtering sebelum create/update ---
        $internal_items = array_filter($request->input('internal_items', []), function ($item) {
            return !empty($item['nama']) || !empty($item['jumlah']) || !empty($item['harga']);
        });

        $external_items = array_filter($request->input('external_items', []), function ($item) {
            return !empty($item['jasa']) || !empty($item['jumlah']) || !empty($item['harga']);
        });

        $barang_items = array_filter($request->input('barang_items', []), function ($item) {
            return !empty($item['nama']) || !empty($item['jumlah']) || !empty($item['harga']);
        });
        $proposal->update([
            'period_id'      => $validated['period_id'],
            'nama_kegiatan'  => $validated['nama_kegiatan'],
            'deskripsi'      => $validated['deskripsi'],
            'tanggal_mulai'  => $validated['tanggal_mulai'],
            'tanggal_selesai'=> $validated['tanggal_selesai'],
            'tipe_lokasi'    => $validated['tipe_lokasi'],
            'tempat'         => $validated['tempat'],
            'anggaran'       => $validated['anggaran'],
            'file_proposal'  => $filePath,
            'internal_items' => array_values($internal_items),
            'external_items' => array_values($external_items),
            'barang_items'   => array_values($barang_items),
        ]);

        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Proposal berhasil diperbarui');
    }

    public function approveBem(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'catatan_bem' => 'nullable|string'
        ]);

        $proposal->update([
            'status'      => 'approved_bem',
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
            'status'        => 'approved_admin',
            'catatan_admin' => $validated['catatan_admin']
        ]);

        Activity::create([
            'proposal_id' => $proposal->id,
            'user_id'     => $proposal->user_id,
            'status'      => 'scheduled'
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
            $field   => $validated['catatan']
        ]);

        return redirect()->back()->with('success', 'Proposal ditolak');
    }
    public function destroy(Proposal $proposal)
    {
        $user = Auth::user();
        if ($user->id !== $proposal->user_id && !in_array($user->role, ['bem', 'admin'])) {
            abort(403, 'Anda tidak berhak menghapus proposal ini.');
        }

        if ($proposal->file_proposal) {
            Storage::disk('public')->delete($proposal->file_proposal);
        }

        $proposal->delete();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil dihapus');
    }
}