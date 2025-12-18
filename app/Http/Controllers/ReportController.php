<?php


namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Activity;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:proposal,activity,lpj,summary',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'ormawa_id' => 'nullable|exists:users,id'
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        switch ($validated['report_type']) {
            case 'proposal':
                return $this->generateProposalReport($startDate, $endDate, $validated['ormawa_id'] ?? null);
            case 'activity':
                return $this->generateActivityReport($startDate, $endDate, $validated['ormawa_id'] ?? null);
            case 'lpj':
                return $this->generateLpjReport($startDate, $endDate, $validated['ormawa_id'] ?? null);
            case 'summary':
                return $this->generateSummaryReport($startDate, $endDate);
            default:
                return back()->with('error', 'Tipe laporan tidak valid');
        }
    }

    private function generateProposalReport($startDate, $endDate, $ormawaId = null)
    {
        $query = Proposal::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user']);

        if ($ormawaId) {
            $query->where('user_id', $ormawaId);
        }

        $proposals = $query->get();

        $data = [
            'title' => 'Laporan Proposal Kegiatan',
            'period' => $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'),
            'proposals' => $proposals,
            'total' => $proposals->count(),
            'approved' => $proposals->where('status', 'approved_admin')->count(),
            'rejected' => $proposals->where('status', 'rejected')->count(),
        ];

        $pdf = Pdf::loadView('reports.pdf.proposal-report', $data);
        return $pdf->download('Laporan_Proposal_' . now()->format('YmdHis') . '.pdf');
    }

    private function generateActivityReport($startDate, $endDate, $ormawaId = null)
    {
        $query = Activity::whereHas('proposal', function($q) use ($startDate, $endDate) {
            $q->whereBetween('tanggal_mulai', [$startDate, $endDate]);
        })->with(['proposal.user', 'documentations']);

        if ($ormawaId) {
            $query->where('user_id', $ormawaId);
        }

        $activities = $query->get();

        $data = [
            'title' => 'Laporan Kegiatan',
            'period' => $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'),
            'activities' => $activities,
            'total' => $activities->count(),
            'completed' => $activities->where('status', 'completed')->count(),
            'ongoing' => $activities->where('status', 'ongoing')->count(),
        ];

        $pdf = Pdf::loadView('reports.pdf.activity-report', $data);
        return $pdf->download('Laporan_Kegiatan_' . now()->format('YmdHis') . '.pdf');
    }

    private function generateLpjReport($startDate, $endDate, $ormawaId = null)
    {
        $query = Lpj::whereBetween('submitted_at', [$startDate, $endDate])
            ->with(['activity.proposal.user']);

        if ($ormawaId) {
            $query->where('user_id', $ormawaId);
        }

        $lpjs = $query->get();

        $data = [
            'title' => 'Laporan LPJ',
            'period' => $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'),
            'lpjs' => $lpjs,
            'total' => $lpjs->count(),
            'approved' => $lpjs->where('status', 'approved')->count(),
            'pending' => $lpjs->where('status', 'pending')->count(),
            'total_budget' => $lpjs->sum('realisasi_anggaran'),
        ];

        $pdf = Pdf::loadView('reports.pdf.lpj-report', $data);
        return $pdf->download('Laporan_LPJ_' . now()->format('YmdHis') . '.pdf');
    }

    private function generateSummaryReport($startDate, $endDate)
    {
        $proposals = Proposal::whereBetween('created_at', [$startDate, $endDate])->get();
        $activities = Activity::whereHas('proposal', function($q) use ($startDate, $endDate) {
            $q->whereBetween('tanggal_mulai', [$startDate, $endDate]);
        })->get();
        $lpjs = Lpj::whereBetween('submitted_at', [$startDate, $endDate])->get();

        $data = [
            'title' => 'Laporan Ringkasan Kegiatan Ormawa',
            'period' => $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'),
            'proposals_count' => $proposals->count(),
            'approved_proposals' => $proposals->where('status', 'approved_admin')->count(),
            'activities_count' => $activities->count(),
            'completed_activities' => $activities->where('status', 'completed')->count(),
            'lpj_count' => $lpjs->count(),
            'approved_lpj' => $lpjs->where('status', 'approved')->count(),
            'total_budget_planned' => $proposals->where('status', 'approved_admin')->sum('anggaran'),
            'total_budget_realized' => $lpjs->where('status', 'approved')->sum('realisasi_anggaran'),
            'proposals' => $proposals,
            'activities' => $activities,
        ];

        $pdf = Pdf::loadView('reports.pdf.summary-report', $data);
        return $pdf->download('Laporan_Ringkasan_' . now()->format('YmdHis') . '.pdf');
    }

    public function proposalDetail(Proposal $proposal)
    {
        $proposal->load(['user', 'activity.lpj', 'activity.documentations']);

        $pdf = Pdf::loadView('reports.pdf.proposal-detail', compact('proposal'));
        return $pdf->download('Detail_Proposal_' . $proposal->kode_proposal . '.pdf');
    }
}