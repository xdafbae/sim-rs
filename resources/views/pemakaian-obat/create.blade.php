<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Input Pemakaian Obat | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        .identity-field[readonly] { background: #f8fafc; color: #334155; }
        .empty-items { min-height: 220px; }
        .patient-placeholder { min-height: 280px; border: 1px dashed #cbd5e1; background: #f8fafc; }
        .item-picker { background: #f8fafc; }
        .sticky-actions { position: sticky; bottom: 0; z-index: 10; box-shadow: 0 -8px 24px rgba(31, 41, 55, .08); }
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
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <div><div class="page-pretitle">Operatif / Non Operatif</div><h1 class="page-title">Input Pemakaian Obat / Alkes</h1></div>
                        <a href="{{ route('pemakaian-obat.index') }}" class="btn btn-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>

                    <form id="pemakaian-form" action="{{ route('pemakaian-obat.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="jadwal_operasi_id" name="jadwal_operasi_id" value="{{ old('jadwal_operasi_id') }}">
                        <div class="row g-3">
                            <div class="col-xl-8">
                                <section class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h2 class="card-title mb-0"><i class="bi bi-person-vcard me-2 text-primary"></i>Identitas Pasien</h2>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jadwal-modal"><i class="bi bi-search me-2"></i>Cari Jadwal Operasi</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4"><label class="form-label">No. RM</label><input id="no_rm" class="form-control identity-field" readonly placeholder="Pilih jadwal operasi"></div>
                                            <div class="col-md-8"><label class="form-label">Nama Pasien</label><input id="nama_pasien" class="form-control identity-field" readonly></div>
                                            <div class="col-md-4"><label class="form-label">Tanggal Lahir</label><input id="tanggal_lahir" class="form-control identity-field" readonly></div>
                                            <div class="col-md-4"><label class="form-label">Jenis Kelamin</label><input id="jenis_kelamin" class="form-control identity-field" readonly></div>
                                            <div class="col-md-4"><label class="form-label">Status Perkawinan</label><input id="status_perkawinan" class="form-control identity-field" readonly></div>
                                            <div class="col-12"><label class="form-label">Alamat</label><textarea id="alamat" rows="2" class="form-control identity-field" readonly></textarea></div>
                                            <div class="col-md-6"><label class="form-label">Kecamatan</label><input id="kecamatan" class="form-control identity-field" readonly></div>
                                            <div class="col-md-6"><label class="form-label">Kabupaten</label><input id="kabupaten" class="form-control identity-field" readonly></div>
                                            <div class="col-md-4"><label class="form-label">Pekerjaan</label><input id="pekerjaan" class="form-control identity-field" readonly></div>
                                            <div class="col-md-4"><label class="form-label">No. KTP</label><input id="no_ktp" class="form-control identity-field" readonly></div>
                                            <div class="col-md-4"><label class="form-label">No. Telepon / HP</label><input id="no_telepon" class="form-control identity-field" readonly></div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-xl-4">
                                <section class="card h-100">
                                    <div class="card-header"><h2 class="card-title mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Jadwal Operasi Terpilih</h2></div>
                                    <div id="patient-placeholder" class="patient-placeholder m-3 rounded d-flex flex-column justify-content-center align-items-center text-center text-secondary p-4">
                                        <i class="bi bi-calendar2-search fs-1 mb-3"></i><strong>Belum ada jadwal dipilih</strong><span class="small">Klik Cari Jadwal Operasi untuk memilih pasien.</span>
                                    </div>
                                    <div id="schedule-summary" class="card-body d-none">
                                        <dl class="row mb-0 g-3"><dt class="col-5 text-secondary">No. Booking</dt><dd id="no_booking" class="col-7 fw-bold"></dd><dt class="col-5 text-secondary">Jadwal</dt><dd id="tanggal_jadwal" class="col-7"></dd><dt class="col-5 text-secondary">Pelayanan</dt><dd id="jenis_pelayanan" class="col-7"></dd><dt class="col-5 text-secondary">Instruksi</dt><dd id="pemberi_instruksi" class="col-7"></dd></dl>
                                    </div>
                                    <div class="card-footer"><label for="tanggal_pemakaian" class="form-label">Tanggal Pemakaian <span class="text-danger">*</span></label><input id="tanggal_pemakaian" name="tanggal_pemakaian" type="datetime-local" value="{{ old('tanggal_pemakaian', now()->format('Y-m-d\TH:i')) }}" class="form-control @error('tanggal_pemakaian') is-invalid @enderror" required></div>
                                </section>
                            </div>

                            <div class="col-12">
                                <section class="card">
                                    <div class="card-header"><h2 class="card-title mb-0"><i class="bi bi-capsule me-2 text-primary"></i>Pemakaian Obat / Alkes</h2></div>
                                    <div class="card-body item-picker border-bottom">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-lg-5"><label for="obat_id" class="form-label">Nama Obat / Alkes</label><select id="obat_id" class="form-select"><option value="">Pilih obat / alkes</option>@foreach($obats as $obat)<option value="{{ $obat->id }}">{{ $obat->kode }} — {{ $obat->nama_obat_alkes }}</option>@endforeach</select></div>
                                            <div class="col-md-2"><label for="hja_preview" class="form-label">HJA</label><input id="hja_preview" class="form-control" readonly></div>
                                            <div class="col-md-2"><label for="debet" class="form-label">Debet</label><input id="debet" type="number" min="1" value="1" class="form-control"></div>
                                            <div class="col-md-2"><label for="kredit" class="form-label">Kredit</label><input id="kredit" type="number" min="0" value="0" class="form-control"></div>
                                            <div class="col-md-1"><button id="tambah-item" type="button" class="btn btn-primary w-100" title="Tambah item"><i class="bi bi-plus-lg"></i></button></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table mb-0">
                                            <thead><tr><th>Nama Obat / Alkes</th><th class="text-end">HJA</th><th class="text-end">Debet</th><th class="text-end">Kredit</th><th class="text-end">Biaya</th><th></th></tr></thead>
                                            <tbody id="item-body"></tbody>
                                            <tfoot id="item-total" class="d-none"><tr><th colspan="4" class="text-end">Total Biaya</th><th id="total-biaya" class="text-end"></th><th></th></tr></tfoot>
                                        </table>
                                        <div id="item-empty" class="empty-items d-flex flex-column align-items-center justify-content-center text-secondary"><i class="bi bi-inbox fs-1 mb-2"></i>Belum ada obat / alkes ditambahkan.</div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="sticky-actions bg-white border rounded mt-3 p-3 d-flex justify-content-between align-items-center">
                            <span id="item-count" class="text-secondary">0 item pemakaian</span>
                            <div class="d-flex gap-2"><a href="{{ route('pemakaian-obat.index') }}" class="btn btn-outline-secondary">Batal</a><button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button></div>
                        </div>
                    </form>
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>

    <div class="modal modal-blur fade" id="jadwal-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header"><h2 class="modal-title">Pilih Pasien dari Jadwal Operasi</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
                <div class="modal-body"><div class="table-responsive"><table id="jadwal-table" class="table table-vcenter text-nowrap"><thead><tr><th>No. Booking</th><th>Jadwal Operasi</th><th>No. RM</th><th>Nama Pasien</th><th>Pelayanan</th><th></th></tr></thead><tbody>@foreach($jadwalOperasi as $jadwal)<tr><td>{{ $jadwal->no_booking }}</td><td>{{ $jadwal->tanggal_jadwal_operasi->format('d/m/Y H:i') }}</td><td>{{ $jadwal->no_rm }}</td><td>{{ $jadwal->nama_pasien }}</td><td>{{ $jadwal->jenis_pelayanan }}</td><td><button type="button" class="btn btn-sm btn-primary pilih-jadwal" data-id="{{ $jadwal->id }}">Pilih</button></td></tr>@endforeach</tbody></table></div></div>
            </div>
        </div>
    </div>

    @include('layouts.script')
    <script>
        const schedules = @json($jadwalOperasi->keyBy('id'));
        const medicines = @json($obatOptions);
        let items = @json(old('items', []));
        const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
        const escapeHtml = value => { const span = document.createElement('span'); span.textContent = value ?? ''; return span.innerHTML; };

        function chooseSchedule(id) {
            const schedule = schedules[id];
            if (!schedule) return;
            document.getElementById('jadwal_operasi_id').value = id;
            ['no_rm', 'nama_pasien', 'jenis_kelamin', 'status_perkawinan', 'alamat', 'kecamatan', 'kabupaten', 'pekerjaan', 'no_ktp', 'no_telepon', 'no_booking', 'jenis_pelayanan', 'pemberi_instruksi'].forEach(field => { document.getElementById(field).value !== undefined ? document.getElementById(field).value = (schedule[field] || '') : document.getElementById(field).textContent = (schedule[field] || '-'); });
            document.getElementById('tanggal_lahir').value = schedule.tanggal_lahir ? schedule.tanggal_lahir.substring(0, 10).split('-').reverse().join('/') : '';
            document.getElementById('tanggal_jadwal').textContent = schedule.tanggal_jadwal_operasi ? new Date(schedule.tanggal_jadwal_operasi).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : '-';
            document.getElementById('patient-placeholder').classList.add('d-none');
            document.getElementById('schedule-summary').classList.remove('d-none');
            bootstrap.Modal.getOrCreateInstance(document.getElementById('jadwal-modal')).hide();
        }

        function renderItems() {
            const body = document.getElementById('item-body');
            body.innerHTML = items.map((item, index) => {
                const medicine = medicines[item.obat_id];
                if (!medicine) return '';
                const debet = Number(item.debet), kredit = Number(item.kredit), biaya = (debet - kredit) * medicine.hja;
                return `<tr><td><input type="hidden" name="items[${index}][obat_id]" value="${medicine.id}"><strong>${escapeHtml(medicine.nama)}</strong><div class="small text-secondary">${escapeHtml(medicine.kode)}</div></td><td class="text-end">${rupiah.format(medicine.hja)}</td><td class="text-end"><input type="hidden" name="items[${index}][debet]" value="${debet}">${debet}</td><td class="text-end"><input type="hidden" name="items[${index}][kredit]" value="${kredit}">${kredit}</td><td class="text-end fw-bold">${rupiah.format(biaya)}</td><td class="text-end"><button type="button" class="btn btn-sm btn-outline-danger remove-item" data-index="${index}"><i class="bi bi-trash"></i></button></td></tr>`;
            }).join('');
            const total = items.reduce((sum, item) => sum + ((Number(item.debet) - Number(item.kredit)) * (medicines[item.obat_id]?.hja || 0)), 0);
            document.getElementById('total-biaya').textContent = rupiah.format(total);
            document.getElementById('item-empty').classList.toggle('d-none', items.length > 0);
            document.getElementById('item-total').classList.toggle('d-none', items.length === 0);
            document.getElementById('item-count').textContent = `${items.length} item pemakaian`;
        }

        document.getElementById('obat_id').addEventListener('change', function () { document.getElementById('hja_preview').value = this.value ? rupiah.format(medicines[this.value].hja) : ''; });
        document.getElementById('tambah-item').addEventListener('click', function () {
            const obatId = document.getElementById('obat_id').value, debet = Number(document.getElementById('debet').value), kredit = Number(document.getElementById('kredit').value);
            if (!obatId || debet < 1 || kredit < 0 || kredit > debet) { Swal.fire({ icon: 'warning', title: 'Item belum valid', text: 'Pilih obat dan pastikan debet minimal 1 serta kredit tidak melebihi debet.' }); return; }
            if (items.some(item => String(item.obat_id) === String(obatId))) { Swal.fire({ icon: 'warning', title: 'Item sudah ditambahkan', text: 'Hapus item lama jika ingin mengganti jumlahnya.' }); return; }
            items.push({ obat_id: obatId, debet, kredit }); renderItems();
            document.getElementById('obat_id').value = ''; document.getElementById('hja_preview').value = ''; document.getElementById('debet').value = 1; document.getElementById('kredit').value = 0;
        });
        document.getElementById('item-body').addEventListener('click', event => { const button = event.target.closest('.remove-item'); if (button) { items.splice(Number(button.dataset.index), 1); renderItems(); } });
        document.querySelectorAll('.pilih-jadwal').forEach(button => button.addEventListener('click', () => chooseSchedule(button.dataset.id)));
        $('#jadwal-table').DataTable({ pageLength: 5, order: [[1, 'desc']], columnDefs: [{ orderable: false, targets: -1 }], language: { search: 'Cari pasien:', lengthMenu: 'Tampilkan _MENU_', info: '_START_–_END_ dari _TOTAL_ jadwal', infoEmpty: 'Tidak ada jadwal', emptyTable: 'Belum ada jadwal operasi.', zeroRecords: 'Jadwal tidak ditemukan', paginate: { previous: 'Sebelumnya', next: 'Berikutnya' } } });
        document.getElementById('pemakaian-form').addEventListener('submit', event => { if (!document.getElementById('jadwal_operasi_id').value || items.length === 0) { event.preventDefault(); Swal.fire({ icon: 'warning', title: 'Data belum lengkap', text: 'Pilih pasien dari jadwal operasi dan tambahkan minimal satu obat / alkes.' }); } });
        @if(old('jadwal_operasi_id')) chooseSchedule(@json((string) old('jadwal_operasi_id'))); @endif
        renderItems();
        @if($errors->any()) Swal.fire({ icon: 'error', title: 'Data belum dapat disimpan', html: `<ul class="text-start mb-0">${@json($errors->all()).map(error => `<li>${escapeHtml(error)}</li>`).join('')}</ul>` }); @endif
    </script>
</body>
</html>
