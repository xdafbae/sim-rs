<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Pelayanan Laboratorium | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        .lab-create .card { box-shadow: none; }
        .lab-create .form-label { margin-bottom: .3rem; font-size: .78rem; font-weight: 600; }
        .lab-create .form-control, .lab-create .form-select { min-height: 34px; font-size: .82rem; }
        .identity-field[readonly] { background: #f8fafc; }
        .visit-panel { min-height: 270px; }
        .result-grid { min-height: 280px; }
        .result-grid th { font-size: .72rem; white-space: nowrap; }
        .result-grid .empty-result td { height: 210px; text-align: center; vertical-align: middle; color: var(--tblr-secondary, #667085); }
        .examination-list { min-height: 260px; }
        .examination-list .category { display: flex; align-items: center; gap: .5rem; padding: .55rem .7rem; border-bottom: 1px solid var(--tblr-border-color, #e6e7e9); font-size: .82rem; }
        .examination-list .category:last-child { border-bottom: 0; }
        .sticky-actions { position: sticky; bottom: 0; z-index: 5; }
    </style>
</head>
<body>
    <a href="#content" class="visually-hidden skip-link">Lewati ke konten utama</a>
    <div class="page">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <main id="content" class="page-body lab-create">
                <div class="container navbar-container py-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <div>
                            <div class="page-pretitle">Laboratorium</div>
                            <h1 class="page-title">Tambah Pelayanan Laboratorium</h1>
                        </div>
                        <a href="{{ route('laboratorium.pelayanan.index') }}" class="btn btn-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>

                    @php($isEditing = isset($pelayanan))
                    <form action="{{ $isEditing ? route('laboratorium.pelayanan.update', $pelayanan) : route('laboratorium.pelayanan.store') }}" method="POST">
                        @csrf
                        @if ($isEditing) @method('PUT') @endif
                        <div class="row g-3">
                            <div class="col-xl-8">
                                <section class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h2 class="card-title mb-0"><i class="bi bi-person-vcard me-2 text-primary"></i>Identitas Pasien</h2>
                                        <button type="button" id="cari-pasien" class="btn btn-primary btn-sm"><i class="bi bi-search me-2"></i>Cari</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-3"><label for="no-rm" class="form-label">No. RM</label><input id="no-rm" name="no_rm" type="search" class="form-control" value="{{ old('no_rm', $pelayanan->no_rm ?? '') }}" placeholder="Masukkan No. RM" required></div>
                                            <div class="col-md-9"><label class="form-label">Nama Pasien</label><input id="nama-pasien" name="nama_pasien" class="form-control identity-field" value="{{ old('nama_pasien', $pelayanan->nama_pasien ?? '') }}" readonly required></div>
                                            <div class="col-md-3"><label class="form-label">Tanggal Lahir</label><input id="tanggal-lahir" name="tanggal_lahir" type="date" class="form-control identity-field" value="{{ old('tanggal_lahir', isset($pelayanan) && $pelayanan->tanggal_lahir ? $pelayanan->tanggal_lahir->format('Y-m-d') : '') }}" readonly></div>
                                            <div class="col-md-4"><label class="form-label">Jenis Kelamin</label><input id="jenis-kelamin" name="jenis_kelamin" class="form-control identity-field" value="{{ old('jenis_kelamin', $pelayanan->jenis_kelamin ?? '') }}" readonly></div>
                                            <div class="col-md-5"><label class="form-label">Status Perkawinan</label><input id="status-perkawinan" name="status_perkawinan" class="form-control identity-field" value="{{ old('status_perkawinan', $pelayanan->status_perkawinan ?? '') }}" readonly></div>
                                            <div class="col-12"><label class="form-label">Alamat</label><input id="alamat" name="alamat" class="form-control identity-field" value="{{ old('alamat', $pelayanan->alamat ?? '') }}" readonly></div>
                                            <div class="col-md-6"><label class="form-label">Kecamatan</label><input id="kecamatan" name="kecamatan" class="form-control identity-field" value="{{ old('kecamatan', $pelayanan->kecamatan ?? '') }}" readonly></div>
                                            <div class="col-md-6"><label class="form-label">Kabupaten</label><input id="kabupaten" name="kabupaten" class="form-control identity-field" value="{{ old('kabupaten', $pelayanan->kabupaten ?? '') }}" readonly></div>
                                            <div class="col-md-4"><label class="form-label">Pekerjaan</label><input id="pekerjaan" name="pekerjaan" class="form-control identity-field" value="{{ old('pekerjaan', $pelayanan->pekerjaan ?? '') }}" readonly></div>
                                            <div class="col-md-4"><label class="form-label">No. Identitas</label><input id="no-identitas" name="no_identitas" class="form-control identity-field" value="{{ old('no_identitas', $pelayanan->no_identitas ?? '') }}" readonly></div>
                                            <div class="col-md-4"><label class="form-label">No. Telepon / HP</label><input id="no-telepon" name="no_telepon" class="form-control identity-field" value="{{ old('no_telepon', $pelayanan->no_telepon ?? '') }}" readonly></div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-xl-4">
                                <section class="card h-100">
                                    <div class="visit-panel d-flex flex-column align-items-center justify-content-center text-secondary text-center p-4">
                                        <i class="bi bi-calendar-x fs-1 mb-2"></i><span>&lt;Tidak ada data untuk ditampilkan&gt;</span>
                                    </div>
                                    <div class="card-footer d-grid gap-2"><button type="button" class="btn btn-white btn-sm">Tampilkan semua Data Kunjungan</button><button type="button" class="btn btn-white btn-sm">Check SEP</button></div>
                                </section>
                            </div>

                            <div class="col-12">
                                <section class="card">
                                    <div class="card-header"><h2 class="card-title mb-0"><i class="bi bi-clipboard2-pulse me-2 text-primary"></i>Data Pemeriksaan</h2></div>
                                    <div class="card-body pb-2">
                                        <div class="row g-3">
                                            <div class="col-md-3"><label class="form-label">No. Pemeriksaan</label><input class="form-control" readonly></div>
                                            <div class="col-md-3"><label class="form-label">Akomodasi</label><input name="cara_bayar" class="form-control" value="{{ old('cara_bayar', $pelayanan->cara_bayar ?? '') }}"></div>
                                            <div class="col-md-3"><label class="form-label">Poliklinik/Ruang</label><input name="poliklinik_ruang" class="form-control" value="{{ old('poliklinik_ruang', $pelayanan->poliklinik_ruang ?? '') }}"></div>
                                            <div class="col-md-2"><label class="form-label">No. TT/Kamar</label><input name="no_kamar_tt" class="form-control" value="{{ old('no_kamar_tt', $pelayanan->no_kamar_tt ?? '') }}"></div>
                                            <div class="col-md-1"><label class="form-label">Kelas</label><input name="kelas" class="form-control" value="{{ old('kelas', $pelayanan->kelas ?? '') }}"></div>
                                            <div class="col-md-2"><label class="form-label">Tgl. Pemeriksaan</label><input name="tanggal_pelayanan" type="datetime-local" class="form-control" value="{{ old('tanggal_pelayanan', isset($pelayanan) ? $pelayanan->tanggal_pelayanan->format('Y-m-d\\TH:i') : now()->format('Y-m-d\\TH:i')) }}" required></div>
                                            <div class="col-md-1"><label class="form-label">Umur (hari)</label><input class="form-control" value="0" readonly></div>
                                            <div class="col-md-1 d-flex align-items-end"><label class="form-check mb-2"><input name="cyto" value="1" class="form-check-input" type="checkbox" @checked(old('cyto', $pelayanan->cyto ?? false))><span class="form-check-label">Cyto</span></label></div>
                                            <div class="col-md-4"><label class="form-label">Instruksi Dokter</label><input name="instruksi_dokter" class="form-control" value="{{ old('instruksi_dokter', $pelayanan->instruksi_dokter ?? '') }}"></div>
                                            <div class="col-md-4"><label class="form-label">Dokter Pemeriksa</label><input name="dokter_pemeriksa" class="form-control" value="{{ old('dokter_pemeriksa', $pelayanan->dokter_pemeriksa ?? '') }}"></div>
                                            <div class="col-md-8"><label class="form-label">Klinis pasien</label><input name="klinis_pasien" class="form-control" value="{{ old('klinis_pasien', $pelayanan->klinis_pasien ?? '') }}"></div>
                                        </div>
                                    </div>

                                    <div class="px-3">
                                        <ul class="nav nav-tabs" id="laboratorium-tabs" role="tablist">
                                            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pemeriksaan" type="button">Pemeriksaan</button></li>
                                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#hasil-simrs" type="button">Hasil SIMRS</button></li>
                                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#riwayat-simrs" type="button">Riwayat SIMRS</button></li>
                                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#hasil-lis" type="button">Hasil LIS</button></li>
                                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#riwayat-lis" type="button">Riwayat LIS</button></li>
                                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pathologi" type="button">Pathologi Anatomi</button></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content border-top">
                                        <div class="tab-pane fade show active" id="pemeriksaan">
                                            <div class="examination-list">
                                                <div class="category fw-semibold text-secondary"><span class="me-5">CHECK</span>JNS. PEMERIKSAAN</div>
                                                @foreach (['CAIRAN TUBUH', 'DIABETES', 'DRUG MONITORING', 'FESES', 'FUNGSI GINJAL', 'FUNGSI HATI', 'HEMATOLOGI'] as $category)
                                                    <label class="category"><input class="form-check-input mt-0" type="checkbox"><i class="bi bi-chevron-right text-secondary"></i>KATEGORI: {{ $category }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="hasil-simrs">@include('laboratorium.pelayanan.partials.result-table', ['columns' => ['TGL. PEMERIKSAAN', 'JNS. PEMERIKSAAN', 'HASIL', 'SATUAN', 'NILAI NORMAL', 'KETERANGAN', 'TGL. RES']])</div>
                                        <div class="tab-pane fade" id="riwayat-simrs">@include('laboratorium.pelayanan.partials.result-table', ['columns' => ['TGL. PEMERIKSAAN', 'CARA MASUK', 'POLIKLINIK/RUANG', 'JNS. PEMERIKSAAN', 'HASIL', 'SATUAN', 'NILAI NORMAL']])</div>
                                        <div class="tab-pane fade" id="hasil-lis">@include('laboratorium.pelayanan.partials.result-table', ['columns' => ['TGL. PEMERIKSAAN', 'JNS. PEMERIKSAAN', 'HASIL LIS', 'SATUAN', 'NILAI NORMAL', 'KETERANGAN']])</div>
                                        <div class="tab-pane fade" id="riwayat-lis">@include('laboratorium.pelayanan.partials.result-table', ['columns' => ['TGL. PEMERIKSAAN', 'CARA MASUK', 'POLIKLINIK/RUANG', 'JNS. PEMERIKSAAN', 'HASIL', 'SATUAN']])</div>
                                        <div class="tab-pane fade" id="pathologi">@include('laboratorium.pelayanan.partials.result-table', ['columns' => ['JNS. PEMERIKSAAN', 'HASIL', 'KETERANGAN']])</div>
                                    </div>
                                    <div class="card-footer d-flex flex-wrap gap-2"><button type="button" class="btn btn-white btn-sm">Load Hasil</button><button type="button" class="btn btn-white btn-sm">Print Hasil</button><button type="button" class="btn btn-white btn-sm">Print Label</button><button type="button" class="btn btn-white btn-sm">TTE</button><button type="submit" class="btn btn-primary btn-sm ms-md-auto"><i class="bi bi-save me-2"></i>{{ $isEditing ? 'Simpan Perubahan' : 'Simpan' }}</button></div>
                                </section>
                            </div>
                        </div>
                        <div class="sticky-actions bg-white border rounded mt-3 px-3 py-2 d-flex justify-content-between align-items-center"><label class="form-check mb-0"><input class="form-check-input" type="checkbox" checked><span class="form-check-label">Menutup form otomatis</span></label><a href="{{ route('laboratorium.pelayanan.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a></div>
                    </form>
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
    <script>
        document.getElementById('cari-pasien').addEventListener('click', async function () {
            const noRm = document.getElementById('no-rm').value.trim();
            if (!noRm) { Swal.fire('No. RM wajib diisi', 'Masukkan No. RM terlebih dahulu.', 'warning'); return; }
            const response = await fetch(`{{ url('laboratorium/pelayanan/cari-pasien') }}/${encodeURIComponent(noRm)}`);
            if (!response.ok) { Swal.fire('Pasien tidak ditemukan', 'No. RM belum tersedia pada data jadwal operasi.', 'warning'); return; }
            const patient = await response.json();
            const fields = { 'nama-pasien': 'nama_pasien', 'tanggal-lahir': 'tanggal_lahir', 'jenis-kelamin': 'jenis_kelamin', 'status-perkawinan': 'status_perkawinan', alamat: 'alamat', kecamatan: 'kecamatan', kabupaten: 'kabupaten', pekerjaan: 'pekerjaan', 'no-identitas': 'no_identitas', 'no-telepon': 'no_telepon' };
            Object.entries(fields).forEach(([id, key]) => document.getElementById(id).value = patient[key] || '');
        });
    </script>
</body>
</html>
