<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabinet extends Model
{
    protected $fillable = [
        'period_id',
        'ormawa_type',
        'ormawa_name',
        'nama_kabinet',
        'nama_ketua',
        'nama_wakil',
        'nama_bendahara',
        'nama_sekretaris',
        'tanggal_dilantik',
        'tanggal_selesai',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_dilantik' => 'date',
        'tanggal_selesai'  => 'date',
        'is_active'        => 'boolean',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Scope: kabinet yang sedang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: kabinet yang sudah selesai (riwayat)
     */
    public function scopeArchived($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Label tampilan tipe ormawa
     */
    public function getOrmawaTipeLabelAttribute(): string
    {
        return match ($this->ormawa_type) {
            'bem' => 'BEM',
            'hmp' => 'HMP',
            'ukm' => 'UKM',
            default => strtoupper($this->ormawa_type),
        };
    }

    /**
     * Apakah masa jabatan sudah berakhir berdasarkan tanggal
     */
    public function getSudahSelesaiAttribute(): bool
    {
        return $this->tanggal_selesai && $this->tanggal_selesai->isPast();
    }

    /**
     * Durasi masa jabatan dalam bulan
     */
    public function getDurasiAttribute(): string
    {
        if (!$this->tanggal_dilantik || !$this->tanggal_selesai) {
            return '-';
        }
        $months = $this->tanggal_dilantik->diffInMonths($this->tanggal_selesai);
        return $months . ' bulan';
    }
}
