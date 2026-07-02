<?php

namespace App\Http\Controllers;

use App\Models\Kabinet;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class KabinetController extends Controller
{
    /**
     * Tampilkan daftar pengurus inti (aktif + riwayat)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $periods = Period::orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();

        // Filter berdasarkan periode yang dipilih
        $selectedPeriodId = $request->get('period_id', $activePeriod?->id);

        // ── 1. LOGIK FILTER KABINET AKTIF ──────────────────────────────────
        $aktifQuery = Kabinet::where('is_active', true)->with('period');

        // Jika user adalah ukm, hmp, atau ormawa, batasi hanya melihat nama ormawa mereka sendiri
        if (in_array($user->role, ['ukm', 'hmp', 'ormawa'])) {
            $aktifQuery->where('ormawa_name', $user->ormawa_name);
        }

        $kabinetsAktif = $aktifQuery->orderBy('ormawa_type')->get();


        // ── 2. LOGIK FILTER RIWAYAT KABINET ────────────────────────────────
        $riwayatQuery = Kabinet::where('is_active', false)->with('period');

        // Batasi riwayat kepengurusan jika user ber-role ukm, hmp, atau ormawa
        if (in_array($user->role, ['ukm', 'hmp', 'ormawa'])) {
            $riwayatQuery->where('ormawa_name', $user->ormawa_name);
        }

        if ($selectedPeriodId) {
            $riwayatQuery->where('period_id', $selectedPeriodId);
        }

        $kabinetsRiwayat = $riwayatQuery->orderBy('ormawa_type')
            ->orderBy('tanggal_dilantik', 'desc')
            ->get();


        // ── 3. LOGIK FILTER PROPOSAL PER PERIODE ───────────────────────────
        $proposalsPeriode = collect(); 
        
        if ($selectedPeriodId) {
            $selectedPeriod = Period::find($selectedPeriodId);
            if ($selectedPeriod) {
                $proposalQuery = $selectedPeriod->proposals()->with('user');

                if (in_array($user->role, ['ukm', 'hmp', 'ormawa'])) {
                    $proposalQuery->where('user_id', $user->id);
                }

                $proposalsPeriode = $proposalQuery->orderBy('created_at', 'desc')->get();
            }
        }

        return view('kabinet.index', compact(
            'periods',
            'activePeriod',
            'selectedPeriodId',
            'kabinetsAktif',
            'kabinetsRiwayat',
            'proposalsPeriode'
        ));
    }

    /**
     * Form tambah pengurus inti
     */
    public function create()
    {
        $user = Auth::user();
        
        // Sudah tepat: admin, bem, dan ormawa diperbolehkan
        if (!in_array($user->role, ['admin', 'bem', 'ormawa'])) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data pengurus.');
        }

        $periods = Period::orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();
        $ormawas = User::select('ormawa_name', 'role as ormawa_type')
            ->whereNotNull('ormawa_name')
            ->distinct()
            ->orderBy('ormawa_name')
            ->get();
            
        return view('kabinet.create', compact('periods', 'activePeriod', 'ormawas'));
    }

    /**
     * Simpan pengurus inti baru
     */
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bem', 'ormawa'])) {
            abort(403, 'Aksi dilarang.');
        }

        $validated = $request->validate([
            'period_id'        => 'required|exists:periods,id',
            'ormawa_type'      => 'required|in:bem,hmp,ukm,ormawa',
            'ormawa_name'      => 'required|string|max:100',
            'nama_kabinet'     => 'nullable|string|max:150',
            'nama_ketua'       => 'required|string|max:100',
            'nama_wakil'       => 'nullable|string|max:100',
            'nama_bendahara'   => 'nullable|string|max:100',
            'nama_sekretaris'  => 'nullable|string|max:100',
            'tanggal_dilantik' => 'required|date',
            'tanggal_selesai'  => 'required|date|after:tanggal_dilantik',
            'is_active'        => 'boolean',
            'keterangan'       => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Kabinet::create($validated);

        return redirect()->route('kabinet.index')
            ->with('success', 'Data pengurus inti berhasil ditambahkan!');
    }

    /**
     * Form edit pengurus inti
     */
    public function edit(Kabinet $kabinet)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'bem', 'ormawa'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data pengurus.');
        }

        $periods = Period::orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();
        
        $ormawas = User::select('ormawa_name', 'role as ormawa_type')
            ->whereNotNull('ormawa_name')
            ->distinct()
            ->orderBy('ormawa_name')
            ->get();

        return view('kabinet.edit', compact('kabinet', 'periods', 'activePeriod', 'ormawas'));
    }

    /**
     * Update pengurus inti
     */
    public function update(Request $request, Kabinet $kabinet)
    {
        if (!in_array(Auth::user()->role, ['admin', 'bem', 'ormawa'])) {
            abort(403, 'Aksi dilarang.');
        }

        $validated = $request->validate([
            'period_id'        => 'required|exists:periods,id',
            // 🛠️ PERBAIKAN: Menambahkan 'ormawa' ke aturan validasi agar tidak error saat disimpan
            'ormawa_type'      => 'required|in:bem,hmp,ukm,ormawa',
            'ormawa_name'      => 'required|string|max:100',
            'nama_kabinet'     => 'nullable|string|max:150',
            'nama_ketua'       => 'required|string|max:100',
            'nama_wakil'       => 'nullable|string|max:100',
            'nama_bendahara'   => 'nullable|string|max:100',
            'nama_sekretaris'  => 'nullable|string|max:100',
            'tanggal_dilantik' => 'required|date',
            'tanggal_selesai'  => 'required|date|after:tanggal_dilantik',
            'is_active'        => 'boolean',
            'keterangan'       => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $kabinet->update($validated);

        return redirect()->route('kabinet.index')
            ->with('success', 'Data pengurus inti berhasil diperbarui!');
    }

    /**
     * Hapus pengurus inti
     */
    public function destroy(Kabinet $kabinet)
    {
        if (!in_array(Auth::user()->role, ['admin'])) {
            abort(403, 'Aksi dilarang.');
        }

        if ($kabinet->is_active) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kabinet yang sedang aktif!');
        }

        $kabinet->delete();

        return redirect()->route('kabinet.index')
            ->with('success', 'Data pengurus inti berhasil dihapus!');
    }

    /**
     * Aktifkan/nonaktifkan kabinet
     */
    public function toggleActive(Kabinet $kabinet)
    {
        // 🛠️ PERBAIKAN: Menambahkan 'ormawa' ke dalam daftar role yang diizinkan mengarsipkan kabinet
        if (!in_array(Auth::user()->role, ['admin', 'bem', 'ormawa'])) {
            abort(403, 'Aksi dilarang.');
        }

        $kabinet->update(['is_active' => !$kabinet->is_active]);
        $status = $kabinet->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Kabinet {$kabinet->ormawa_name} berhasil {$status}!");
    }
}