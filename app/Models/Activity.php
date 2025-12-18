<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $fillable = [
        'proposal_id', 'user_id', 'status',
        'jumlah_peserta', 'catatan_pelaksanaan'
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lpj(): HasOne
    {
        return $this->hasOne(Lpj::class);
    }

    public function documentations(): HasMany
    {
        return $this->hasMany(Documentation::class);
    }
}