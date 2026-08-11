<?php

namespace Tests\Feature;

use App\Models\JadwalOperasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JadwalOperasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_open_the_operation_schedule_form(): void
    {
        $user = $this->superadmin();

        $this->actingAs($user)
            ->get(route('jadwal-operasi.create'))
            ->assertOk()
            ->assertSee('Identitas Pasien')
            ->assertSee('Data Pelayanan')
            ->assertSee('Golongan Darah')
            ->assertSee('No. BPJS')
            ->assertSee('Tanggal Jadwal Operasi');
    }

    public function test_superadmin_can_store_an_operation_schedule(): void
    {
        $user = $this->superadmin();

        $response = $this->actingAs($user)->post(route('jadwal-operasi.store'), $this->validPayload());

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('jadwal-operasi.index'));

        $this->assertDatabaseHas('jadwal_operasi', [
            'no_booking' => 'BOOK-000001',
            'no_rm' => 'RM-000123',
            'nama_pasien' => 'Budi Santoso',
            'golongan_darah' => 'O',
            'no_bpjs' => '0001234567890',
            'tipe_pelayanan' => 'Operatif',
            'jenis_pelayanan' => 'Operasi Katarak',
            'no_slip' => 'SLIP-001',
        ]);

        $this->get(route('jadwal-operasi.index'))
            ->assertOk()
            ->assertSee('No. Booking')
            ->assertSee('Tgl. Pengajuan')
            ->assertSee('serverSide: true', false)
            ->assertSee('jadwal-operasi\\/data', false);

        $this->getJson(route('jadwal-operasi.data', [
            'draw' => 7,
            'start' => 0,
            'length' => 10,
            'search' => ['value' => 'Budi'],
            'order' => [['column' => 6, 'dir' => 'asc']],
        ]))
            ->assertOk()
            ->assertJsonPath('draw', 7)
            ->assertJsonPath('recordsTotal', 1)
            ->assertJsonPath('recordsFiltered', 1)
            ->assertJsonPath('data.0.no_booking', 'BOOK-000001')
            ->assertJsonPath('data.0.nama_pasien', 'Budi Santoso');
    }

    public function test_required_operation_schedule_fields_are_validated(): void
    {
        $user = $this->superadmin();

        $this->actingAs($user)
            ->post(route('jadwal-operasi.store'), [])
            ->assertSessionHasErrors([
                'no_rm',
                'nama_pasien',
                'tanggal_lahir',
                'tipe_pelayanan',
                'tanggal_jadwal_operasi',
            ]);
    }

    public function test_superadmin_can_edit_and_update_an_operation_schedule(): void
    {
        $user = $this->superadmin();
        $this->actingAs($user)->post(route('jadwal-operasi.store'), $this->validPayload());
        $jadwalOperasi = JadwalOperasi::firstOrFail();

        $this->get(route('jadwal-operasi.edit', $jadwalOperasi))
            ->assertOk()
            ->assertSee('Edit Jadwal Operasi')
            ->assertSee($jadwalOperasi->no_booking)
            ->assertSee('Budi Santoso');

        $updatedPayload = array_merge($this->validPayload(), [
            'nama_pasien' => 'Budi Santoso Utama',
            'jenis_pelayanan' => 'Operasi Katarak Mata Kanan',
        ]);

        $this->patch(route('jadwal-operasi.update', $jadwalOperasi), $updatedPayload)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('jadwal-operasi.index'));

        $this->assertDatabaseHas('jadwal_operasi', [
            'id' => $jadwalOperasi->id,
            'no_booking' => $jadwalOperasi->no_booking,
            'nama_pasien' => 'Budi Santoso Utama',
            'jenis_pelayanan' => 'Operasi Katarak Mata Kanan',
        ]);
    }

    public function test_superadmin_can_delete_an_operation_schedule(): void
    {
        $user = $this->superadmin();
        $this->actingAs($user)->post(route('jadwal-operasi.store'), $this->validPayload());
        $jadwalOperasi = JadwalOperasi::firstOrFail();

        $this->deleteJson(route('jadwal-operasi.destroy', $jadwalOperasi))
            ->assertOk()
            ->assertJsonPath('message', 'Jadwal operasi berhasil dihapus.');

        $this->assertDatabaseMissing('jadwal_operasi', [
            'id' => $jadwalOperasi->id,
        ]);
    }

    public function test_non_superadmin_cannot_manage_operation_schedules(): void
    {
        $user = User::factory()->create([
            'role' => 'pendaftaran',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('jadwal-operasi.index'))
            ->assertForbidden();
    }

    private function superadmin(): User
    {
        return User::factory()->create([
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);
    }

    private function validPayload(): array
    {
        return [
            'no_rm' => 'RM-000123',
            'nama_pasien' => 'Budi Santoso',
            'tanggal_lahir' => '1985-04-12',
            'jenis_kelamin' => 'Laki-laki',
            'golongan_darah' => 'O',
            'status_perkawinan' => 'Kawin',
            'alamat' => 'Jl. Merdeka No. 10',
            'kecamatan' => 'Kota',
            'kabupaten' => 'Kediri',
            'pekerjaan' => 'Wiraswasta',
            'no_ktp' => '3506011204850001',
            'no_bpjs' => '0001234567890',
            'no_telepon' => '081234567890',
            'tanggal_rencana_operasi' => '2026-08-15T09:00',
            'pemberi_instruksi' => 'dr. Siti Aminah, Sp.B',
            'tipe_pelayanan' => 'Operatif',
            'jenis_pelayanan' => 'Operasi Katarak',
            'keterangan_deskripsi' => 'Pasien puasa delapan jam.',
            'no_slip' => 'SLIP-001',
            'tanggal_jadwal_operasi' => '2026-08-16T10:00',
            'tanggal_operasi_tindakan' => null,
        ];
    }
}
