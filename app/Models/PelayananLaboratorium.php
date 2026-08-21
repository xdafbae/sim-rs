<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PelayananLaboratorium extends Model
{
    use HasFactory;

    protected $table = 'pelayanan_laboratorium';

    protected $fillable = [
        'no_pelayanan',
        'no_rm',
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_perkawinan',
        'alamat',
        'kecamatan',
        'kabupaten',
        'pekerjaan',
        'no_identitas',
        'no_telepon',
        'tanggal_pelayanan',
        'cyto',
        'cara_masuk',
        'poliklinik_ruang',
        'no_kamar_tt',
        'kelas',
        'cara_bayar',
        'dokter_dpjp',
        'instruksi_dokter',
        'dokter_pemeriksa',
        'pelaksana_petugas',
        'klinis_pasien',
        'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pelayanan' => 'datetime',
        'cyto' => 'boolean',
    ];

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
