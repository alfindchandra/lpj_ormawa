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
        $periods = Period::orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::getActive();

        // Filter berdasarkan periode yang dipilih
        $selectedPeriodId = $request->get('period_id', $activePeriod?->id);

        // Kabinet aktif (masa jabatan saat ini)
        $kabinetsAktif = Kabinet::where('is_active', true)
            ->with('period')
            ->orderBy('ormawa_type')
            ->get();

        // Kabinet riwayat (masa sebelumnya), difilter per periode jika dipilih
        $riwayatQuery = Kabinet::where('is_active', false)->with('period');

        if ($selectedPeriodId) {
            $riwayatQuery->where('period_id', $selectedPeriodId);
        }

        $kabinetsRiwayat = $riwayatQuery->orderBy('ormawa_type')
            ->orderBy('tanggal_dilantik', 'desc')
            ->get();

        // Proposal yang terkait dengan periode terpilih
        $proposalsPeriode = [];
        if ($selectedPeriodId) {
            $selectedPeriod = Period::find($selectedPeriodId);
            if ($selectedPeriod) {
                $proposalsPeriode = $selectedPeriod->proposals()
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();
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
        $periods = Period::orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::getActive();
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
        $validated = $request->validate([
            'period_id'        => 'required|exists:periods,id',
            'ormawa_type'      => 'required|in:bem,hmp,ukm',
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
    $periods = Period::orderBy('tahun_mulai', 'desc')->get();
    $activePeriod = Period::getActive();
    
    // Ambil daftar nama ormawa yang valid untuk dipilih
    $ormawas = \App\Models\User::select('ormawa_name', 'role as ormawa_type')
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
        $validated = $request->validate([
            'period_id'        => 'required|exists:periods,id',
            'ormawa_type'      => 'required|in:bem,hmp,ukm',
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
        $kabinet->update(['is_active' => !$kabinet->is_active]);

        $status = $kabinet->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Kabinet {$kabinet->ormawa_name} berhasil {$status}!");
    }
}
