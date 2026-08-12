<style>
    .navbar-container {
        width: 95%;
        max-width: 1600px;
        margin: 0 auto;
    }

    .superadmin-navbar .nav-link {
        white-space: nowrap;
    }

    .superadmin-navbar .dropdown-menu {
        min-width: 12rem;
        min-height: 2.75rem;
    }

    @media (min-width: 768px) {
        .superadmin-navbar {
            flex-direction: row;
            flex-wrap: wrap;
        }
    }
</style>
<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container navbar-container">
                <div class="row flex-column flex-md-row flex-fill align-items-center">
                    <div class="col">
                        <!-- BEGIN NAVBAR MENU -->
                        <nav aria-label="Primary">
                            <!-- BEGIN NAVBAR MENU -->
                            @if(auth()->user()->role === 'superadmin')
                            @php
                                $superadminModules = [
                                    'Pendaftaran',
                                    'Assembling',
                                    'Fling',
                                    'Rawat Inap',
                                    'Rawat Jalan',
                                    'Gizi',
                                    'Operatif / Non Operatif',
                                    'Laboratorium',
                                    'Radiologi',
                                    'Farmasi',
                                    'Akreditasi',
                                    'Kasir',
                                    'Aset',
                                    'Logistik',
                                    'Akuntansi',
                                    'Remunerasi',
                                    'Anggaran & Perbendaharaan',
                                    'Kepegawaian',
                                    'Administrator',
                                ];

                                $superadminSubmenus = [
                                    'Operatif / Non Operatif' => [
                                        ['label' => 'Alkes'],
                                        ['label' => 'Jadwal Operasi', 'route' => 'jadwal-operasi.index'],
                                        ['label' => 'Pemakaian Obat'],
                                        ['label' => 'Pelayanan Operatif'],
                                    ],
                                    'Administrator' => [
                                        ['label' => 'Pola Tarif Layanan', 'route' => 'pola_tarif.show'],
                                    ],
                                    'Farmasi' => [
                                        ['label' => 'Penjualan Obat', 'route' => 'farmasi.penjualan-obat.index'],
                                        ['label' => 'Pemesanan Obat', 'route' => 'farmasi.pemesanan-obat.index'],
                                        ['label' => 'Pemasukan Obat', 'route' => 'farmasi.pemasukan-obat.index'],
                                        ['label' => 'Mutasi Obat', 'route' => 'farmasi.mutasi-obat.index'],
                                        ['label' => 'Jurnal Obat', 'route' => 'farmasi.jurnal-obat.index'],
                                        ['label' => 'Obat', 'route' => 'farmasi.obat.index'],
                                        ['label' => 'Persediaan Obat', 'route' => 'farmasi.persediaan-obat.index'],
                                        ['label' => 'PBF', 'route' => 'farmasi.pbf.index'],
                                        ['label' => 'Apotek Online', 'route' => 'farmasi.apotek-online.index'],
                                    ],

                                ];
                            @endphp
                            <ul class="navbar-nav superadmin-navbar">
                                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard') }}" class="nav-link">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1" aria-hidden="true">
                                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">Dashboard</span>
                                    </a>
                                </li>
                                @foreach ($superadminModules as $module)
                                    @php
                                        $moduleSlug = Str::slug($module);
                                        $submenuItems = $superadminSubmenus[$module] ?? [];
                                        $isModuleActive = collect($submenuItems)->contains(fn ($submenu) => isset($submenu['route']) && request()->routeIs($submenu['route']));
                                    @endphp
                                    <li class="nav-item dropdown {{ $isModuleActive ? 'active' : '' }}">
                                        <a id="module-{{ $moduleSlug }}" href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="{{ $isModuleActive ? 'true' : 'false' }}">
                                            <span class="nav-link-title">{{ $module }}</span>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="module-{{ $moduleSlug }}">
                                            @forelse ($submenuItems as $submenu)
                                                <a href="{{ isset($submenu['route']) ? route($submenu['route']) : '#' }}" class="dropdown-item {{ isset($submenu['route']) && request()->routeIs($submenu['route']) ? 'active' : '' }}">
                                                    {{ $submenu['label'] }}
                                                </a>
                                            @empty
                                                <span class="dropdown-item-text text-muted">Menu belum tersedia</span>
                                            @endforelse
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @elseif(auth()->user()->role == 'pendaftaran')
                            <ul class="navbar-nav">
                                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} dropdown">
                                    <a href="{{route('dashboard')}}" class="nav-link">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/home -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" class="icon icon-1">
                                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                            </svg></span>
                                        <span class="nav-link-title">
                                            Dashboard
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}  dropdown">
                                    <a class="nav-link" href="{{route('pendaftaran.registrasi_pasien')}}">

                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                aria-hidden="true"
                                                focusable="false"
                                                class="icon icon-1">

                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />

                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Registrasi Pasien
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item {{ request()->routeIs('master.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('master.master_pasien')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">

                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                aria-hidden="true"
                                                focusable="false"
                                                class="icon icon-1">

                                                <ellipse cx="12" cy="5" rx="9" ry="3" />
                                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                                                <path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3" />

                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Master Data Pasien
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}" href="" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/home -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" class="icon icon-1">
                                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                            </svg></span>
                                        Daftar Pasien Mondok
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}" href="" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">

                                                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                                <path d="M9 5a3 3 0 0 0 6 0" />
                                                <path d="M9 14l2 2l4 -4" />

                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Check In Encounter
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}" href="" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">

                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                                <path d="M9 9l1 0" />
                                                <path d="M9 13l6 0" />
                                                <path d="M9 17l6 0" />

                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Data (Kunjungan) SEP
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}" href="" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">

                                                <path d="M9 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M17 11a4 4 0 0 1 0 8" />
                                                <path d="M7 11a4 4 0 0 0 0 8" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4" />
                                                <path d="M17 15h4a4 4 0 0 1 4 4v2" />

                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Jaga Klinik
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item dropdown">
                                    <a class="nav-link {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}" href="" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">

                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                <path d="M8 12h.01" />
                                                <path d="M12 12h.01" />
                                                <path d="M16 12h.01" />

                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Sisrute
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            @elseif(auth()->user()->role == 'admin')
                            <ul class="navbar-nav">
                                <li class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }} dropdown">
                                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/home -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" class="icon icon-1">
                                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                            </svg></span>
                                        <span class="nav-link-title">
                                            Dashboard
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{ request()->routeIs('pola_tarif.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('pola_tarif.show')}}">

                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M5 7h14" />
                                                <path d="M5 12h14" />
                                                <path d="M5 17h14" />
                                                <path d="M8 4v16" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Pola Tarif Layanan
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item {{ request()->routeIs('cara_bayar.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('cara_bayar.show')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                                <path d="M3 10h18" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Cara Bayar
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item {{ request()->routeIs('kelas_perawatan.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('kelas_perawatan.show')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/home -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M3 21v-6" />
                                                <path d="M21 21v-6" />
                                                <path d="M3 15h18" />
                                                <path d="M5 15v-5a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v5" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Kelas Perawatan
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{ request()->routeIs('kelas_rajal.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('kelas_rajal.show')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M6 3l3 6" />
                                                <path d="M18 3l-3 6" />
                                                <path d="M12 9v12" />
                                                <path d="M9 15h6" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Klinik Rajal / Radar
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item {{ request()->routeIs('bangsal.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('bangsal.show')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M3 7v10" />
                                                <path d="M21 7v10" />
                                                <path d="M3 14h18" />
                                                <path d="M7 10h4" />
                                                <path d="M13 10h4" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Ruang / Bangsal
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item {{ request()->routeIs('distribusi.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('distribusi.show')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M3 7v10" />
                                                <path d="M21 13v4" />
                                                <path d="M3 13h18" />
                                                <path d="M7 13v-4h5a3 3 0 0 1 3 3v1" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            Distribusi TT
                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('user.user_akun')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M9 7a4 4 0 1 0 8 0" />
                                                <path d="M17 11a4 4 0 1 1 0 8" />
                                                <path d="M7 11a4 4 0 0 0 0 8" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            User Account
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item {{ request()->routeIs('userlog.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('userlog.show')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M12 8v4l2 2" />
                                                <path d="M3 12a9 9 0 1 0 3-6.7" />
                                                <path d="M3 3v6h6" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            User Log
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('ttelog.*') ? 'active' : '' }} dropdown">
                                    <a class="nav-link" href="{{route('ttelog.show')}}" data-bs-auto-close="outside" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                                                <circle cx="12" cy="15" r="2" />
                                                <path d="M12 17l-1 3l1-1l1 1l-1-3" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            TTE Log
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            @endif
                            <!-- END NAVBAR MENU -->
                        </nav>
                        <!-- END NAVBAR MENU -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
