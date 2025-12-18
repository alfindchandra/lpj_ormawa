<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'nama_periode', 'tahun_mulai', 'tahun_selesai', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}