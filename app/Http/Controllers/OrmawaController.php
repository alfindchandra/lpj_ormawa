<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrmawaController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        
        $total_activities = Activity::where('user_id', $user->id)->count();
        $completed_activities = Activity::where('user_id', $user->id)
            ->where('status', 'completed')->count();
        $ongoing_activities = Activity::where('user_id', $user->id)
            ->where('status', 'ongoing')->count();
        $total_budget = Proposal::where('user_id', $user->id)
            ->where('status', 'approved_admin')->sum('anggaran');
        
        return view('ormawa.profile', compact(
            'total_activities', 
            'completed_activities', 
            'ongoing_activities', 
            'total_budget'
        ));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
        ]);

        Auth::user()->update($validated);

        return redirect()->route('ormawa.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function history()
    {
        $activities = Activity::where('user_id', Auth::id())
            ->whereIn('status', ['completed', 'cancelled'])
            ->with(['proposal', 'lpj', 'documentations'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ormawa.history', compact('activities'));
    }

    public function statistics()
    {
        $user = Auth::user();
        
        // Data untuk charts
        $monthlyData = Activity::where('user_id', $user->id)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $statusData = Activity::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        return view('ormawa.statistics', compact('monthlyData', 'statusData'));
    }

    public function guide()
    {
        return view('ormawa.guide');
    }
}
