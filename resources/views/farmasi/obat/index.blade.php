<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Obat | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        #obatTable.dataTable > tbody > tr:last-child > .dt-empty,
        #obatTable.dataTable > tbody > tr:last-child > td,
        #obatTable.dataTable > tbody > tr:last-child > th,
        #obatTable_wrapper .dt-scroll-body,
        #obatTable_wrapper .dataTables_scrollBody {
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
                <div class="container navbar-container py-4">
                    <section class="card">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <h2 class="card-title mb-0">Daftar Obat / Alkes</h2>
                            <a href="{{ route('farmasi.obat.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Data</a>
                        </div>
                        <div class="table-responsive">
                            <table id="obatTable" class="table table-vcenter card-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Jns. Obat/Alkes</th>
                                        <th>Nama Obat/Alkes</th>
                                        <th>Kode Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Detail Kelas Terapi</th>
                                        <th>HNA + PPN</th>
                                        <th>HPP</th>
                                        <th>Margin</th>
                                        <th>Persediaan RS</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($obats as $obat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $obat->kode }}</td>
                                        <td>{{ $obat->jenis }}</td>
                                        <td>{{ $obat->nama_obat_alkes }}</td>
                                        <td>{{ $obat->kode_obat ?: '-' }}</td>
                                        <td>{{ $obat->nama_obat ?: '-' }}</td>
                                        <td>{{ $obat->detail_kelas_terapi ?: '-' }}</td>
                                        <td>Rp {{ number_format($obat->hna_ppn, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($obat->hpp, 0, ',', '.') }}</td>
                                        <td>{{ number_format($obat->margin, 2, ',', '.') }}%</td>
                                        <td>{{ number_format($obat->persediaan_rs, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="btn-list flex-nowrap"><a href="{{ route('farmasi.obat.edit', $obat) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit {{ $obat->nama_obat_alkes }}"><i class="bi bi-pencil"></i></a>
                                                <form action="{{ route('farmasi.obat.destroy', $obat) }}" method="POST" class="delete-confirm-form" data-confirm="Hapus data {{ $obat->nama_obat_alkes }}?"><input type="hidden" name="_token" value="{{ csrf_token() }}">@method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Hapus {{ $obat->nama_obat_alkes }}"><i class="bi bi-trash"></i></button></form>
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
            </main>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('#obatTable').DataTable({
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    emptyTable: 'Belum ada data obat / alkes.',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: {
                        previous: 'Sebelumnya',
                        next: 'Berikutnya'
                    }
                },
                scrollX: true,
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });
            $('.delete-confirm-form').on('submit', function(event) {
                event.preventDefault();
                const form = this;
                Swal.fire({
                    title: 'Konfirmasi penghapusan',
                    text: form.dataset.confirm,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d63939',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
            @if(session('success')) Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 3000
            });
            @endif
        });
    </script>
</body>

</html>
