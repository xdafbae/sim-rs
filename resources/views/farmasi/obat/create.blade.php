<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ isset($obat) ? 'Edit' : 'Tambah' }} Obat | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
</head>

<body>
    <div class="page">@include('layouts.navbar') @include('layouts.sidebar')
        <div class="page-wrapper">
            <main class="page-body">
                <div class="container navbar-container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div class="page-pretitle">Modul Farmasi</div>
                            <h1 class="page-title">{{ isset($obat) ? 'Edit' : 'Tambah' }} Obat / Alkes</h1>
                        </div><a href="{{ route('farmasi.obat.index') }}" class="btn btn-white"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>
                    <form action="{{ isset($obat) ? route('farmasi.obat.update', $obat) : route('farmasi.obat.store') }}" method="POST"><input type="hidden" name="_token" value="{{ csrf_token() }}">@isset($obat) @method('PUT') @endisset
                        <section class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4"><label class="form-label" for="kode">Kode</label><input id="kode" name="kode" value="{{ old('kode', $obat->kode ?? $kodeObat ?? '') }}" class="form-control @error('kode') is-invalid @enderror" readonly required>@error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-4"><label class="form-label" for="jenis">Jenis Obat / Alkes <span class="text-danger">*</span></label><input id="jenis" name="jenis" value="{{ old('jenis', $obat->jenis ?? '') }}" class="form-control @error('jenis') is-invalid @enderror" placeholder="Contoh: Obat" required>@error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-4"><label class="form-label" for="kode_obat">Kode Obat</label><input id="kode_obat" name="kode_obat" value="{{ old('kode_obat', $obat->kode_obat ?? '') }}" class="form-control"></div>
                                    <div class="col-md-6"><label class="form-label" for="nama_obat_alkes">Nama Obat / Alkes <span class="text-danger">*</span></label><input id="nama_obat_alkes" name="nama_obat_alkes" value="{{ old('nama_obat_alkes', $obat->nama_obat_alkes ?? '') }}" class="form-control @error('nama_obat_alkes') is-invalid @enderror" required>@error('nama_obat_alkes')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-6"><label class="form-label" for="nama_obat">Nama Obat</label><input id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat ?? '') }}" class="form-control"></div>
                                    <div class="col-md-6"><label class="form-label" for="detail_kelas_terapi">Detail Kelas Terapi</label><input id="detail_kelas_terapi" name="detail_kelas_terapi" value="{{ old('detail_kelas_terapi', $obat->detail_kelas_terapi ?? '') }}" class="form-control"></div>
                                    <div class="col-md-2"><label class="form-label" for="hna_ppn">HNA + PPN <span class="text-danger">*</span></label><input id="hna_ppn" name="hna_ppn" type="number" min="0" step="0.01" value="{{ old('hna_ppn', $obat->hna_ppn ?? 0) }}" class="form-control @error('hna_ppn') is-invalid @enderror" required>@error('hna_ppn')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-2"><label class="form-label" for="hpp">HPP <span class="text-danger">*</span></label><input id="hpp" name="hpp" type="number" min="0" step="0.01" value="{{ old('hpp', $obat->hpp ?? 0) }}" class="form-control @error('hpp') is-invalid @enderror" required>@error('hpp')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-2"><label class="form-label" for="margin">Margin (%) <span class="text-danger">*</span></label><input id="margin" name="margin" type="number" min="0" step="0.01" value="{{ old('margin', $obat->margin ?? 0) }}" class="form-control @error('margin') is-invalid @enderror" required>@error('margin')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                    <div class="col-md-2"><label class="form-label" for="persediaan_rs">Persediaan RS <span class="text-danger">*</span></label><input id="persediaan_rs" name="persediaan_rs" type="number" min="0" value="{{ old('persediaan_rs', $obat->persediaan_rs ?? 0) }}" class="form-control @error('persediaan_rs') is-invalid @enderror" required>@error('persediaan_rs')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                </div>
                            </div>
                            <div class="card-footer text-end"><div class="d-inline-flex gap-2"><a href="{{ route('farmasi.obat.index') }}" class="btn btn-outline-secondary">Batal</a><button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button></div></div>
                        </section>
                    </form>
                </div>
            </main>@include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
</body>

</html>
