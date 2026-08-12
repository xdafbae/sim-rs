<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Penjualan Obat | {{ config('app.name', 'SIM-RS') }}</title>
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

        #penjualanObatTable_wrapper .dt-scroll-body,
        #penjualanObatTable_wrapper .dataTables_scrollBody {
            border-bottom: 0 !important;
        }

        #penjualanObatTable_wrapper .dt-scroll-body table,
        #penjualanObatTable_wrapper .dataTables_scrollBody table {
            border-bottom: 0 !important;
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
                    <div class="row row-deck row-cards">

                        <div class="col-12">
                            <section class="card" aria-labelledby="registration-title">
                                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                    <h3 class="card-title mb-0">Data Penjualan Obat</h3>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('farmasi.penjualan-obat.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Data
                                        </a>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <table id="penjualanObatTable" class="table table-vcenter card-table text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="w-1"><input id="select-all" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Pilih semua data"></th>
                                                <th class="w-1">No.</th>
                                                <th>TGL.PELAYANAN</th>
                                                <th>NO.RM </th>
                                                <th>NAMA PASIEN</th>
                                                <th>TGL.LAHIR</th>
                                                <th>BB(Gram)</th>
                                                <th>CARA MASUK</th>
                                                <th>POLIKLINIK/RUANG</th>
                                                <th>NO.TT/KAMAR</th>
                                                <th>CARA BAYAR</th>
                                                <th>KELAS</th>
                                                <th>DOKTER(DPJP)</th>
                                                <th>INSTRUKSI DOKTER</th>
                                                <th>DOKTER/OPERATOR</th>
                                                <th>CYT</th>
                                                <th>JENIS PELAYANAN</th>
                                                <th>JS</th>
                                                <th>JP</th>
                                                <th>BAHP</th>
                                                <th>TOT.BIAYA</th>
                                                <th>TGL.PULANG</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse ($penjualanObats as $penjualanObat)
                                            @php
                                                $total = collect($penjualanObat->items)->sum(fn ($item) => ((float) $item['harga']) * ((int) $item['qty'])) + (float) $penjualanObat->akomodasi;
                                            @endphp
                                            <tr>
                                                <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Pilih {{ $penjualanObat->no_transaksi }}"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $penjualanObat->tanggal->format('d-m-Y H:i') }}<div class="text-secondary small">{{ $penjualanObat->no_transaksi }}</div></td>
                                                <td>{{ $penjualanObat->no_rm }}</td>
                                                <td>{{ $penjualanObat->nama_pasien }}</td>
                                                <td>{{ $penjualanObat->tanggal_lahir?->format('d-m-Y') ?: '-' }}</td>
                                                <td>{{ $penjualanObat->berat_badan ?: '-' }}</td>
                                                <td>{{ $penjualanObat->status_pasien ?: '-' }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>{{ $penjualanObat->nama_dokter ?: '-' }}</td>
                                                <td>-</td>
                                                <td>{{ $penjualanObat->nama_dokter ?: '-' }}</td>
                                                <td>-</td>
                                                <td>Penjualan Obat</td>
                                                <td>{{ $penjualanObat->jasa_farmasi ? 'Ya' : 'Tidak' }}</td>
                                                <td>-</td>
                                                <td>Rp {{ number_format($penjualanObat->akomodasi, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                                <td>-</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('farmasi.penjualan-obat.edit', $penjualanObat) }}" class="btn btn-sm btn-outline-primary" title="Edit {{ $penjualanObat->no_transaksi }}"><i class="bi bi-pencil"></i></a>
                                                        <form class="delete-confirm-form" data-confirm="Hapus transaksi {{ $penjualanObat->no_transaksi }}?" action="{{ route('farmasi.penjualan-obat.destroy', $penjualanObat) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus {{ $penjualanObat->no_transaksi }}"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#penjualanObatTable').DataTable({
                ordering: true,
                searching: true,
                paging: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                scrollY: '420px',
                scrollX: true,
                scrollCollapse: true,
                responsive: false,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    emptyTable: "Belum ada data penjualan obat.",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });

            const selectAll = document.getElementById('select-all');
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('#penjualanObatTable tbody input[type="checkbox"]').forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
            });

            document.querySelectorAll('.delete-confirm-form').forEach((form) => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi penghapusan',
                        text: form.dataset.confirm,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d63939',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            @endif
        });
    </script>
</body>

</html>
