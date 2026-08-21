<?php

namespace App\Http\Controllers;

use App\Models\JadwalOperasi;
use App\Models\PelayananLaboratorium;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PelayananLaboratoriumController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            abort_unless($request->user()?->role === 'superadmin', 403);

            return $next($request);
        });
    }

    public function index(): View
    {
        return view('laboratorium.pelayanan.index', [
            'pelayanans' => PelayananLaboratorium::latest('tanggal_pelayanan')->get(),
        ]);
    }

    public function create(): View
    {
        return view('laboratorium.pelayanan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $pelayanan = PelayananLaboratorium::create($this->validated($request) + [
            'no_pelayanan' => $this->nomorPelayanan(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('laboratorium.pelayanan.index')->with('success', "Pelayanan {$pelayanan->no_pelayanan} berhasil disimpan.");
    }

    public function edit(PelayananLaboratorium $pelayanan): View
    {
        return view('laboratorium.pelayanan.create', compact('pelayanan'));
    }

    public function update(Request $request, PelayananLaboratorium $pelayanan): RedirectResponse
    {
        $pelayanan->update($this->validated($request));

        return redirect()->route('laboratorium.pelayanan.index')->with('success', "Pelayanan {$pelayanan->no_pelayanan} berhasil diperbarui.");
    }

    public function destroy(PelayananLaboratorium $pelayanan): RedirectResponse
    {
        $pelayanan->delete();

        return redirect()->route('laboratorium.pelayanan.index')->with('success', 'Pelayanan laboratorium berhasil dihapus.');
    }

    public function cariPasien(string $noRm): JsonResponse
    {
        $jadwal = JadwalOperasi::where('no_rm', $noRm)->latest('tanggal_jadwal_operasi')->first();

        if (! $jadwal) {
            return response()->json(['message' => 'Pasien tidak ditemukan.'], 404);
        }

        return response()->json([
            'no_rm' => $jadwal->no_rm,
            'nama_pasien' => $jadwal->nama_pasien,
            'tanggal_lahir' => $jadwal->tanggal_lahir?->format('Y-m-d'),
            'jenis_kelamin' => $jadwal->jenis_kelamin,
            'status_perkawinan' => $jadwal->status_perkawinan,
            'alamat' => $jadwal->alamat,
            'kecamatan' => $jadwal->kecamatan,
            'kabupaten' => $jadwal->kabupaten,
            'pekerjaan' => $jadwal->pekerjaan,
            'no_identitas' => $jadwal->no_ktp,
            'no_telepon' => $jadwal->no_telepon,
        ]);
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'no_rm' => ['required', 'string', 'max:50'],
            'nama_pasien' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'string', 'max:20'],
            'status_perkawinan' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'kabupaten' => ['nullable', 'string', 'max:255'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'no_identitas' => ['nullable', 'string', 'max:32'],
            'no_telepon' => ['nullable', 'string', 'max:30'],
            'tanggal_pelayanan' => ['required', 'date'],
            'cyto' => ['nullable', 'boolean'],
            'cara_masuk' => ['nullable', 'string', 'max:255'],
            'poliklinik_ruang' => ['nullable', 'string', 'max:255'],
            'no_kamar_tt' => ['nullable', 'string', 'max:255'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'cara_bayar' => ['nullable', 'string', 'max:255'],
            'dokter_dpjp' => ['nullable', 'string', 'max:255'],
            'instruksi_dokter' => ['nullable', 'string'],
            'dokter_pemeriksa' => ['nullable', 'string', 'max:255'],
            'pelaksana_petugas' => ['nullable', 'string', 'max:255'],
            'klinis_pasien' => ['nullable', 'string'],
        ]);
        $validated['cyto'] = $request->boolean('cyto');

        return $validated;
    }

    private function nomorPelayanan(): string
    {
        do {
            $nomor = 'LAB-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        } while (PelayananLaboratorium::where('no_pelayanan', $nomor)->exists());

        return $nomor;
    }
}
