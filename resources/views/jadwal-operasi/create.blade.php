<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php($isEdit = isset($jadwalOperasi))
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isEdit ? 'Edit' : 'Tambah' }} Jadwal Operasi | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        .schedule-form-hero {
            overflow: hidden;
            border: 0;
            background: linear-gradient(135deg, #155eef 0%, #0ea5e9 100%);
            box-shadow: 0 12px 30px rgba(21, 94, 239, .16);
            color: #fff;
        }

        .schedule-form-hero::after {
            position: absolute;
            top: -90px;
            right: -50px;
            width: 240px;
            height: 240px;
            border: 42px solid rgba(255, 255, 255, .09);
            border-radius: 50%;
            content: '';
        }

        .hero-icon,
        .section-icon {
            display: grid;
            flex: 0 0 auto;
            place-items: center;
            border-radius: 14px;
        }

        .hero-icon {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, .16);
        }

        .section-card {
            overflow: hidden;
            border: 1px solid rgba(98, 105, 118, .14);
            box-shadow: 0 4px 18px rgba(31, 41, 55, .05);
        }

        .section-card .card-header {
            min-height: auto;
            padding: 1.25rem 1.5rem;
            background: var(--tblr-bg-surface-secondary, #f8fafc);
        }

        .section-icon {
            width: 42px;
            height: 42px;
            background: var(--tblr-primary-lt, #e8efff);
            color: var(--tblr-primary, #206bc4);
        }

        .section-kicker {
            margin-bottom: .15rem;
            color: var(--tblr-primary, #206bc4);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .form-subsection + .form-subsection {
            margin-top: 1.75rem;
            padding-top: 1.75rem;
            border-top: 1px solid var(--tblr-border-color, #e6e7e9);
        }

        .form-subsection-title {
            margin-bottom: 1rem;
            color: var(--tblr-secondary-color, #626976);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .schedule-form .form-label {
            margin-bottom: .45rem;
            font-weight: 600;
        }

        .schedule-form .form-control,
        .schedule-form .form-select {
            min-height: 44px;
            border-color: #d9dee7;
            border-radius: .55rem;
        }

        .schedule-form textarea.form-control {
            min-height: 88px;
        }

        .schedule-form .form-control:focus,
        .schedule-form .form-select:focus {
            border-color: #80aaff;
            box-shadow: 0 0 0 .2rem rgba(32, 107, 196, .1);
        }

        .service-type-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
        }

        .service-type-label {
            display: flex;
            align-items: center;
            min-height: 68px;
            padding: .85rem 1rem;
            border: 1px solid #d9dee7;
            border-radius: .65rem;
            background: var(--tblr-bg-surface, #fff);
            cursor: pointer;
            transition: border-color .15s ease, background-color .15s ease, box-shadow .15s ease;
        }

        .btn-check:checked + .service-type-label {
            border-color: var(--tblr-primary, #206bc4);
            background: var(--tblr-primary-lt, #e8efff);
            box-shadow: 0 0 0 1px var(--tblr-primary, #206bc4);
        }

        .service-type-mark {
            display: grid;
            width: 34px;
            height: 34px;
            margin-right: .75rem;
            place-items: center;
            border-radius: 10px;
            background: rgba(32, 107, 196, .1);
            color: var(--tblr-primary, #206bc4);
        }

        .schedule-panel {
            height: 100%;
            padding: 1.25rem;
            border: 1px solid rgba(32, 107, 196, .16);
            border-radius: .75rem;
            background: rgba(32, 107, 196, .035);
        }

        .form-action-bar {
            position: sticky;
            z-index: 20;
            bottom: 0;
            margin-top: 1rem;
            padding: .9rem 1rem;
            border: 1px solid rgba(98, 105, 118, .16);
            border-radius: .75rem;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 -6px 24px rgba(31, 41, 55, .08);
            backdrop-filter: blur(8px);
        }

        [data-bs-theme="dark"] .form-action-bar {
            background: rgba(24, 36, 51, .94);
        }

        @media (max-width: 575.98px) {
            .service-type-grid {
                grid-template-columns: 1fr;
            }

            .section-card .card-header,
            .section-card .card-body {
                padding-right: 1rem;
                padding-left: 1rem;
            }
        }
    </style>
</head>
<body>
    <a href="#content" class="visually-hidden skip-link">Lewati ke konten utama</a>
    <div class="page">
        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container navbar-container">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <ol class="breadcrumb breadcrumb-arrows mb-2" aria-label="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('jadwal-operasi.index') }}">Jadwal Operasi</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
                            </ol>
                            <h1 class="page-title">{{ $isEdit ? 'Edit' : 'Registrasi' }} Jadwal Operasi</h1>
                        </div>
                        <div class="col-auto ms-auto">
                            <a href="{{ route('jadwal-operasi.index') }}" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" aria-hidden="true"><path d="M5 12h14" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <main id="content" class="page-body">
                <div class="container navbar-container">
                    <section class="card schedule-form-hero position-relative mb-4" aria-labelledby="form-intro-title">
                        <div class="card-body position-relative z-1 p-4">
                            <div class="d-flex align-items-start gap-3">
                                <span class="hero-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                                </span>
                                <div>
                                    <h2 id="form-intro-title" class="h2 text-white mb-1">{{ $isEdit ? 'Perbarui' : 'Formulir' }} Jadwal Operasi</h2>
                                    <p class="mb-3 text-white opacity-75">{{ $isEdit ? 'Periksa dan perbarui data jadwal operasi yang diperlukan.' : 'Lengkapi identitas pasien dan informasi pelayanan sebelum menyimpan jadwal.' }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-white-lt text-white px-3 py-2">{{ $isEdit ? 'No. booking: '.$jadwalOperasi->no_booking : 'No. booking dibuat otomatis' }}</span>
                                        <span class="badge bg-white-lt text-white px-3 py-2">Kolom bertanda * wajib diisi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    @if ($errors->any())
                        <script>
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: 'error',
                                title: 'Data belum dapat disimpan. Periksa kembali kolom yang ditandai!',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        </script>
                    @endif

                    <form action="{{ $isEdit ? route('jadwal-operasi.update', $jadwalOperasi) : route('jadwal-operasi.store') }}" method="POST" class="schedule-form">
                        @csrf
                        @if ($isEdit)
                            @method('PATCH')
                        @endif
                        <section class="card section-card mb-4" aria-labelledby="patient-section-title">
                            <div class="card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="section-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                    </span>
                                    <div>
                                        <div class="section-kicker">Bagian 1 dari 2</div>
                                        <h2 id="patient-section-title" class="card-title mb-1">Identitas Pasien</h2>
                                        <div class="text-secondary small">Pastikan data sesuai dengan rekam medis pasien.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="form-subsection">
                                    <div class="form-subsection-title">Informasi Utama</div>
                                    <div class="row g-3">
                                        <div class="col-md-4 col-lg-3">
                                            <label for="no_rm" class="form-label required">No. RM</label>
                                            <input id="no_rm" name="no_rm" type="text" value="{{ old('no_rm', $isEdit ? $jadwalOperasi->no_rm : '') }}" class="form-control @error('no_rm') is-invalid @enderror" placeholder="Contoh: RM-000123" maxlength="50" autocomplete="off" required autofocus>
                                            @error('no_rm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-8 col-lg-5">
                                            <label for="nama_pasien" class="form-label required">Nama Pasien</label>
                                            <input id="nama_pasien" name="nama_pasien" type="text" value="{{ old('nama_pasien', $isEdit ? $jadwalOperasi->nama_pasien : '') }}" class="form-control @error('nama_pasien') is-invalid @enderror" placeholder="Nama lengkap sesuai identitas" maxlength="255" autocomplete="name" required>
                                            @error('nama_pasien')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                            <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                                            <input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir', $isEdit ? $jadwalOperasi->tanggal_lahir->format('Y-m-d') : '') }}" max="{{ now()->format('Y-m-d') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                                <option value="">Pilih jenis kelamin</option>
                                                <option value="Laki-laki" @selected(old('jenis_kelamin', $isEdit ? $jadwalOperasi->jenis_kelamin : '') === 'Laki-laki')>Laki-laki</option>
                                                <option value="Perempuan" @selected(old('jenis_kelamin', $isEdit ? $jadwalOperasi->jenis_kelamin : '') === 'Perempuan')>Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4 col-lg-2">
                                            <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                            <select id="golongan_darah" name="golongan_darah" class="form-select @error('golongan_darah') is-invalid @enderror">
                                                <option value="">Belum diketahui</option>
                                                @foreach (['A', 'B', 'AB', 'O'] as $golonganDarah)
                                                    <option value="{{ $golonganDarah }}" @selected(old('golongan_darah', $isEdit ? $jadwalOperasi->golongan_darah : '') === $golonganDarah)>{{ $golonganDarah }}</option>
                                                @endforeach
                                            </select>
                                            @error('golongan_darah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <label for="status_perkawinan" class="form-label required">Status Perkawinan</label>
                                            <select id="status_perkawinan" name="status_perkawinan" class="form-select @error('status_perkawinan') is-invalid @enderror" required>
                                                <option value="">Pilih status</option>
                                                @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                                    <option value="{{ $status }}" @selected(old('status_perkawinan', $isEdit ? $jadwalOperasi->status_perkawinan : '') === $status)>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                            @error('status_perkawinan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <label for="pekerjaan" class="form-label required">Pekerjaan</label>
                                            <input id="pekerjaan" name="pekerjaan" type="text" value="{{ old('pekerjaan', $isEdit ? $jadwalOperasi->pekerjaan : '') }}" class="form-control @error('pekerjaan') is-invalid @enderror" placeholder="Pekerjaan pasien" maxlength="255" required>
                                            @error('pekerjaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-subsection">
                                    <div class="form-subsection-title">Alamat Domisili</div>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="alamat" class="form-label required">Alamat Lengkap</label>
                                            <textarea id="alamat" name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" placeholder="Nama jalan, nomor rumah, RT/RW, dan desa/kelurahan" maxlength="1000" required>{{ old('alamat', $isEdit ? $jadwalOperasi->alamat : '') }}</textarea>
                                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kecamatan" class="form-label required">Kecamatan</label>
                                            <input id="kecamatan" name="kecamatan" type="text" value="{{ old('kecamatan', $isEdit ? $jadwalOperasi->kecamatan : '') }}" class="form-control @error('kecamatan') is-invalid @enderror" placeholder="Nama kecamatan" maxlength="255" required>
                                            @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="kabupaten" class="form-label required">Kabupaten / Kota</label>
                                            <input id="kabupaten" name="kabupaten" type="text" value="{{ old('kabupaten', $isEdit ? $jadwalOperasi->kabupaten : '') }}" class="form-control @error('kabupaten') is-invalid @enderror" placeholder="Nama kabupaten atau kota" maxlength="255" required>
                                            @error('kabupaten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-subsection">
                                    <div class="form-subsection-title">Dokumen dan Kontak</div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="no_ktp" class="form-label required">No. KTP</label>
                                            <input id="no_ktp" name="no_ktp" type="text" value="{{ old('no_ktp', $isEdit ? $jadwalOperasi->no_ktp : '') }}" class="form-control @error('no_ktp') is-invalid @enderror" placeholder="Nomor induk kependudukan" maxlength="32" inputmode="numeric" autocomplete="off" required>
                                            @error('no_ktp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="no_bpjs" class="form-label">No. BPJS <span class="text-secondary fw-normal">(opsional)</span></label>
                                            <input id="no_bpjs" name="no_bpjs" type="text" value="{{ old('no_bpjs', $isEdit ? $jadwalOperasi->no_bpjs : '') }}" class="form-control @error('no_bpjs') is-invalid @enderror" placeholder="Nomor kartu BPJS" maxlength="30" inputmode="numeric" autocomplete="off">
                                            @error('no_bpjs')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="no_telepon" class="form-label required">No. Telepon / HP</label>
                                            <input id="no_telepon" name="no_telepon" type="tel" value="{{ old('no_telepon', $isEdit ? $jadwalOperasi->no_telepon : '') }}" class="form-control @error('no_telepon') is-invalid @enderror" placeholder="Contoh: 081234567890" maxlength="30" autocomplete="tel" required>
                                            @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="card section-card" aria-labelledby="service-section-title">
                            <div class="card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="section-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21a9 9 0 1 0 0 -18a9 9 0 0 0 0 18" /><path d="M12 7v5l3 3" /></svg>
                                    </span>
                                    <div>
                                        <div class="section-kicker">Bagian 2 dari 2</div>
                                        <h2 id="service-section-title" class="card-title mb-1">Data Pelayanan</h2>
                                        <div class="text-secondary small">Atur jenis layanan, instruksi, dan waktu pelaksanaan.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="form-subsection">
                                    <div class="form-subsection-title">Informasi Pelayanan</div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tanggal_rencana_operasi" class="form-label required">Tanggal Rencana Operasi</label>
                                            <input id="tanggal_rencana_operasi" name="tanggal_rencana_operasi" type="datetime-local" value="{{ old('tanggal_rencana_operasi', $isEdit ? $jadwalOperasi->tanggal_rencana_operasi->format('Y-m-d\TH:i') : '') }}" class="form-control @error('tanggal_rencana_operasi') is-invalid @enderror" required>
                                            @error('tanggal_rencana_operasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pemberi_instruksi" class="form-label required">Dokter / Petugas Pemberi Instruksi</label>
                                            <input id="pemberi_instruksi" name="pemberi_instruksi" type="text" value="{{ old('pemberi_instruksi', $isEdit ? $jadwalOperasi->pemberi_instruksi : '') }}" class="form-control @error('pemberi_instruksi') is-invalid @enderror" placeholder="Nama dokter atau petugas" maxlength="255" required>
                                            @error('pemberi_instruksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <fieldset class="col-lg-5">
                                            <legend class="form-label required">Kategori Pelayanan</legend>
                                            <div class="service-type-grid">
                                                @foreach (['Operatif', 'Non Operatif'] as $tipe)
                                                    <div>
                                                        <input id="tipe-{{ Str::slug($tipe) }}" class="btn-check" type="radio" name="tipe_pelayanan" value="{{ $tipe }}" @checked(old('tipe_pelayanan', $isEdit ? $jadwalOperasi->tipe_pelayanan : 'Operatif') === $tipe) required>
                                                        <label for="tipe-{{ Str::slug($tipe) }}" class="service-type-label">
                                                            <span class="service-type-mark">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5l10 -10" /></svg>
                                                            </span>
                                                            <span>
                                                                <strong class="d-block">{{ $tipe }}</strong>
                                                                <small class="text-secondary">Pilih kategori</small>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('tipe_pelayanan')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                                        </fieldset>
                                        <div class="col-lg-7">
                                            <label for="jenis_pelayanan" class="form-label required">Jenis Pelayanan</label>
                                            <input id="jenis_pelayanan" name="jenis_pelayanan" type="text" value="{{ old('jenis_pelayanan', $isEdit ? $jadwalOperasi->jenis_pelayanan : '') }}" class="form-control @error('jenis_pelayanan') is-invalid @enderror" placeholder="Contoh: Operasi Katarak" maxlength="255" required>
                                            <div class="form-hint">Tuliskan nama tindakan atau pelayanan yang akan diberikan.</div>
                                            @error('jenis_pelayanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-8">
                                            <label for="keterangan_deskripsi" class="form-label">Keterangan / Deskripsi <span class="text-secondary fw-normal">(opsional)</span></label>
                                            <textarea id="keterangan_deskripsi" name="keterangan_deskripsi" rows="3" class="form-control @error('keterangan_deskripsi') is-invalid @enderror" placeholder="Catatan klinis, referensi, atau persiapan khusus" maxlength="2000">{{ old('keterangan_deskripsi', $isEdit ? $jadwalOperasi->keterangan_deskripsi : '') }}</textarea>
                                            @error('keterangan_deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="no_slip" class="form-label">No. Slip <span class="text-secondary fw-normal">(opsional)</span></label>
                                            <input id="no_slip" name="no_slip" type="text" value="{{ old('no_slip', $isEdit ? $jadwalOperasi->no_slip : '') }}" class="form-control @error('no_slip') is-invalid @enderror" placeholder="Nomor slip terkait" maxlength="100">
                                            @error('no_slip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-subsection">
                                    <div class="form-subsection-title">Waktu Pelaksanaan</div>
                                    <div class="schedule-panel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="tanggal_jadwal_operasi" class="form-label required">Tanggal Jadwal Operasi</label>
                                                <input id="tanggal_jadwal_operasi" name="tanggal_jadwal_operasi" type="datetime-local" value="{{ old('tanggal_jadwal_operasi', $isEdit ? $jadwalOperasi->tanggal_jadwal_operasi->format('Y-m-d\TH:i') : '') }}" class="form-control @error('tanggal_jadwal_operasi') is-invalid @enderror" required>
                                                <div class="form-hint">Waktu yang telah dialokasikan untuk pasien.</div>
                                                @error('tanggal_jadwal_operasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggal_operasi_tindakan" class="form-label">Tanggal Operasi / Tindakan <span class="text-secondary fw-normal">(opsional)</span></label>
                                                <input id="tanggal_operasi_tindakan" name="tanggal_operasi_tindakan" type="datetime-local" value="{{ old('tanggal_operasi_tindakan', $isEdit ? optional($jadwalOperasi->tanggal_operasi_tindakan)->format('Y-m-d\TH:i') : '') }}" class="form-control @error('tanggal_operasi_tindakan') is-invalid @enderror">
                                                <div class="form-hint">Isi setelah tindakan dilaksanakan atau jika waktunya sudah pasti.</div>
                                                @error('tanggal_operasi_tindakan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div class="form-action-bar d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <div class="text-secondary small">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon me-1" aria-hidden="true"><path d="M12 9v4" /><path d="M12 17v.01" /><path d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2" /></svg>
                                Periksa kembali data pasien sebelum menyimpan.
                            </div>
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('jadwal-operasi.index') }}" class="btn">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" aria-hidden="true"><path d="M5 12l5 5l10 -10" /></svg>
                                    {{ $isEdit ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
</body>
</html>
