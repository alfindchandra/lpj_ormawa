<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Proposal;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
        $user = Auth::user();

        $query = Proposal::where('period_id', $period->id)
            ->with(['user', 'activity']);

        if (!in_array($user->role, ['admin', 'bem'])) {
            $query->where('user_id', $user->id);
        }

        $proposals = $query->latest()->get();
        $proposalIds = $proposals->pluck('id');

        $statistics = [
            'total_proposals'      => $proposals->count(),
            'approved'             => $proposals->where('status', 'approved_admin')->count(),
            'rejected'             => $proposals->where('status', 'rejected')->count(),
            'total_activities'     => Activity::whereIn('proposal_id', $proposalIds)->count(),
            'completed_activities' => Activity::whereIn('proposal_id', $proposalIds)
                ->where('status', 'completed')
                ->count(),
        ];

        return view('archives.show', compact('period', 'proposals', 'statistics'));
    }

    public function exportPDF(Period $period)
    {
        // 1. PERBAIKAN: Ambil data user login untuk filter keamanan data
        $user = Auth::user();

        // 2. PERBAIKAN: Gunakan pola query conditional agar sinkron dengan halaman index/show
        $query = Proposal::where('period_id', $period->id)
            ->with(['user', 'activity.lpj']);

        // Jika bukan admin/bem, batasi hanya mengunduh data miliknya sendiri
        if (!in_array($user->role, ['admin', 'bem'])) {
            $query->where('user_id', $user->id);
        }

        $proposals = $query->get();

        // 3. Statistik budget & proposal otomatis menyesuaikan dengan data yang sudah terfilter
        $statistics = [
            'total_proposals' => $proposals->count(),
            'approved'        => $proposals->where('status', 'approved_admin')->count(),
            'rejected'        => $proposals->where('status', 'rejected')->count(),
            'total_budget'    => $proposals->where('status', 'approved_admin')->sum('anggaran'),
        ];

        $pdf = Pdf::loadView('archives.pdf-report', compact('period', 'proposals', 'statistics'));

        // Sanitasi nama file agar aman dari karakter aneh
        $sanitizedName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $period->nama_periode);

        return $pdf->download('Laporan_Kegiatan_' . $sanitizedName . '.pdf');
    }
}