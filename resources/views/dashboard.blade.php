<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        .dashboard-hero {
            overflow: hidden;
            border: 0;
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 52%, #22c55e 100%);
            color: #fff;
        }

        .dashboard-hero::after {
            position: absolute;
            inset: -65% -10% auto auto;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .1);
            content: '';
        }

        .dashboard-hero-logo {
            position: relative;
            z-index: 1;
            width: 180px;
            height: 150px;
            object-fit: contain;
            filter: drop-shadow(0 14px 24px rgba(15, 23, 42, .2));
        }

        .metric-icon {
            display: grid;
            width: 44px;
            height: 44px;
            place-items: center;
            border-radius: 12px;
        }

        .registration-empty {
            min-height: 170px;
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
                            <div class="page-pretitle">Ringkasan sistem</div>
                            <h1 class="page-title">Dashboard</h1>
                        </div>
                        <div class="col-auto ms-auto">
                            <span class="badge bg-green-lt text-green px-3 py-2">
                                <span class="status-dot status-dot-animated bg-green me-2"></span>
                                Sistem aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <main id="content" class="page-body">
                <div class="container navbar-container">
                    <div class="row row-deck row-cards">
                        <div class="col-12 col-xl-7">
                            <section class="card dashboard-hero position-relative h-100" aria-labelledby="welcome-title">
                                <div class="card-body p-4 p-lg-5">
                                    <div class="row align-items-center g-4">
                                        <div class="col-md-8 position-relative z-1">
                                            <span class="badge bg-white-lt text-white mb-3">SIM-RS</span>
                                            <h2 id="welcome-title" class="display-6 mb-3 text-white">Selamat datang, {{ auth()->user()->name }}</h2>
                                            <p class="mb-0 text-white opacity-75 fs-3">
                                                Kelola pelayanan dan informasi rumah sakit secara cepat, aman, dan terintegrasi dalam satu sistem.
                                            </p>
                                        </div>
                                        <div class="col-md-4 d-none d-md-flex justify-content-center">
                                            <img class="dashboard-hero-logo" src="{{ asset('templates/templates/dist/img/logo_rsud.png') }}" alt="Logo rumah sakit">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-12 col-xl-5">
                            <div class="row row-cards h-100">
                                <div class="col-sm-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="metric-icon bg-blue-lt text-blue me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" aria-hidden="true">
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    </svg>
                                                </span>
                                                <div>
                                                    <div class="text-secondary">Total pengguna</div>
                                                    <div class="h1 mb-0">{{ number_format($totalUsers) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="metric-icon bg-purple-lt text-purple me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" aria-hidden="true">
                                                        <path d="M12 3l7 4v5c0 5 -3.5 8 -7 9c-3.5 -1 -7 -4 -7 -9v-5z" /><path d="M9 12l2 2l4 -4" />
                                                    </svg>
                                                </span>
                                                <div>
                                                    <div class="text-secondary">Superadmin</div>
                                                    <div class="h1 mb-0">{{ number_format($superAdminCount) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card h-100">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="text-secondary mb-1">Akses Anda</div>
                                                <div class="h3 mb-0">{{ ucfirst(auth()->user()->role) }}</div>
                                            </div>
                                            <span class="badge bg-green-lt text-green">Email terverifikasi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <section class="card" aria-labelledby="registration-title">
                                <div class="card-header">
                                    <div>
                                        <h2 id="registration-title" class="card-title">Data Registrasi Pasien</h2>
                                        <p class="card-subtitle">Daftar registrasi pasien terbaru akan tampil di sini.</p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal</th>
                                                <th>No. RM</th>
                                                <th>Nama pasien</th>
                                                <th>Jenis kelamin</th>
                                                <th>Poliklinik / ruang</th>
                                                <th>DPJP</th>
                                                <th>Cara bayar</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="9">
                                                    <div class="registration-empty d-flex flex-column align-items-center justify-content-center text-center text-secondary px-3 py-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon mb-3" aria-hidden="true">
                                                            <path d="M3 21h18" /><path d="M5 21v-14l8 -4v18" /><path d="M19 21v-10l-6 -4" /><path d="M9 9v.01" /><path d="M9 12v.01" /><path d="M9 15v.01" /><path d="M9 18v.01" />
                                                        </svg>
                                                        <strong class="text-body">Belum ada data registrasi</strong>
                                                        <span>Data akan tersedia setelah modul registrasi pasien ditambahkan.</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.script')
</body>
</html>
