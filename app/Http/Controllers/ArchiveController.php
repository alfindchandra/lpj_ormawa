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
        // Gunakan period_id untuk filter yang akurat
        $proposals = Proposal::where('period_id', $period->id)
            ->with(['user', 'activity'])
            ->get();

        $statistics = [
            'total_proposals'      => $proposals->count(),
            'approved'             => $proposals->where('status', 'approved_admin')->count(),
            'rejected'             => $proposals->where('status', 'rejected')->count(),
            'total_activities'     => Activity::whereIn('proposal_id', $proposals->pluck('id'))->count(),
            'completed_activities' => Activity::whereIn('proposal_id', $proposals->pluck('id'))
                ->where('status', 'completed')->count(),
        ];

        return view('archives.show', compact('period', 'proposals', 'statistics'));
    }

    public function exportPDF(Period $period)
    {
        $proposals = Proposal::where('period_id', $period->id)
            ->with(['user', 'activity.lpj'])
            ->get();

        $statistics = [
            'total_proposals' => $proposals->count(),
            'approved'        => $proposals->where('status', 'approved_admin')->count(),
            'rejected'        => $proposals->where('status', 'rejected')->count(),
            'total_budget'    => $proposals->where('status', 'approved_admin')->sum('anggaran'),
        ];

        $pdf = Pdf::loadView('archives.pdf-report', compact('period', 'proposals', 'statistics'));

        $sanitizedName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $period->nama_periode);

        return $pdf->download('Laporan_Kegiatan_' . $sanitizedName . '.pdf');
    }
}