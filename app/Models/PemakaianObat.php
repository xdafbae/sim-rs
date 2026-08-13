<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemakaianObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_pemakaian', 'jadwal_operasi_id', 'no_rm', 'nama_pasien', 'tanggal_lahir',
        'jenis_kelamin', 'status_perkawinan', 'alamat', 'kecamatan', 'kabupaten',
        'pekerjaan', 'no_ktp', 'no_telepon', 'tanggal_pemakaian', 'items',
        'total_biaya', 'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pemakaian' => 'datetime',
        'items' => 'array',
        'total_biaya' => 'decimal:2',
    ];

    public function jadwalOperasi(): BelongsTo
    {
        return $this->belongsTo(JadwalOperasi::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
