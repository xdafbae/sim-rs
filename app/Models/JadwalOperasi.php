<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalOperasi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_operasi';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'status_perkawinan',
        'alamat',
        'kecamatan',
        'kabupaten',
        'pekerjaan',
        'no_ktp',
        'no_bpjs',
        'no_telepon',
        'tanggal_rencana_operasi',
        'pemberi_instruksi',
        'tipe_pelayanan',
        'jenis_pelayanan',
        'keterangan_deskripsi',
        'no_slip',
        'tanggal_jadwal_operasi',
        'tanggal_operasi_tindakan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_rencana_operasi' => 'datetime',
        'tanggal_jadwal_operasi' => 'datetime',
        'tanggal_operasi_tindakan' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (JadwalOperasi $jadwalOperasi): void {
            if (! $jadwalOperasi->no_booking) {
                $jadwalOperasi->forceFill([
                    'no_booking' => 'BOOK-'.str_pad((string) $jadwalOperasi->getKey(), 6, '0', STR_PAD_LEFT),
                ])->saveQuietly();
            }
        });
    }
}
