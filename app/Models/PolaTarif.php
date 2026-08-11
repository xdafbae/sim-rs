<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PolaTarif extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'jenis_pelayanan',
        'kode_pelayanan',
        'instalasi',
        'sub_instalasi',
        'kategori',
        'eklaim',
        'aktif',
        'pelayanan_pendapatan_lain',
        'tanggal_update_terakhir',
        'score',
        'kategori_variabel_eklaim',
    ];

    protected $casts = [
        'eklaim' => 'boolean',
        'aktif' => 'boolean',
        'pelayanan_pendapatan_lain' => 'boolean',
        'tanggal_update_terakhir' => 'date',
        'score' => 'decimal:2',
    ];
}
