<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pemakaian Obat | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
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
                                <div class="page-pretitle">Operatif / Non Operatif</div>
                                <h1 class="card-title mb-0">Pemakaian Obat / Alkes</h1>
                            </div>
                            <a href="{{ route('pemakaian-obat.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Input Pemakaian</a>
                        </div>
                        <div class="table-responsive">
                            <table id="pemakaian-table" class="table table-vcenter card-table text-nowrap">
                                <thead><tr><th>No.</th><th>No. Pemakaian</th><th>Tanggal</th><th>No. Booking</th><th>No. RM</th><th>Nama Pasien</th><th>Item</th><th>Total Biaya</th><th>Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($pemakaianObats as $pemakaian)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pemakaian->no_pemakaian }}</td>
                                        <td>{{ $pemakaian->tanggal_pemakaian->format('d/m/Y H:i') }}</td>
                                        <td>{{ $pemakaian->jadwalOperasi?->no_booking ?? '-' }}</td>
                                        <td>{{ $pemakaian->no_rm }}</td>
                                        <td>{{ $pemakaian->nama_pasien }}</td>
                                        <td>{{ count($pemakaian->items) }} item</td>
                                        <td>Rp {{ number_format($pemakaian->total_biaya, 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('pemakaian-obat.destroy', $pemakaian) }}" method="POST" class="delete-form" data-name="{{ $pemakaian->no_pemakaian }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Hapus {{ $pemakaian->no_pemakaian }}"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
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
        $(function () {
            $('#pemakaian-table').DataTable({
                scrollX: true, pageLength: 10,
                order: [[2, 'desc']],
                columnDefs: [{ orderable: false, targets: -1 }],
                language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ data', info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data', infoEmpty: 'Tidak ada data', emptyTable: 'Belum ada pemakaian obat / alkes.', zeroRecords: 'Data tidak ditemukan', paginate: { previous: 'Sebelumnya', next: 'Berikutnya' } }
            });
            $('.delete-form').on('submit', function (event) {
                event.preventDefault();
                const form = this;
                Swal.fire({ title: 'Hapus pemakaian obat?', text: form.dataset.name, icon: 'warning', showCancelButton: true, confirmButtonColor: '#d63939', confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' }).then(result => { if (result.isConfirmed) form.submit(); });
            });
            @if(session('success')) Swal.fire({ toast: true, position: 'bottom-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3000 }); @endif
        });
    </script>
</body>
</html>
