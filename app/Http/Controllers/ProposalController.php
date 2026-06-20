<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalItem;
use App\Models\Period;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
            'tempat'          => 'required|string|max:255',
            'file_proposal'   => 'required|file|mimes:pdf|max:5120',
            
            // SEKARANG DIAKUI NULLABLE (BISA KOSONG)
            'tipe_lokasi'     => 'nullable|in:internal,eksternal',
            'anggaran'        => 'nullable|numeric|min:0',

            // Validasi item-item dinamis
            'konsumsi_items'          => 'nullable|array',
            'konsumsi_items.*.nama'   => 'nullable|string|max:255',
            'konsumsi_items.*.jumlah' => 'nullable|integer|min:0',
            'konsumsi_items.*.harga'  => 'nullable|numeric|min:0',

            'atk_items'               => 'nullable|array',
            'atk_items.*.nama'        => 'nullable|string|max:255',
            'atk_items.*.jumlah'      => 'nullable|integer|min:0',
            'atk_items.*.harga'       => 'nullable|numeric|min:0',

            'honor_items'             => 'nullable|array',
            'honor_items.*.nama'      => 'nullable|string|max:255',
            'honor_items.*.jumlah'    => 'nullable|integer|min:0',
            'honor_items.*.harga'     => 'nullable|numeric|min:0',

            'sewa_items'              => 'nullable|array',
            'sewa_items.*.nama'       => 'nullable|string|max:255',
            'sewa_items.*.jumlah'     => 'nullable|integer|min:0',
            'sewa_items.*.harga'      => 'nullable|numeric|min:0',

            'dokumentasi_items'       => 'nullable|array',
            'dokumentasi_items.*.jumlah' => 'nullable|integer|min:0',
            'dokumentasi_items.*.harga'  => 'nullable|numeric|min:0',

            'transportasi_items'      => 'nullable|array',
            'transportasi_items.*.jumlah' => 'nullable|integer|min:0',
            'transportasi_items.*.harga'  => 'nullable|numeric|min:0',

            'kebersihan_keterangan'   => 'nullable|string',
            'kebersihan_biaya'        => 'nullable|numeric|min:0',
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
                'tempat'          => $validated['tempat'],
                'file_proposal'   => $filePath,
                'status'          => 'pending',
                'tipe_lokasi'     => $validated['tipe_lokasi'] ?? null,
                'anggaran'        => $validated['anggaran'] ?? 0,
                'kebersihan_keterangan' => $validated['kebersihan_keterangan'] ?? null,
                'kebersihan_biaya'      => $validated['kebersihan_biaya'] ?? 0,
            ]);

            $this->syncItems($proposal, $request);

            session(['last_kode_proposal' => $proposal->kode_proposal]);
        });

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal berhasil diajukan dengan kode: ' . session('last_kode_proposal'));
    }

    public function show(Proposal $proposal)
    {
        // Pastikan relasi di-load sesuai penamaan baru atau penamaan generic 'items'
        $proposal->load(['user', 'activity', 'period', 'items']);
        return view('proposals.show', compact('proposal'));
    }



    public function edit(Proposal $proposal)
    {
        $user = Auth::user();
        if ($user->id !== $proposal->user_id && !in_array($user->role, ['bem', 'admin'])) {
            abort(403, 'Anda tidak berhak mengedit proposal ini.');
        }

        // DIUBAH: Load semua relasi kategori anggaran dinamis yang baru
        $proposal->load([
            'konsumsiItems', 
            'atkItems', 
            'honorItems', 
            'sewaItems', 
            'dokumentasiItems', 
            'transportasiItems'
        ]);

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
            'tempat'          => 'required|string|max:255',
            'file_proposal'   => 'nullable|file|mimes:pdf|max:5120',
            
            // DIUBAH: tipe_lokasi & anggaran sekarang nullable (boleh kosong)
            'tipe_lokasi'     => 'nullable|in:internal,eksternal',
            'anggaran'        => 'nullable|numeric|min:0',

            // Validasi Kuantitas items diubah menjadi min:0 atau nullable
            'konsumsi_items'         => 'nullable|array',
            'konsumsi_items.*.nama'  => 'nullable|string|max:255',
            'konsumsi_items.*.jumlah'=> 'nullable|integer|min:0', 
            'konsumsi_items.*.harga' => 'nullable|numeric|min:0',

            'atk_items'              => 'nullable|array',
            'atk_items.*.nama'       => 'nullable|string|max:255',
            'atk_items.*.jumlah'     => 'nullable|integer|min:0',
            'atk_items.*.harga'      => 'nullable|numeric|min:0',

            'honor_items'            => 'nullable|array',
            'honor_items.*.nama'     => 'nullable|string|max:255',
            'honor_items.*.jumlah'   => 'nullable|integer|min:0',
            'honor_items.*.harga'    => 'nullable|numeric|min:0',

            'sewa_items'             => 'nullable|array',
            'sewa_items.*.nama'      => 'nullable|string|max:255',
            'sewa_items.*.jumlah'    => 'nullable|integer|min:0',
            'sewa_items.*.harga'     => 'nullable|numeric|min:0',

            'dokumentasi_items'          => 'nullable|array',
            'dokumentasi_items.*.nama'   => 'nullable|string|max:255',
            'dokumentasi_items.*.jumlah' => 'nullable|integer|min:0',
            'dokumentasi_items.*.harga'  => 'nullable|numeric|min:0',

            'transportasi_items'          => 'nullable|array',
            'transportasi_items.*.nama'   => 'nullable|string|max:255',
            'transportasi_items.*.jumlah' => 'nullable|integer|min:0',
            'transportasi_items.*.harga'  => 'nullable|numeric|min:0',

            'kebersihan_keterangan'  => 'nullable|string',
            'kebersihan_biaya'       => 'nullable|numeric|min:0',
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
                'tempat'          => $validated['tempat'],
                'file_proposal'   => $filePath,
                'tipe_lokasi'     => $validated['tipe_lokasi'] ?? null,
                'anggaran'        => $validated['anggaran'] ?? 0, // Fallback ke 0 jika kosong
                'kebersihan_keterangan' => $validated['kebersihan_keterangan'] ?? null,
                'kebersihan_biaya'      => $validated['kebersihan_biaya'] ?? 0,
            ]);

            // Hapus semua item anggaran lama lalu insert ulang (Sync Pattern)
            $proposal->items()->delete();
            $this->syncItems($proposal, $request);
        });

        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Proposal berhasil diperbarui');
    }

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

        $proposal->delete(); 
        return redirect()->route('proposals.index')->with('success', 'Proposal berhasil dihapus');
    }

    // ── Private Helper Dinamis Baru ──────────────────────────────────────────

    /**
     * Memproses mapping array input dinamis dari View ke ProposalItem
     */
    /**
     * Memproses mapping array input dinamis dari View ke ProposalItem
     */
    private function syncItems(Proposal $proposal, Request $request): void
    {
        $rows   = [];
        $urutan = 0;
        $tipe   = $request->input('tipe_lokasi');

        // 1. Definisikan semua kategori yang ada di form
        // Kita masukkan semua kategori agar jika tipe_lokasi kosong/tidak dipilih,
        // item dari kategori lain (seperti konsumsi, atk, honor, sewa) tetap masuk ke database.
        $categories = ['konsumsi', 'atk', 'honor', 'sewa'];

        // 2. Cek kondisional atau masukkan saja ke daftar proses jika ada datanya
        if ($tipe === 'internal') {
            $categories[] = 'dokumentasi';
        } elseif ($tipe === 'eksternal') {
            $categories[] = 'transportasi';
        } else {
            // JIKA tipe_lokasi kosong / tidak diisi, kita tetap pantau dokumentasi & transportasi 
            // agar data yang sempat diinput user tidak hilang begitu saja.
            $categories[] = 'dokumentasi';
            $categories[] = 'transportasi';
        }

        // Looping untuk memproses mass assignment insert data item
        foreach ($categories as $category) {
            $inputName = $category . '_items';
            
            foreach ($request->input($inputName, []) as $item) {
                $nama   = isset($item['nama']) ? trim($item['nama']) : '';
                
                // Jika baris benar-benar kosong (nama kosong, jumlah kosong/0, harga kosong/0), baru kita skip
                if ($nama === '' && (!isset($item['jumlah']) || $item['jumlah'] === '') && (!isset($item['harga']) || $item['harga'] === '')) {
                    continue; 
                }

                // Ambil nilai jumlah asal (bisa 0 atau null jika tidak diisi)
                // Kita gunakan default null atau 0 sesuai keinginan Anda, jangan dipaksa ke max(1, $jumlah)
                $jumlah = $item['jumlah'] !== null && $item['jumlah'] !== '' ? (int)$item['jumlah'] : 0;
                $harga  = $item['harga'] !== null && $item['harga'] !== '' ? (float)$item['harga'] : 0;

                $rows[] = [
                    'proposal_id' => $proposal->id,
                    'tipe'        => $category,
                    'nama'        => $nama ?: null,
                    'jasa'        => null, 
                    'jumlah'      => $jumlah, // Menggunakan nilai asli (bisa 0), tidak dikunci ke minimal 1
                    'harga'       => $harga,
                    'subtotal'    => $jumlah * $harga, // Jika jumlah 0, maka subtotal otomatis 0
                    'urutan'      => $urutan++,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }

        if (!empty($rows)) {
            ProposalItem::insert($rows);
        }
    }
}