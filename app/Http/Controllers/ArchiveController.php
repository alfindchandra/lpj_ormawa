<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Proposal;
use App\Models\Activity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ArchiveController extends Controller
{
    public function index()
    {
        $periods = Period::orderBy('tahun_mulai', 'desc')->get();
        $activePeriod = Period::where('is_active', true)->first();
        
        return view('archives.index', compact('periods', 'activePeriod'));
    }

    public function show(Period $period)
    {
        $proposals = Proposal::whereHas('user', function($q) use ($period) {
            // Filter berdasarkan created_at dalam rentang periode
            $startDate = $period->tahun_mulai . '-01-01';
            $endDate = $period->tahun_selesai . '-12-31';
        })->whereBetween('created_at', [
            $period->tahun_mulai . '-01-01',
            $period->tahun_selesai . '-12-31'
        ])->with(['user', 'activity'])->get();

        $statistics = [
            'total_proposals' => $proposals->count(),
            'approved' => $proposals->where('status', 'approved_admin')->count(),
            'rejected' => $proposals->where('status', 'rejected')->count(),
            'total_activities' => Activity::whereIn('proposal_id', $proposals->pluck('id'))->count(),
            'completed_activities' => Activity::whereIn('proposal_id', $proposals->pluck('id'))
                ->where('status', 'completed')->count(),
        ];

        return view('archives.show', compact('period', 'proposals', 'statistics'));
    }

    public function exportPDF(Period $period)
    {
        $proposals = Proposal::whereBetween('created_at', [
            $period->tahun_mulai . '-01-01',
            $period->tahun_selesai . '-12-31'
        ])->with(['user', 'activity.lpj'])->get();

        $statistics = [
            'total_proposals' => $proposals->count(),
            'approved' => $proposals->where('status', 'approved_admin')->count(),
            'rejected' => $proposals->where('status', 'rejected')->count(),
            'total_budget' => $proposals->where('status', 'approved_admin')->sum('anggaran'),
        ];

        $pdf = Pdf::loadView('archives.pdf-report', compact('period', 'proposals', 'statistics'));
        
        return $pdf->download('Laporan_Kegiatan_' . $period->nama_periode . '.pdf');
    }
}