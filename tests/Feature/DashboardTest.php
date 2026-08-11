<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_view_the_tabler_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Selamat datang, Super Admin')
            ->assertSee('Data Registrasi Pasien')
            ->assertSee('Pendaftaran')
            ->assertSee('Operatif / Non Operatif')
            ->assertSeeInOrder([
                'Alkes',
                'Jadwal Operasi',
                'Pemakaian Obat',
                'Pelayanan Operatif',
            ])
            ->assertSee('Anggaran &amp; Perbendaharaan', false)
            ->assertSee('Administrator')
            ->assertSee('templates/templates/dist/css/tabler.css', false)
            ->assertSee('templates/templates/dist/js/tabler.js', false);
    }
}
