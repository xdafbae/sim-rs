<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php($isEdit = isset($polaTarif))

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isEdit ? 'Edit' : 'Tambah' }} Pola Tarif | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        .text-sm {
            font-size: .875rem;
        }

        .page-body {
            background: #f6f8fc;
        }

        .form-hero {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            background: linear-gradient(110deg, #0891b2, #06b6d4);
            color: #fff;
            box-shadow: 0 12px 28px rgba(6, 182, 212, .2);
        }

        .form-hero::after {
            position: absolute;
            top: -95px;
            right: -30px;
            width: 260px;
            height: 260px;
            border: 42px solid rgba(255, 255, 255, .16);
            border-radius: 50%;
            content: '';
        }

        .form-hero>* {
            position: relative;
            z-index: 1;
        }

        .hero-icon,
        .section-icon {
            display: grid;
            width: 54px;
            height: 54px;
            place-items: center;
            border-radius: 14px;
        }

        .hero-icon {
            background: rgba(255, 255, 255, .16);
            font-size: 1.7rem;
        }

        .section-icon {
            background: #e9f3ff;
            color: #1672d3;
            font-size: 1.5rem;
        }

        .form-card {
            border: 1px solid #e4e8ef;
            box-shadow: 0 8px 24px rgba(31, 41, 55, .05);
        }

        .form-card .card-header {
            padding: 1.5rem;
            background: #fbfcfe;
        }

        .form-section-label {
            color: #778395;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .05em;
        }

        .tab-content-box {
            border: 1px solid var(--tblr-border-color);
            border-top: 0;
        }

        .action-bar {
            position: sticky;
            bottom: 0;
            z-index: 5;
            box-shadow: 0 -8px 20px rgba(31, 41, 55, .08);
        }
    </style>
</head>

<body>
    <a href="#content" class="visually-hidden skip-link">Lewati ke konten utama</a>
    <div class="page">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <main id="content" class="page-body">
                <div class="container navbar-container">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('pola_tarif.show') }}">Pola Tarif</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                                </ol>
                            </nav>
                            <h2 class="page-title">{{ $isEdit ? 'Edit' : 'Tambah' }} Pola Tarif Pelayanan</h2>
                        </div>
                        <a href="{{ route('pola_tarif.show') }}" class="btn btn-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                    <section class="form-hero p-4 p-md-5 mb-4">
                        <div class="d-flex align-items-start gap-3">
                            <span class="hero-icon flex-shrink-0"><i class="bi bi-clipboard2-check"></i></span>
                            <div>
                                <h2 class="mb-1 text-white">Formulir Pola Tarif</h2>
                                <p class="mb-3 text-white-50">Lengkapi informasi pelayanan dan tarif sebelum menyimpan data.</p>
                                <div class="d-flex flex-wrap gap-4 small"><span><i class="bi bi-hash me-1"></i>Kode pelayanan harus unik</span><span><i class="bi bi-asterisk me-1"></i>Kolom bertanda * wajib diisi</span></div>
                            </div>
                        </div>
                    </section>
                    <form action="{{ $isEdit ? route('pola_tarif.update', $polaTarif) : route('pola_tarif.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($isEdit) @method('PUT') @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="card form-card mb-3">
                                    <div class="card-header d-flex align-items-center gap-3"><span class="section-icon"><i class="bi bi-hospital"></i></span>
                                        <div>
                                            <h3 class="card-title mb-1">Data Pelayanan</h3>
                                            <div class="text-muted text-sm">Masukkan identitas dan pengaturan dasar pelayanan.</div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-section-label mb-3">INFORMASI UTAMA</div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium text-sm" for="kode_pelayanan">Kode Pelayanan <span class="text-danger">*</span></label>
                                            <input id="kode_pelayanan" name="kode_pelayanan" type="text" class="form-control text-sm @error('kode_pelayanan') is-invalid @enderror" value="{{ old('kode_pelayanan', $polaTarif->kode_pelayanan ?? $kodePelayananOtomatis) }}" readonly required>
                                                    @error('kode_pelayanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium text-sm" for="instalasi">Instalasi <span class="text-danger">*</span></label>
                                                    <select id="instalasi" name="instalasi" class="form-select text-sm @error('instalasi') is-invalid @enderror" required>
                                                        <option value="" disabled @selected(!old('instalasi', $polaTarif->instalasi ?? null))>Pilih Instalasi</option>
                                                        <option value="Instalasi Gawat Darurat" @selected(old('instalasi', $polaTarif->instalasi ?? null) === 'Instalasi Gawat Darurat')>Instalasi Gawat Darurat</option>
                                                        <option value="Instalasi Rawat Jalan" @selected(old('instalasi', $polaTarif->instalasi ?? null) === 'Instalasi Rawat Jalan')>Instalasi Rawat Jalan</option>
                                                        <option value="Instalasi Rawat Inap" @selected(old('instalasi', $polaTarif->instalasi ?? null) === 'Instalasi Rawat Inap')>Instalasi Rawat Inap</option>
                                                    </select>
                                                    @error('instalasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium text-sm" for="sub_instalasi">Sub Instalasi/ Unit/ Bagian/ Ruang</label>
                                                    <input id="sub_instalasi" name="sub_instalasi" type="text" class="form-control text-sm @error('sub_instalasi') is-invalid @enderror" value="{{ old('sub_instalasi', $polaTarif->sub_instalasi ?? '') }}" placeholder="Masukkan Sub Instalasi">
                                                    @error('sub_instalasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium text-sm" for="kategori">Kategori/ Tingkat Pelayanan <span class="text-danger">*</span></label>
                                                    <input id="kategori" name="kategori" type="text" class="form-control text-sm @error('kategori') is-invalid @enderror" value="{{ old('kategori', $polaTarif->kategori ?? '') }}" placeholder="Masukkan Kategori Pelayanan" required>
                                                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label class="form-label fw-medium text-sm" for="jenis_pelayanan">Jenis Pelayanan <span class="text-danger">*</span></label>
                                                    <input id="jenis_pelayanan" name="jenis_pelayanan" type="text" class="form-control text-sm @error('jenis_pelayanan') is-invalid @enderror" value="{{ old('jenis_pelayanan', $polaTarif->jenis_pelayanan ?? '') }}" placeholder="Masukkan Jenis Pelayanan" required>
                                                    @error('jenis_pelayanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="text-black-50 my-4">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-6 mb-2 mb-md-0">
                                                <div class="form-check">
                                                    <input type="hidden" name="aktif" value="0">
                                                    <input class="form-check-input" name="aktif" value="1" type="checkbox" id="pelayananAktif" @checked(old('aktif', $polaTarif->aktif ?? true))>
                                                    <label class="form-check-label fw-medium text-sm" for="pelayananAktif">Pelayanan AKTIF</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted" style="font-size: .75rem;" for="tanggal_update_terakhir">Tanggal update terakhir</label>
                                                <div class="input-group input-group-sm">
                                                    <input id="tanggal_update_terakhir" name="tanggal_update_terakhir" type="date" class="form-control @error('tanggal_update_terakhir') is-invalid @enderror" value="{{ old('tanggal_update_terakhir', $isEdit && $polaTarif->tanggal_update_terakhir ? $polaTarif->tanggal_update_terakhir->format('Y-m-d') : now()->format('Y-m-d')) }}">
                                                    <button id="set-today" class="btn btn-outline-primary" type="button">New</button>
                                                </div>
                                                @error('tanggal_update_terakhir')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-4">
                                            <div class="col-md-6 mb-2 mb-md-0">
                                                <div class="form-check">
                                                    <input type="hidden" name="pelayanan_pendapatan_lain" value="0">
                                                    <input class="form-check-input" name="pelayanan_pendapatan_lain" value="1" type="checkbox" id="pendapatanLain" @checked(old('pelayanan_pendapatan_lain', $polaTarif->pelayanan_pendapatan_lain ?? false))>
                                                    <label class="form-check-label fw-medium text-sm" for="pendapatanLain">Pelayanan/ Pendapatan Lain</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted" style="font-size: .75rem;" for="score">Score</label>
                                                <input id="score" name="score" type="number" class="form-control form-control-sm @error('score') is-invalid @enderror" value="{{ old('score', $polaTarif->score ?? '1.00') }}" step="0.01" min="0">
                                                @error('score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <hr class="text-black-50 my-4">
                                        <div class="mb-2">
                                            <label class="form-label fw-medium text-sm" for="kategori_variabel_eklaim">Kategori Variabel E-Klaim</label>
                                            <input id="kategori_variabel_eklaim" name="kategori_variabel_eklaim" type="text" class="form-control text-sm @error('kategori_variabel_eklaim') is-invalid @enderror" value="{{ old('kategori_variabel_eklaim', $polaTarif->kategori_variabel_eklaim ?? '') }}" placeholder="Masukkan Variabel E-Klaim">
                                            @error('kategori_variabel_eklaim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <input type="hidden" name="eklaim" value="0">
                                        <div class="mt-4">
                                            <ul class="nav nav-tabs text-sm" id="tabelPelayananTab" role="tablist">
                                                <li class="nav-item"><button class="nav-link active py-2 px-3" data-bs-toggle="tab" data-bs-target="#tarif" type="button">Tarif per Kelas</button></li>
                                                <li class="nav-item"><button class="nav-link py-2 px-3" data-bs-toggle="tab" data-bs-target="#sarana" type="button">Detail Jasa Sarana</button></li>
                                                <li class="nav-item"><button class="nav-link py-2 px-3" data-bs-toggle="tab" data-bs-target="#pelayanan" type="button">Detail Jasa Pelayanan</button></li>
                                                <li class="nav-item"><button class="nav-link py-2 px-3" data-bs-toggle="tab" data-bs-target="#detail" type="button">Detail Pelayanan</button></li>
                                            </ul>
                                            <div class="tab-content tab-content-box p-3 text-sm">
                                                <div class="tab-pane fade show active" id="tarif">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped mb-0 text-center align-middle">
                                                            <thead class="table-light text-secondary">
                                                                <tr>
                                                                    <th>KELAS</th>
                                                                    <th>JS.SARANA</th>
                                                                    <th>JS.PELAYANAN</th>
                                                                    <th>BAHP</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="4" class="text-muted py-5">&lt;No data to display&gt;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="sarana">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped mb-0 text-center align-middle">
                                                            <thead class="table-light text-secondary">
                                                                <tr>
                                                                    <th>NAMA KOMPONEN SARANA</th>
                                                                    <th>PERSENTASE (%)</th>
                                                                    <th>NOMINAL (Rp)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="3" class="text-muted py-5">&lt;No data to display&gt;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="pelayanan">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped mb-0 text-center align-middle">
                                                            <thead class="table-light text-secondary">
                                                                <tr>
                                                                    <th>JENIS TENAGA MEDIS</th>
                                                                    <th>TINDAKAN</th>
                                                                    <th>NOMINAL (Rp)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="3" class="text-muted py-5">&lt;No data to display&gt;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="detail">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped mb-0 text-center align-middle">
                                                            <thead class="table-light text-secondary">
                                                                <tr>
                                                                    <th>KODE TINDAKAN</th>
                                                                    <th>DESKRIPSI PELAYANAN</th>
                                                                    <th>KETERANGAN</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="3" class="text-muted py-5">&lt;No data to display&gt;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="action-bar bg-white p-3 p-md-4 border-top rounded-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-3">
                                                    <div class="text-muted text-sm"><i class="bi bi-info-square me-2"></i>Periksa kembali data pelayanan sebelum menyimpan.</div>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('pola_tarif.show') }}" class="btn btn-outline-secondary px-4 text-sm">Batal</a>
                                                        <button type="submit" class="btn btn-primary px-4 text-sm"><i class="bi bi-save me-2"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
    <script>
        document.getElementById('set-today').addEventListener('click', function() {
            document.getElementById('tanggal_update_terakhir').value = new Date().toISOString().slice(0, 10);
        });
    </script>
</body>

</html>
