<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ObatController extends Controller
{
    public function index(): View
    {
        return view('farmasi.obat.index', [
            'obats' => Obat::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('farmasi.obat.create', [
            'kodeObat' => $this->generateKodeObat(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['kode'] = $this->generateKodeObat();
        Obat::create($data);

        return redirect()->route('farmasi.obat.index')->with('success', 'Data obat/alkes berhasil ditambahkan.');
    }

    public function edit(Obat $obat): View
    {
        return view('farmasi.obat.create', compact('obat'));
    }

    public function update(Request $request, Obat $obat): RedirectResponse
    {
        $obat->update($this->validatedData($request, $obat));

        return redirect()->route('farmasi.obat.index')->with('success', 'Data obat/alkes berhasil diperbarui.');
    }

    public function destroy(Obat $obat): RedirectResponse
    {
        $obat->delete();

        return redirect()->route('farmasi.obat.index')->with('success', 'Data obat/alkes berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Obat $obat = null): array
    {
        return $request->validate([
            'kode' => ['required', 'string', 'max:30', Rule::unique('obats', 'kode')->ignore($obat)],
            'jenis' => ['required', 'string', 'max:100'],
            'nama_obat_alkes' => ['required', 'string', 'max:150'],
            'kode_obat' => ['nullable', 'string', 'max:50'],
            'nama_obat' => ['nullable', 'string', 'max:150'],
            'detail_kelas_terapi' => ['nullable', 'string', 'max:150'],
            'hna_ppn' => ['required', 'numeric', 'min:0'],
            'hpp' => ['required', 'numeric', 'min:0'],
            'margin' => ['required', 'numeric', 'min:0'],
            'persediaan_rs' => ['required', 'integer', 'min:0'],
        ]);
    }

    private function generateKodeObat(): string
    {
        do {
            $kode = 'OBT-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        } while (Obat::where('kode', $kode)->exists());

        return $kode;
    }
}
