<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jadwal Operasi | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.1/css/dataTables.dataTables.min.css">
    <style>
        .operation-schedule-table {
            min-width: 2050px;
        }

        .operation-schedule-table th {
            font-size: .7rem;
            white-space: nowrap;
        }

        .operation-schedule-table .description-cell {
            min-width: 240px;
            max-width: 320px;
            white-space: normal;
        }

        .dt-container .dt-layout-row:last-child {
            margin: 0;
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--tblr-border-color, #e6e7e9);
        }

        .dt-container .dt-info {
            color: var(--tblr-secondary-color, #626976);
        }

        div.dt-container .dt-paging .dt-paging-button {
            min-width: 34px;
            margin-left: .25rem;
            border: 1px solid var(--tblr-border-color, #dce1e7) !important;
            border-radius: .375rem;
            background: var(--tblr-bg-surface, #fff) !important;
        }

        div.dt-container .dt-paging .dt-paging-button.current {
            border-color: var(--tblr-primary, #206bc4) !important;
            background: var(--tblr-primary, #206bc4) !important;
            color: #fff !important;
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
                            <div class="page-pretitle">Operatif / Non Operatif</div>
                            <h1 class="page-title">Jadwal Operasi</h1>
                        </div>
                        <div class="col-auto ms-auto">
                            <a href="{{ route('jadwal-operasi.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
                                Tambah Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <main id="content" class="page-body">
                <div class="container navbar-container">
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: 'success',
                                title: {{ Js::from(session('success')) }},
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        </script>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Daftar Jadwal Operasi</h2>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <form id="operation-schedule-filters" class="row g-2 align-items-end" role="search">
                                <div class="col-sm-6 col-lg-4">
                                    <label for="q" class="form-label">Pencarian</label>
                                    <input id="q" type="search" class="form-control" placeholder="No. booking, RM, pasien, BPJS..." autocomplete="off">
                                </div>
                                <div class="col-sm-3 col-lg-2">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input id="tanggal_mulai" type="date" class="form-control">
                                </div>
                                <div class="col-sm-3 col-lg-2">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input id="tanggal_selesai" type="date" class="form-control">
                                </div>
                                <div class="col-sm-3 col-lg-2">
                                    <label for="page_length" class="form-label">Tampilkan</label>
                                    <select id="page_length" class="form-select">
                                        <option value="10">10 data</option>
                                        <option value="25">25 data</option>
                                        <option value="50">50 data</option>
                                        <option value="100">100 data</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary" type="submit">Tampilkan</button>
                                </div>
                                <div class="col-auto">
                                    <button id="reset-filters" type="button" class="btn">Reset</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body p-0">
                            <table id="operation-schedule-table" class="table table-vcenter card-table operation-schedule-table w-100">
                                <thead>
                                    <tr>
                                        <th>No. Booking</th>
                                        <th>Tgl. Pengajuan</th>
                                        <th>Tgl. Rencana</th>
                                        <th>Tgl. Dijadwalkan</th>
                                        <th>Tgl. Operasi</th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Tgl. Lahir</th>
                                        <th>Jns. Kelamin</th>
                                        <th>Gol. Darah</th>
                                        <th>No. BPJS</th>
                                        <th>Jns. Pelayanan</th>
                                        <th>Kategori</th>
                                        <th>Keterangan</th>
                                        <th>Instruksi Dokter</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
    <script src="https://cdn.datatables.net/3.0.1/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('q');
            const startDateInput = document.getElementById('tanggal_mulai');
            const endDateInput = document.getElementById('tanggal_selesai');
            const pageLengthInput = document.getElementById('page_length');

            const table = new DataTable('#operation-schedule-table', {
                processing: true,
                serverSide: true,
                pageLength: 10,
                scrollX: true,
                autoWidth: false,
                order: [[3, 'asc']],
                layout: {
                    topStart: null,
                    topEnd: null,
                    bottomStart: 'info',
                    bottomEnd: 'paging',
                },
                ajax: {
                    url: {{ Js::from(route('jadwal-operasi.data')) }},
                    data: function (data) {
                        data.tanggal_mulai = startDateInput.value;
                        data.tanggal_selesai = endDateInput.value;
                    },
                },
                columns: [
                    { data: 'no_booking', className: 'fw-semibold text-primary' },
                    { data: 'tanggal_pengajuan' },
                    { data: 'tanggal_rencana' },
                    { data: 'tanggal_dijadwalkan' },
                    { data: 'tanggal_operasi' },
                    { data: 'no_rm' },
                    { data: 'nama_pasien', className: 'fw-semibold' },
                    { data: 'tanggal_lahir' },
                    { data: 'jenis_kelamin' },
                    { data: 'golongan_darah' },
                    { data: 'no_bpjs' },
                    { data: 'jenis_pelayanan' },
                    { data: 'kategori' },
                    { data: 'keterangan', className: 'description-cell', orderable: false },
                    { data: 'instruksi_dokter', className: 'description-cell' },
                    { data: 'aksi', orderable: false, searchable: false },
                ],
                language: {
                    processing: 'Memuat data...',
                    emptyTable: 'Belum ada jadwal operasi.',
                    zeroRecords: 'Jadwal yang dicari tidak ditemukan.',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    infoEmpty: 'Menampilkan 0 data',
                    infoFiltered: '(disaring dari _MAX_ data)',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya',
                    },
                },
            });

            document.getElementById('operation-schedule-filters').addEventListener('submit', function (event) {
                event.preventDefault();
                table.search(searchInput.value.trim()).draw();
            });

            document.getElementById('reset-filters').addEventListener('click', function () {
                searchInput.value = '';
                startDateInput.value = '';
                endDateInput.value = '';
                table.search('').draw();
            });

            pageLengthInput.addEventListener('change', function () {
                table.page.len(Number(this.value)).draw();
            });

            document.getElementById('operation-schedule-table').addEventListener('click', function (event) {
                const deleteButton = event.target.closest('[data-delete-url]');

                if (! deleteButton) {
                    return;
                }

                Swal.fire({
                    title: 'Hapus jadwal operasi?',
                    text: `Jadwal pasien ${deleteButton.dataset.patientName} akan dihapus permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d63939',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then(async function (result) {
                    if (! result.isConfirmed) {
                        return;
                    }

                    try {
                        const response = await fetch(deleteButton.dataset.deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        });

                        if (! response.ok) {
                            throw new Error('Delete request failed');
                        }

                        const result = await response.json();
                        table.ajax.reload(null, false);

                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'success',
                            title: result.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    } catch (error) {
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: 'error',
                            title: 'Jadwal operasi gagal dihapus!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
