<?php

namespace App\Http\Controllers;

use App\Models\JadwalOperasi;
use App\Models\Obat;
use App\Models\PemakaianObat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PemakaianObatController extends Controller
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
        return view('pemakaian-obat.index', [
            'pemakaianObats' => PemakaianObat::with('jadwalOperasi')->latest('tanggal_pemakaian')->get(),
        ]);
    }

    public function create(): View
    {
        $obats = Obat::orderBy('nama_obat_alkes')->get();

        return view('pemakaian-obat.create', [
            'jadwalOperasi' => JadwalOperasi::latest('tanggal_jadwal_operasi')->get(),
            'obats' => $obats,
            'obatOptions' => $obats->mapWithKeys(fn (Obat $obat): array => [
                $obat->id => [
                    'id' => $obat->id,
                    'kode' => $obat->kode,
                    'nama' => $obat->nama_obat_alkes,
                    'hja' => round((float) $obat->hna_ppn * (1 + ((float) $obat->margin / 100)), 2),
                ],
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jadwal_operasi_id' => ['required', 'integer', 'exists:jadwal_operasi,id'],
            'tanggal_pemakaian' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.obat_id' => ['required', 'integer', 'distinct', 'exists:obats,id'],
            'items.*.debet' => ['required', 'integer', 'min:1'],
            'items.*.kredit' => ['required', 'integer', 'min:0'],
        ], [
            'jadwal_operasi_id.required' => 'Pasien dari jadwal operasi wajib dipilih.',
            'items.required' => 'Tambahkan minimal satu obat atau alkes.',
            'items.min' => 'Tambahkan minimal satu obat atau alkes.',
            'items.*.obat_id.distinct' => 'Obat atau alkes yang sama hanya boleh ditambahkan sekali.',
        ]);

        $jadwal = JadwalOperasi::findOrFail($validated['jadwal_operasi_id']);
        $obats = Obat::whereIn('id', collect($validated['items'])->pluck('obat_id'))->get()->keyBy('id');
        $items = [];

        foreach ($validated['items'] as $item) {
            $debet = (int) $item['debet'];
            $kredit = (int) $item['kredit'];

            if ($kredit > $debet) {
                throw ValidationException::withMessages([
                    'items' => 'Jumlah kredit tidak boleh melebihi jumlah debet.',
                ]);
            }

            $obat = $obats->get((int) $item['obat_id']);
            $hja = round((float) $obat->hna_ppn * (1 + ((float) $obat->margin / 100)), 2);
            $biaya = round(($debet - $kredit) * $hja, 2);
            $items[] = [
                'obat_id' => $obat->id,
                'kode' => $obat->kode,
                'nama' => $obat->nama_obat_alkes,
                'hja' => $hja,
                'debet' => $debet,
                'kredit' => $kredit,
                'biaya' => $biaya,
            ];
        }

        DB::transaction(function () use ($request, $validated, $jadwal, $items): void {
            PemakaianObat::create([
                'no_pemakaian' => $this->nomorPemakaian(),
                'jadwal_operasi_id' => $jadwal->id,
                'no_rm' => $jadwal->no_rm,
                'nama_pasien' => $jadwal->nama_pasien,
                'tanggal_lahir' => $jadwal->tanggal_lahir,
                'jenis_kelamin' => $jadwal->jenis_kelamin,
                'status_perkawinan' => $jadwal->status_perkawinan,
                'alamat' => $jadwal->alamat,
                'kecamatan' => $jadwal->kecamatan,
                'kabupaten' => $jadwal->kabupaten,
                'pekerjaan' => $jadwal->pekerjaan,
                'no_ktp' => $jadwal->no_ktp,
                'no_telepon' => $jadwal->no_telepon,
                'tanggal_pemakaian' => $validated['tanggal_pemakaian'],
                'items' => $items,
                'total_biaya' => collect($items)->sum('biaya'),
                'created_by' => $request->user()->id,
            ]);
        });

        return redirect()->route('pemakaian-obat.index')->with('success', 'Pemakaian obat berhasil disimpan.');
    }

    public function destroy(PemakaianObat $pemakaianObat): RedirectResponse
    {
        $pemakaianObat->delete();

        return redirect()->route('pemakaian-obat.index')->with('success', 'Pemakaian obat berhasil dihapus.');
    }

    private function nomorPemakaian(): string
    {
        do {
            $nomor = 'PO-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        } while (PemakaianObat::where('no_pemakaian', $nomor)->exists());

        return $nomor;
    }
}
