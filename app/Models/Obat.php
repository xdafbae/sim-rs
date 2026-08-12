<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'jenis',
        'nama_obat_alkes',
        'kode_obat',
        'nama_obat',
        'detail_kelas_terapi',
        'hna_ppn',
        'hpp',
        'margin',
        'persediaan_rs',
    ];

    protected $casts = [
        'hna_ppn' => 'decimal:2',
        'hpp' => 'decimal:2',
        'margin' => 'decimal:2',
        'persediaan_rs' => 'integer',
    ];
}
