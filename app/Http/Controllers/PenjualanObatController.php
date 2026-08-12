<?php

namespace App\Http\Controllers;

use App\Models\PenjualanObat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PenjualanObatController extends Controller
{
    public function index(): View
    {
        return view('farmasi.penjualan_obat.index', [
            'penjualanObats' => PenjualanObat::latest('tanggal')->get(),
        ]);
    }

    public function create(): View
    {
        return view('farmasi.penjualan_obat.create', [
            'nomorTransaksi' => $this->nomorTransaksi(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PenjualanObat::create($this->validatedData($request));

        return redirect()->route('farmasi.penjualan-obat.index')->with('success', 'Penjualan obat berhasil disimpan.');
    }

    public function edit(PenjualanObat $penjualanObat): View
    {
        return view('farmasi.penjualan_obat.create', compact('penjualanObat'));
    }

    public function update(Request $request, PenjualanObat $penjualanObat): RedirectResponse
    {
        $penjualanObat->update($this->validatedData($request, $penjualanObat));

        return redirect()->route('farmasi.penjualan-obat.index')->with('success', 'Penjualan obat berhasil diperbarui.');
    }

    public function destroy(PenjualanObat $penjualanObat): RedirectResponse
    {
        $penjualanObat->delete();

        return redirect()->route('farmasi.penjualan-obat.index')->with('success', 'Penjualan obat berhasil dihapus.');
    }

    private function validatedData(Request $request, ?PenjualanObat $penjualanObat = null): array
    {
        $uniqueTransaction = ['required', 'string', 'max:30', 'unique:penjualan_obats,no_transaksi'];
        if ($penjualanObat) {
            $uniqueTransaction[3] .= ',' . $penjualanObat->id;
        }

        $validated = $request->validate([
            'no_transaksi' => $uniqueTransaction,
            'no_rm' => ['required', 'string', 'max:30'],
            'no_copy_resep' => ['nullable', 'string', 'max:50'],
            'nama_pasien' => ['required', 'string', 'max:150'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'string', 'max:20'],
            'status_pasien' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kabupaten' => ['nullable', 'string', 'max:100'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'no_ktp' => ['nullable', 'string', 'max:30'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'akomodasi' => ['nullable', 'numeric', 'min:0'],
            'berat_badan' => ['nullable', 'integer', 'min:0'],
            'tanggal' => ['required', 'date'],
            'nama_dokter' => ['nullable', 'string', 'max:150'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.nama' => ['required', 'string', 'max:150'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.harga' => ['required', 'numeric', 'min:0'],
            'items.*.signa' => ['nullable', 'string', 'max:150'],
        ]);

        $validated['jasa_farmasi'] = $request->boolean('jasa_farmasi');
        $validated['items'] = array_map(fn ($item) => [
            'nama' => $item['nama'], 'qty' => (int) $item['qty'],
            'harga' => (float) $item['harga'], 'signa' => $item['signa'] ?? null,
        ], $validated['items']);

        return $validated;
    }

    private function nomorTransaksi(): string
    {
        do {
            $nomor = 'TRX-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        } while (PenjualanObat::where('no_transaksi', $nomor)->exists());

        return $nomor;
    }
}
