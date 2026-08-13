<?php

namespace Tests\Feature;

use App\Models\JadwalOperasi;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PemakaianObatTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_open_the_medicine_usage_form(): void
    {
        $jadwal = $this->jadwalOperasi();
        $obat = $this->obat();

        $this->actingAs($this->superadmin())
            ->get(route('pemakaian-obat.create'))
            ->assertOk()
            ->assertSee('Input Pemakaian Obat / Alkes')
            ->assertSee('Pilih Pasien dari Jadwal Operasi')
            ->assertSee($jadwal->nama_pasien)
            ->assertSee($obat->nama_obat_alkes);
    }

    public function test_superadmin_can_store_usage_with_identity_from_operation_schedule(): void
    {
        $jadwal = $this->jadwalOperasi();
        $obat = $this->obat();

        $response = $this->actingAs($this->superadmin())->post(route('pemakaian-obat.store'), [
            'jadwal_operasi_id' => $jadwal->id,
            'tanggal_pemakaian' => '2026-08-16T11:30',
            'nama_pasien' => 'Nama yang dimanipulasi',
            'items' => [[
                'obat_id' => $obat->id,
                'debet' => 3,
                'kredit' => 1,
                'hja' => 1,
            ]],
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('pemakaian-obat.index'));

        $this->assertDatabaseHas('pemakaian_obats', [
            'jadwal_operasi_id' => $jadwal->id,
            'no_rm' => $jadwal->no_rm,
            'nama_pasien' => $jadwal->nama_pasien,
            'total_biaya' => 22000,
        ]);

        $pemakaian = \App\Models\PemakaianObat::firstOrFail();
        $this->assertSame('Paracetamol 500 mg', $pemakaian->items[0]['nama']);
        $this->assertEquals(11000, $pemakaian->items[0]['hja']);
        $this->assertEquals(22000, $pemakaian->items[0]['biaya']);
    }

    public function test_operation_schedule_and_at_least_one_valid_item_are_required(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('pemakaian-obat.store'), [])
            ->assertSessionHasErrors(['jadwal_operasi_id', 'tanggal_pemakaian', 'items']);
    }

    public function test_credit_cannot_exceed_debit(): void
    {
        $jadwal = $this->jadwalOperasi();
        $obat = $this->obat();

        $this->actingAs($this->superadmin())->post(route('pemakaian-obat.store'), [
            'jadwal_operasi_id' => $jadwal->id,
            'tanggal_pemakaian' => '2026-08-16T11:30',
            'items' => [['obat_id' => $obat->id, 'debet' => 1, 'kredit' => 2]],
        ])->assertSessionHasErrors('items');

        $this->assertDatabaseCount('pemakaian_obats', 0);
    }

    public function test_non_superadmin_cannot_manage_medicine_usage(): void
    {
        $user = User::factory()->create(['role' => 'pendaftaran', 'email_verified_at' => now()]);

        $this->actingAs($user)->get(route('pemakaian-obat.index'))->assertForbidden();
    }

    private function superadmin(): User
    {
        return User::factory()->create(['role' => 'superadmin', 'email_verified_at' => now()]);
    }

    private function jadwalOperasi(): JadwalOperasi
    {
        return JadwalOperasi::create([
            'no_rm' => 'RM-000123',
            'nama_pasien' => 'Budi Santoso',
            'tanggal_lahir' => '1985-04-12',
            'jenis_kelamin' => 'Laki-laki',
            'status_perkawinan' => 'Kawin',
            'alamat' => 'Jl. Merdeka No. 10',
            'kecamatan' => 'Kota',
            'kabupaten' => 'Kediri',
            'pekerjaan' => 'Wiraswasta',
            'no_ktp' => '3506011204850001',
            'no_telepon' => '081234567890',
            'tanggal_rencana_operasi' => '2026-08-15 09:00:00',
            'pemberi_instruksi' => 'dr. Siti Aminah, Sp.B',
            'tipe_pelayanan' => 'Operatif',
            'jenis_pelayanan' => 'Operasi Katarak',
            'tanggal_jadwal_operasi' => '2026-08-16 10:00:00',
        ]);
    }

    private function obat(): Obat
    {
        return Obat::create([
            'kode' => 'OBT-001',
            'jenis' => 'Obat',
            'nama_obat_alkes' => 'Paracetamol 500 mg',
            'hna_ppn' => 10000,
            'hpp' => 9000,
            'margin' => 10,
            'persediaan_rs' => 100,
        ]);
    }
}
