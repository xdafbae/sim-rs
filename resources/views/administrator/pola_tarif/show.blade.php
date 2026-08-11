<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pola Tarif Layanan | {{ config('app.name', 'SIM-RS') }}</title>
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

        #polatarifTable_wrapper .dt-scroll-body,
        #polatarifTable_wrapper .dataTables_scrollBody {
            border-bottom: 0 !important;
        }

        #polatarifTable_wrapper .dt-scroll-body table,
        #polatarifTable_wrapper .dataTables_scrollBody table {
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
                                    <h3 class="card-title mb-0">Data Tarif Pelayanan</h3>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button id="bulk-delete-button" type="submit" form="bulk-delete-form" class="btn btn-danger" disabled>
                                            <i class="bi bi-trash me-1"></i>Hapus Terpilih
                                        </button>
                                        <a href="{{ route('pola_tarif.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Data
                                        </a>
                                    </div>
                                </div>
                                <form id="bulk-delete-form" class="delete-confirm-form" data-confirm="Hapus semua pola tarif yang dipilih?" action="{{ route('pola_tarif.bulk_destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <div class="p-2">
                                    <table id="polatarifTable" class="table table-vcenter card-table text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="w-1"><input id="select-all" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Pilih semua data"></th>
                                                <th class="w-1">No.</th>
                                                <th>JENIS PELAYANAN</th>
                                                <th>KODE PELAYANAN</th>
                                                <th>INSTALASI</th>
                                                <th>SUB INSTALASI</th>
                                                <th>KATEGORI</th>
                                                <th>EKLAIM</th>
                                                <th>AKTIF</th>
                                                <th>LAST UPDATE</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse ($polaTarifs as $polaTarif)
                                            <tr>
                                                <td><input class="form-check-input m-0 align-middle row-checkbox" type="checkbox" name="ids[]" value="{{ $polaTarif->id }}" form="bulk-delete-form" aria-label="Pilih {{ $polaTarif->kode_pelayanan }}"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $polaTarif->jenis_pelayanan }}</td>
                                                <td>{{ $polaTarif->kode_pelayanan }}</td>
                                                <td>{{ $polaTarif->instalasi }}</td>
                                                <td>{{ $polaTarif->sub_instalasi ?: '-' }}</td>
                                                <td>{{ $polaTarif->kategori }}</td>
                                                <td><span class="badge bg-{{ $polaTarif->eklaim ? 'azure-lt' : 'secondary-lt' }}">{{ $polaTarif->eklaim ? 'Ya' : 'Tidak' }}</span></td>
                                                <td><span class="badge bg-{{ $polaTarif->aktif ? 'green-lt' : 'red-lt' }}">{{ $polaTarif->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
                                                <td>{{ $polaTarif->updated_at->format('d-m-Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="{{ route('pola_tarif.edit', $polaTarif) }}" class="btn btn-sm btn-outline-primary" title="Edit {{ $polaTarif->kode_pelayanan }}"><i class="bi bi-pencil"></i></a>
                                                        <form class="delete-confirm-form" data-confirm="Hapus pola tarif {{ $polaTarif->kode_pelayanan }}?" action="{{ route('pola_tarif.destroy', $polaTarif) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus {{ $polaTarif->kode_pelayanan }}"><i class="bi bi-trash"></i></button>
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
            $('#polatarifTable').DataTable({
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
                    emptyTable: "Belum ada data pola tarif.",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });

            const selectAll = document.getElementById('select-all');
            const bulkDeleteButton = document.getElementById('bulk-delete-button');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const toggleBulkButton = () => {
                const selected = document.querySelectorAll('.row-checkbox:checked').length;
                bulkDeleteButton.disabled = selected === 0;
                bulkDeleteButton.innerHTML = `<i class="bi bi-trash me-1"></i>Hapus Terpilih${selected ? ` (${selected})` : ''}`;
            };
            selectAll.addEventListener('change', function() {
                checkboxes.forEach((checkbox) => checkbox.checked = this.checked);
                toggleBulkButton();
            });
            checkboxes.forEach((checkbox) => checkbox.addEventListener('change', function() {
                selectAll.checked = checkboxes.length > 0 && document.querySelectorAll('.row-checkbox:checked').length === checkboxes.length;
                toggleBulkButton();
            }));

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

            @if (session('success'))
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
