<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Store a newly created period in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255|unique:periods',
            'tahun_mulai' => 'required|integer|min:2020',
            'tahun_selesai' => 'required|integer|min:2020|gte:tahun_mulai',
        ]);

        Period::create($validated);

        return redirect()->back()->with('success', 'Periode berhasil ditambahkan');
    }

    /**
     * Update the specified period in storage.
     */
    public function update(Request $request, Period $period)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255|unique:periods,nama_periode,' . $period->id,
            'tahun_mulai' => 'required|integer|min:2020',
            'tahun_selesai' => 'required|integer|min:2020|gte:tahun_mulai',
        ]);

        $period->update($validated);

        return redirect()->back()->with('success', 'Periode berhasil diperbarui');
    }

    /**
     * Remove the specified period from storage.
     */
    public function destroy(Period $period)
    {
        // Prevent deletion if period is active
        if ($period->is_active) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus periode yang aktif');
        }

        $period->delete();

        return redirect()->back()->with('success', 'Periode berhasil dihapus');
    }

    /**
     * Activate the specified period.
     */
    public function activate(Period $period)
    {
        // Deactivate all other periods
        Period::where('is_active', true)->update(['is_active' => false]);

        // Activate the selected period
        $period->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Periode ' . $period->nama_periode . ' berhasil diaktifkan');
    }
}
