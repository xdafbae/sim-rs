<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_transaksi', 'no_rm', 'no_copy_resep', 'nama_pasien', 'tanggal_lahir',
        'jenis_kelamin', 'status_pasien', 'alamat', 'kecamatan', 'kabupaten',
        'pekerjaan', 'no_ktp', 'telepon', 'akomodasi', 'berat_badan', 'tanggal',
        'nama_dokter', 'jasa_farmasi', 'items',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal' => 'datetime',
        'jasa_farmasi' => 'boolean',
        'items' => 'array',
        'akomodasi' => 'decimal:2',
    ];
}
