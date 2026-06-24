<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    protected $fillable = [
        'user_id', 'period_id', 'kode_proposal', 'nama_kegiatan', 'deskripsi',
        'tanggal_mulai', 'tanggal_selesai', 'tipe_lokasi', 'tempat',
        'anggaran', 'file_proposal', 'status','type', 'catatan_bem', 'catatan_admin',
        
        // Tambahkan ini agar data kebersihan tersimpan aman
        'kebersihan_keterangan', 'kebersihan_biaya', 
    ];

    protected $casts = [
        'tanggal_mulai'  => 'date',
        'tanggal_selesai'=> 'date',
        'anggaran'       => 'decimal:2',
        'kebersihan_biaya'=> 'decimal:2', // Tambahkan cast untuk kebersihan_biaya
    ];

    // ── Relasi ──────────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->orderBy('urutan');
    }

    // Perbarui Method Relasi sesuai dengan kategori yang dinamis sekarang:
    public function konsumsiItems(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->where('tipe', 'konsumsi')->orderBy('urutan');
    }

    public function atkItems(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->where('tipe', 'atk')->orderBy('urutan');
    }

    public function honorItems(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->where('tipe', 'honor')->orderBy('urutan');
    }

    public function sewaItems(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->where('tipe', 'sewa')->orderBy('urutan');
    }

    public function dokumentasiItems(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->where('tipe', 'dokumentasi')->orderBy('urutan');
    }

    public function transportasiItems(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->where('tipe', 'transportasi')->orderBy('urutan');
    }

    // ── Helper ──────────────────────────────────────────────────────────────

    public static function generateKodeProposal(): string
    {
        $year  = date('Y');
        $month = date('m');

        $latest = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->first();

        $number = $latest ? intval(substr($latest->kode_proposal, -4)) + 1 : 1;

        return sprintf('PRO-%s%s-%04d', $year, $month, $number);
    }
}