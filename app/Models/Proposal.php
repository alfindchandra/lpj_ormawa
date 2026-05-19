<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    protected $fillable = [
        'user_id', 'kode_proposal', 'nama_kegiatan', 'deskripsi',
        'tanggal_mulai', 'tanggal_selesai', 'tipe_lokasi', 'tempat', 
        'barang_diperlukan', 'sewa_tempat', 'jasa', 'bahan',
        'anggaran', 'file_proposal', 'status', 'catatan_bem', 'catatan_admin',
        'internal_items', 'external_items', 'barang_items'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'anggaran' => 'decimal:2',
        'internal_items' => 'array',
        'external_items' => 'array',
        'barang_items' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class);
    }

    public static function generateKodeProposal(): string
    {
        $year = date('Y');
        $month = date('m');
        $latest = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->first();
        
        $number = $latest ? intval(substr($latest->kode_proposal, -4)) + 1 : 1;
        
        return sprintf('PRO-%s%s-%04d', $year, $month, $number);
    }
}