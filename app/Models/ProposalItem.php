<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalItem extends Model
{
    protected $fillable = [
        'proposal_id',
        'tipe',
        'nama',
        'jasa',
        'jumlah',
        'harga',
        'subtotal',
        'urutan',
    ];

    protected $casts = [
        'harga'    => 'decimal:2',
        'subtotal' => 'decimal:2',
        'jumlah'   => 'integer',
        'urutan'   => 'integer',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * Label nama yang ditampilkan (nama atau jasa)
     */
    public function getNamaLabelAttribute(): string
    {
        return $this->nama ?? $this->jasa ?? '-';
    }

    /**
     * Hitung subtotal otomatis
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function (self $item) {
            $item->subtotal = $item->jumlah * $item->harga;
        });
    }
}