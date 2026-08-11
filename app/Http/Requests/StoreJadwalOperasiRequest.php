<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJadwalOperasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'superadmin';
    }

    public function rules(): array
    {
        return [
            'no_rm' => ['required', 'string', 'max:50'],
            'nama_pasien' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'golongan_darah' => ['nullable', Rule::in(['A', 'B', 'AB', 'O'])],
            'status_perkawinan' => ['required', Rule::in(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])],
            'alamat' => ['required', 'string', 'max:1000'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kabupaten' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'max:32'],
            'no_bpjs' => ['nullable', 'string', 'max:30'],
            'no_telepon' => ['required', 'string', 'max:30'],
            'tanggal_rencana_operasi' => ['required', 'date'],
            'pemberi_instruksi' => ['required', 'string', 'max:255'],
            'tipe_pelayanan' => ['required', Rule::in(['Operatif', 'Non Operatif'])],
            'jenis_pelayanan' => ['required', 'string', 'max:255'],
            'keterangan_deskripsi' => ['nullable', 'string', 'max:2000'],
            'no_slip' => ['nullable', 'string', 'max:100'],
            'tanggal_jadwal_operasi' => ['required', 'date'],
            'tanggal_operasi_tindakan' => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'no_rm' => 'No. RM',
            'nama_pasien' => 'nama pasien',
            'tanggal_lahir' => 'tanggal lahir',
            'jenis_kelamin' => 'jenis kelamin',
            'golongan_darah' => 'golongan darah',
            'status_perkawinan' => 'status perkawinan',
            'no_ktp' => 'No. KTP',
            'no_bpjs' => 'No. BPJS',
            'no_telepon' => 'No. telepon/HP',
            'tanggal_rencana_operasi' => 'tanggal rencana operasi',
            'pemberi_instruksi' => 'dokter/petugas pemberi instruksi',
            'tipe_pelayanan' => 'tipe pelayanan',
            'jenis_pelayanan' => 'jenis pelayanan',
            'keterangan_deskripsi' => 'keterangan/deskripsi',
            'no_slip' => 'No. slip',
            'tanggal_jadwal_operasi' => 'tanggal jadwal operasi',
            'tanggal_operasi_tindakan' => 'tanggal operasi/tindakan',
        ];
    }
}
