<?php

namespace App\Http\Controllers;

use App\Models\PolaTarif;
use Illuminate\Http\Request;

class PolaTarifController extends Controller
{
    public function show()
    {
        return view('administrator.pola_tarif.show', [
            'polaTarifs' => PolaTarif::latest()->get(),
        ]);
    }

    public function create()
    {
        $nomorTerakhir = PolaTarif::query()
            ->pluck('kode_pelayanan')
            ->map(function ($kode) {
                return preg_match('/^PL-(\d+)$/', $kode, $matches)
                    ? (int) $matches[1]
                    : 0;
            })
            ->max();

        return view('administrator.pola_tarif.create', [
            'kodePelayananOtomatis' => 'PL-' . str_pad(($nomorTerakhir ?? 0) + 1, 4, '0', STR_PAD_LEFT),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);

        PolaTarif::create($validated);

        return redirect()->route('pola_tarif.show')->with('success', 'Pola tarif berhasil ditambahkan.');
    }

    public function edit(PolaTarif $polaTarif)
    {
        return view('administrator.pola_tarif.create', [
            'polaTarif' => $polaTarif,
            'kodePelayananOtomatis' => $polaTarif->kode_pelayanan,
        ]);
    }

    public function update(Request $request, PolaTarif $polaTarif)
    {
        $polaTarif->update($this->validatedData($request, $polaTarif));

        return redirect()->route('pola_tarif.show')->with('success', 'Pola tarif berhasil diperbarui.');
    }

    public function destroy(PolaTarif $polaTarif)
    {
        $polaTarif->delete();

        return redirect()->route('pola_tarif.show')->with('success', 'Pola tarif berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate(['ids' => ['required', 'array', 'min:1'], 'ids.*' => ['integer', 'exists:pola_tarifs,id']]);
        PolaTarif::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('pola_tarif.show')->with('success', count($validated['ids']) . ' pola tarif berhasil dihapus.');
    }

    private function validatedData(Request $request, ?PolaTarif $polaTarif = null): array
    {
        $uniqueCode = ['required', 'string', 'max:50', 'unique:pola_tarifs,kode_pelayanan'];
        if ($polaTarif) {
            $uniqueCode[3] .= ',' . $polaTarif->id;
        }

        $validated = $request->validate([
            'jenis_pelayanan' => ['required', 'string', 'max:100'],
            'kode_pelayanan' => $uniqueCode,
            'instalasi' => ['required', 'string', 'max:100'],
            'sub_instalasi' => ['nullable', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:100'],
            'eklaim' => ['nullable', 'boolean'],
            'aktif' => ['nullable', 'boolean'],
            'pelayanan_pendapatan_lain' => ['nullable', 'boolean'],
            'tanggal_update_terakhir' => ['nullable', 'date'],
            'score' => ['nullable', 'numeric', 'min:0'],
            'kategori_variabel_eklaim' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['eklaim'] = $request->boolean('eklaim');
        $validated['aktif'] = $request->boolean('aktif');
        $validated['pelayanan_pendapatan_lain'] = $request->boolean('pelayanan_pendapatan_lain');

        return $validated;
    }
}
