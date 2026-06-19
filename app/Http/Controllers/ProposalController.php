<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class ProposalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'bem'])) {
            $proposals = Proposal::with(['user', 'period'])->latest()->get();
        } else {
            $proposals = Proposal::where('user_id', $user->id)->with('period')->latest()->get();
        }

        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ukm', 'hmp', 'bem'])) {
            abort(403, 'Anda tidak memiliki akses untuk membuat proposal. Hanya UKM, HMP, dan BEM yang dapat membuat proposal.');
        }

        $periods      = Period::orderBy('is_active', 'desc')->orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();

        return view('proposals.create', compact('periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['ukm', 'hmp', 'bem'])) {
            abort(403, 'Anda tidak memiliki akses untuk membuat proposal.');
        }

        $validated = $request->validate([
            'period_id'       => 'required|exists:periods,id',
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tipe_lokasi'     => 'required|in:internal,eksternal',
            'tempat'          => 'required|string|max:255',
            'anggaran'        => 'required|numeric|min:0',
            'file_proposal'   => 'required|file|mimes:pdf|max:5120',

            // Internal items
            'internal_items'            => 'nullable|array',
            'internal_items.*.nama'     => 'nullable|string|max:255',
            'internal_items.*.jumlah'   => 'nullable|numeric|min:0',
            'internal_items.*.harga'    => 'nullable|numeric|min:0',

            // External items
            'external_items'            => 'nullable|array',
            'external_items.*.jasa'     => 'nullable|string|max:255',
            'external_items.*.jumlah'   => 'nullable|numeric|min:0',
            'external_items.*.harga'    => 'nullable|numeric|min:0',

            // Barang items
            'barang_items'              => 'nullable|array',
            'barang_items.*.nama'       => 'nullable|string|max:255',
            'barang_items.*.jumlah'     => 'nullable|numeric|min:0',
            'barang_items.*.harga'      => 'nullable|numeric|min:0',
        ]);

        $file     = $request->file('file_proposal');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('proposals', $fileName, 'public');

        DB::transaction(function () use ($validated, $filePath, $request, $user) {
            $proposal = Proposal::create([
                'user_id'         => $user->id,
                'period_id'       => $validated['period_id'],
                'kode_proposal'   => Proposal::generateKodeProposal(),
                'nama_kegiatan'   => $validated['nama_kegiatan'],
                'deskripsi'       => $validated['deskripsi'],
                'tanggal_mulai'   => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'tipe_lokasi'     => $validated['tipe_lokasi'],
                'tempat'          => $validated['tempat'],
                'anggaran'        => $validated['anggaran'],
                'file_proposal'   => $filePath,
                'status'          => 'pending',
            ]);

            $this->syncItems($proposal, $request);

            // Simpan kode ke session untuk flash message
            session(['last_kode_proposal' => $proposal->kode_proposal]);
            session(['last_proposal_id'   => $proposal->id]);
        });

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil diajukan dengan kode: ' . session('last_kode_proposal'));
    }

    public function show(Proposal $proposal)
    {
        $proposal->load(['user', 'activity', 'period', 'internalItems', 'externalItems', 'barangItems']);
        return view('proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        $user = Auth::user();
        if ($user->id !== $proposal->user_id && !in_array($user->role, ['bem', 'admin'])) {
            abort(403, 'Anda tidak berhak mengedit proposal ini.');
        }

        $proposal->load(['internalItems', 'externalItems', 'barangItems']);
        $periods      = Period::orderBy('is_active', 'desc')->orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();

        return view('proposals.edit', compact('proposal', 'periods', 'activePeriod'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $user = Auth::user();
        if ($user->id !== $proposal->user_id && !in_array($user->role, ['bem', 'admin'])) {
            abort(403, 'Anda tidak berhak mengupdate proposal ini.');
        }

        $validated = $request->validate([
            'period_id'       => 'required|exists:periods,id',
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tipe_lokasi'     => 'required|in:internal,eksternal',
            'tempat'          => 'required|string|max:255',
            'anggaran'        => 'required|numeric|min:0',
            'file_proposal'   => 'nullable|file|mimes:pdf|max:5120',

            'internal_items'            => 'nullable|array',
            'internal_items.*.nama'     => 'nullable|string|max:255',
            'internal_items.*.jumlah'   => 'nullable|numeric|min:0',
            'internal_items.*.harga'    => 'nullable|numeric|min:0',

            'external_items'            => 'nullable|array',
            'external_items.*.jasa'     => 'nullable|string|max:255',
            'external_items.*.jumlah'   => 'nullable|numeric|min:0',
            'external_items.*.harga'    => 'nullable|numeric|min:0',

            'barang_items'              => 'nullable|array',
            'barang_items.*.nama'       => 'nullable|string|max:255',
            'barang_items.*.jumlah'     => 'nullable|numeric|min:0',
            'barang_items.*.harga'      => 'nullable|numeric|min:0',
        ]);

        // Handle file upload
        $filePath = $proposal->file_proposal;
        if ($request->hasFile('file_proposal')) {
            if ($proposal->file_proposal) {
                Storage::disk('public')->delete($proposal->file_proposal);
            }
            $file     = $request->file('file_proposal');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('proposals', $fileName, 'public');
        }

        DB::transaction(function () use ($proposal, $validated, $filePath, $request) {
            $proposal->update([
                'period_id'       => $validated['period_id'],
                'nama_kegiatan'   => $validated['nama_kegiatan'],
                'deskripsi'       => $validated['deskripsi'],
                'tanggal_mulai'   => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'tipe_lokasi'     => $validated['tipe_lokasi'],
                'tempat'          => $validated['tempat'],
                'anggaran'        => $validated['anggaran'],
                'file_proposal'   => $filePath,
            ]);

            // Hapus semua item lama lalu insert ulang (sync pattern)
            $proposal->items()->delete();
            $this->syncItems($proposal, $request);
        });

        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Proposal berhasil diperbarui');
    }

    // ── Approval & Rejection ────────────────────────────────────────────────

    public function approveBem(Request $request, Proposal $proposal)
    {
        $validated = $request->validate(['catatan_bem' => 'nullable|string']);
        $proposal->update(['status' => 'approved_bem', 'catatan_bem' => $validated['catatan_bem']]);
        return redirect()->back()->with('success', 'Proposal disetujui BEM');
    }

    public function approveAdmin(Request $request, Proposal $proposal)
    {
        $validated = $request->validate(['catatan_admin' => 'nullable|string']);
        $proposal->update(['status' => 'approved_admin', 'catatan_admin' => $validated['catatan_admin']]);

        Activity::create([
            'proposal_id' => $proposal->id,
            'user_id'     => $proposal->user_id,
            'status'      => 'scheduled',
        ]);

        return redirect()->back()->with('success', 'Proposal disetujui Admin');
    }

    public function reject(Request $request, Proposal $proposal)
    {
        $validated = $request->validate(['catatan' => 'required|string']);
        $field     = Auth::user()->role === 'bem' ? 'catatan_bem' : 'catatan_admin';
        $proposal->update(['status' => 'rejected', $field => $validated['catatan']]);
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

        $proposal->delete(); // items terhapus via cascadeOnDelete

        return redirect()->route('proposals.index')->with('success', 'Proposal berhasil dihapus');
    }

    // ── Private Helper ──────────────────────────────────────────────────────

    /**
     * Insert items ke tabel proposal_items berdasarkan tipe_lokasi.
     * Internal → internal_items + barang_items
     * Eksternal → external_items + barang_items
     * Barang selalu ikut ke dua tipe lokasi.
     */
    private function syncItems(Proposal $proposal, Request $request): void
    {
        $rows   = [];
        $urutan = 0;

        // ── Internal Items ──────────────────────────────────────────────────
        foreach ($request->input('internal_items', []) as $item) {
            $nama   = trim($item['nama'] ?? '');
            $jumlah = (int) ($item['jumlah'] ?? 0);
            $harga  = (float) ($item['harga'] ?? 0);

            if ($nama === '' && $jumlah === 0 && $harga === 0) {
                continue; // skip baris kosong
            }

            $rows[] = [
                'proposal_id' => $proposal->id,
                'tipe'        => 'internal',
                'nama'        => $nama ?: null,
                'jasa'        => null,
                'jumlah'      => max(1, $jumlah),
                'harga'       => $harga,
                'subtotal'    => max(1, $jumlah) * $harga,
                'urutan'      => $urutan++,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // ── External Items (Jasa) ───────────────────────────────────────────
        foreach ($request->input('external_items', []) as $item) {
            $jasa   = trim($item['jasa'] ?? '');
            $jumlah = (int) ($item['jumlah'] ?? 0);
            $harga  = (float) ($item['harga'] ?? 0);

            if ($jasa === '' && $jumlah === 0 && $harga === 0) {
                continue;
            }

            $rows[] = [
                'proposal_id' => $proposal->id,
                'tipe'        => 'external',
                'nama'        => null,
                'jasa'        => $jasa ?: null,
                'jumlah'      => max(1, $jumlah),
                'harga'       => $harga,
                'subtotal'    => max(1, $jumlah) * $harga,
                'urutan'      => $urutan++,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // ── Barang Items (selalu ikut, untuk internal maupun eksternal) ─────
        foreach ($request->input('barang_items', []) as $item) {
            $nama   = trim($item['nama'] ?? '');
            $jumlah = (int) ($item['jumlah'] ?? 0);
            $harga  = (float) ($item['harga'] ?? 0);

            if ($nama === '' && $jumlah === 0 && $harga === 0) {
                continue;
            }

            $rows[] = [
                'proposal_id' => $proposal->id,
                'tipe'        => 'barang',
                'nama'        => $nama ?: null,
                'jasa'        => null,
                'jumlah'      => max(1, $jumlah),
                'harga'       => $harga,
                'subtotal'    => max(1, $jumlah) * $harga,
                'urutan'      => $urutan++,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        if (!empty($rows)) {
            ProposalItem::insert($rows);
        }
    }
}