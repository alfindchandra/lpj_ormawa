<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    // Menyimpan Periode Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun_mulai' => 'required|numeric|min:2020|max:2100',
            'tahun_selesai' => 'required|numeric|min:2020|max:2100|gte:tahun_mulai',
        ]);

        $isActive = $request->has('is_active');

        if ($isActive) {
            // Matikan status aktif periode lain jika check-box dicentang
            Period::where('is_active', true)->update(['is_active' => false]);
        }

        Period::create([
            'nama_periode' => $request->nama_periode,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'is_active' => $isActive,
        ]);

        return redirect()->back()->with('success', 'Periode kepengurusan berhasil ditambahkan.');
    }

    // Mengubah Data Kepengurusan (Update)
    public function update(Request $request, Period $period)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun_mulai' => 'required|numeric|min:2020|max:2100',
            'tahun_selesai' => 'required|numeric|min:2020|max:2100|gte:tahun_mulai',
        ]);

        $period->update([
            'nama_periode' => $request->nama_periode,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
        ]);

        return redirect()->back()->with('success', 'Periode kepengurusan berhasil diperbarui.');
    }

    // Mengaktifkan Periode Tertentu via Tombol Unggulan
    public function toggleActive(Period $period)
    {
        // Nonaktifkan semua periode terlebih dahulu
        Period::where('id', '!=', $period->id)->update(['is_active' => false]);

        // Aktifkan periode yang dipilih
        $period->update(['is_active' => true]);

        return redirect()->back()->with('success', "{$period->nama_periode} sekarang menjadi periode aktif.");
    }

    // Menghapus Periode
    public function destroy(Period $period)
    {
        // Mencegah penghapusan jika periode sedang aktif
        if ($period->is_active) {
            return redirect()->back()->with('error', 'Periode aktif tidak dapat dihapus! Alihkan status aktif ke periode lain terlebih dahulu.');
        }

        $period->delete();

        return redirect()->back()->with('success', 'Periode kepengurusan berhasil dihapus.');
    }
}