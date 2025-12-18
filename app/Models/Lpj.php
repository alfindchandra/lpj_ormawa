<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lpj extends Model
{
    protected $table = 'lpj';
    
    protected $fillable = [
        'activity_id', 'user_id', 'laporan_kegiatan',
        'realisasi_anggaran', 'kendala', 'solusi',
        'file_lpj', 'status', 'catatan_verifikasi',
        'submitted_at', 'verified_at'
    ];

    protected $casts = [
        'realisasi_anggaran' => 'decimal:2',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime'
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}