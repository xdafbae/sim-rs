<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pelayanan Laboratorium | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        .laboratorium-table { min-width: 1620px; }
        .laboratorium-table th { font-size: .75rem; font-weight: 600; white-space: nowrap; }
        .laboratorium-table .empty-row td { height: 380px; color: var(--tblr-secondary, #667085); text-align: center; vertical-align: middle; }
        .star-column { width: 36px; color: #f59f00; text-align: center; }
    </style>
</head>

<body>
    <a href="#content" class="visually-hidden skip-link">Lewati ke konten utama</a>
    <div class="page">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <main id="content" class="page-body">
                <div class="container navbar-container py-4">
                    <section class="card">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div>
                                <div class="page-pretitle">Laboratorium</div>
                                <h1 class="card-title mb-0">Pelayanan Laboratorium</h1>
                            </div>
                            <a href="{{ route('laboratorium.pelayanan.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-2"></i>Tambah Data
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="pelayanan-laboratorium-table" class="table table-bordered table-vcenter card-table text-nowrap laboratorium-table">
                                <thead>
                                    <tr>
                                        <th class="star-column">NO</th>
                                        <th>TGL. PELAYANAN</th>
                                        <th>CYT</th>
                                        <th>No. RM</th>
                                        <th>NAMA PASIEN</th>
                                        <th>TGL. LAHIR</th>
                                        <th>CARA MASUK</th>
                                        <th>POLIKLINIK/RUANG</th>
                                        <th>NO. KAMAR/TT</th>
                                        <th>KELAS</th>
                                        <th>CARA BAYAR</th>
                                        <th>DOKTER DPJP</th>
                                        <th>INSTRUKSI DOKTER</th>
                                        <th>PELAKSANA/PETUGAS</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelayanans as $pelayanan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td><td>{{ $pelayanan->tanggal_pelayanan->format('d/m/Y H:i') }}</td><td>{{ $pelayanan->cyto ? 'Ya' : '-' }}</td><td>{{ $pelayanan->no_rm }}</td><td>{{ $pelayanan->nama_pasien }}</td><td>{{ $pelayanan->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td><td>{{ $pelayanan->cara_masuk ?? '-' }}</td><td>{{ $pelayanan->poliklinik_ruang ?? '-' }}</td><td>{{ $pelayanan->no_kamar_tt ?? '-' }}</td><td>{{ $pelayanan->kelas ?? '-' }}</td><td>{{ $pelayanan->cara_bayar ?? '-' }}</td><td>{{ $pelayanan->dokter_dpjp ?? '-' }}</td><td>{{ $pelayanan->instruksi_dokter ?? '-' }}</td><td>{{ $pelayanan->pelaksana_petugas ?? '-' }}</td>
                                            <td><div class="d-flex gap-1"><a href="{{ route('laboratorium.pelayanan.edit', $pelayanan) }}" class="btn btn-sm btn-outline-primary">Edit</a><form action="{{ route('laboratorium.pelayanan.destroy', $pelayanan) }}" method="POST" onsubmit="return confirm('Hapus pelayanan ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new DataTable('#pelayanan-laboratorium-table', {
                scrollX: true,
                pageLength: 10,
                columnDefs: [{ orderable: false, targets: 0 }],
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    emptyTable: 'Tidak ada data untuk ditampilkan',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
                }
            });
        });
    </script>
</body>

</html>
