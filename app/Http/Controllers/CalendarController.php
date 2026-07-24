<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Tampilkan Kalender Akademik / Kegiatan Ormawa.
     * Menampilkan seluruh agenda kegiatan (dari data Activity/Kegiatan)
     * lengkap dengan indikator warna sesuai status kegiatan, sehingga
     * pada tanggal yang memiliki agenda akan muncul penanda visual.
     */
    public function index()
    {
        $user = Auth::user();

        // Admin & BEM dapat melihat seluruh agenda kegiatan Ormawa.
        // Role lain (ormawa/ukm/hmp) hanya melihat agenda kegiatan miliknya sendiri.
        if (in_array($user->role, ['admin', 'bem'])) {
            $activities = Activity::with(['proposal', 'user'])->get();
        } else {
            $activities = Activity::where('user_id', $user->id)->with(['proposal', 'user'])->get();
        }

        // Konfigurasi warna indikator berdasarkan status kegiatan.
        // Hijau  : kegiatan terjadwal/berlangsung/selesai (agenda berjalan normal)
        // Merah  : kegiatan dibatalkan (perlu perhatian khusus)
        $statusColor = [
            'scheduled' => 'green',
            'ongoing'   => 'green',
            'completed' => 'green',
            'cancelled' => 'red',
        ];

        $statusLabel = [
            'scheduled' => 'Terjadwal',
            'ongoing'   => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $events = $activities->map(function ($activity) use ($statusColor, $statusLabel) {
            // Tanggal kegiatan diambil dari data Activity, jika kosong fallback ke Proposal terkait
            $tanggalMulai   = $activity->tanggal_mulai ?? optional($activity->proposal)->tanggal_mulai;
            $tanggalSelesai = $activity->tanggal_selesai ?? optional($activity->proposal)->tanggal_selesai ?? $tanggalMulai;

            if (!$tanggalMulai) {
                return null;
            }

            $namaKegiatan = $activity->nama_kegiatan ?? optional($activity->proposal)->nama_kegiatan ?? 'Kegiatan Tanpa Nama';

            return [
                'id'          => $activity->id,
                'title'       => $namaKegiatan,
                'start'       => \Carbon\Carbon::parse($tanggalMulai)->format('Y-m-d'),
                'end'         => \Carbon\Carbon::parse($tanggalSelesai)->format('Y-m-d'),
                'status'      => $activity->status,
                'status_label'=> $statusLabel[$activity->status] ?? 'Terjadwal',
                'color'       => $statusColor[$activity->status] ?? 'green',
                'ormawa'      => optional($activity->user)->ormawa_name ?? optional($activity->user)->name,
                'url'         => route('activities.show', $activity->id),
            ];
        })->filter()->values();

        return view('calendar.index', compact('events'));
    }
}
