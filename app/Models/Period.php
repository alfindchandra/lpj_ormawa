<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    protected $fillable = [
        'nama_periode', 'tahun_mulai', 'tahun_selesai', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function kabinets(): HasMany
    {
        return $this->hasMany(Kabinet::class);
    }

    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * Ambil periode yang sedang aktif
     */
    public static function getActive(): ?self
    {
        return self::where('is_active', true)->first();
    }
}