<?php


namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Activity;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $stats = [
                'total_proposals' => Proposal::count(),
                'pending_proposals' => Proposal::where('status', 'pending')->count(),
                'ongoing_activities' => Activity::where('status', 'ongoing')->count(),
                'pending_lpj' => Lpj::where('status', 'pending')->count(),
            ];
            
            $recent_proposals = Proposal::with('user')->latest()->take(5)->get();
            
            return view('dashboard.admin', compact('stats', 'recent_proposals'));
        }
        
        if ($user->role === 'bem') {
            $stats = [
                'pending_proposals' => Proposal::where('status', 'pending')->count(),
                'approved_proposals' => Proposal::where('status', 'approved_bem')->count(),
                'total_activities' => Activity::count(),
            ];
            
            $pending_proposals = Proposal::where('status', 'pending')
                ->with('user')
                ->latest()
                ->get();
            
            return view('dashboard.bem', compact('stats', 'pending_proposals'));
        }
        
        // Ormawa Dashboard
        $stats = [
            'my_proposals' => Proposal::where('user_id', $user->id)->count(),
            'approved' => Proposal::where('user_id', $user->id)
                ->where('status', 'approved_admin')->count(),
            'ongoing' => Activity::where('user_id', $user->id)
                ->where('status', 'ongoing')->count(),
            'completed' => Activity::where('user_id', $user->id)
                ->where('status', 'completed')->count(),
        ];
        
        $my_proposals = Proposal::where('user_id', $user->id)
            ->latest()
            ->get();
        
        return view('dashboard.ormawa', compact('stats', 'my_proposals'));
    }
}
