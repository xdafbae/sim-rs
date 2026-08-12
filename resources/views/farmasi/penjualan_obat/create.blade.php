<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php($isEdit = isset($penjualanObat))
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isEdit ? 'Edit' : 'Input' }} Penjualan Obat | {{ config('app.name', 'SIM-RS') }}</title>
    @include('layouts.style')
    <style>
        .page-body { background: #f5f7fb; }
        .form-label { margin-bottom: .3rem; font-weight: 600; }
        .section-heading { font-size: .95rem; font-weight: 700; }
        .depo-banner { background: linear-gradient(135deg, #0f766e, #0d9488); color: #fff; }
        .item-table th { font-size: .75rem; white-space: nowrap; }
        .item-empty { height: 215px; }
        /* Hilangkan border gelap bawaan DataTables, termasuk saat tabel kosong. */
        #item-obat-table.dataTable,
        #item-obat-table.dataTable tbody,
        #item-obat-table.dataTable tbody tr,
        #item-obat-table.dataTable tbody tr > th,
        #item-obat-table.dataTable tbody tr > td {
            border-bottom: 0 !important;
            box-shadow: none !important;
        }
        #item-obat-table.dataTable > tbody > tr:last-child > .dt-empty,
        #item-obat-table.dataTable > tbody > tr:last-child > td,
        #item-obat-table.dataTable > tbody > tr:last-child > th {
            border-bottom: 0 none transparent !important;
            border-bottom-width: 0 !important;
        }
        #item-obat-table_wrapper .dt-scroll-body,
        #item-obat-table_wrapper .dataTables_scrollBody {
            border-bottom: 0 !important;
        }
        .action-footer { position: sticky; bottom: 0; z-index: 10; box-shadow: 0 -8px 20px rgba(31, 41, 55, .08); }
        @media (min-width: 1200px) { .patient-card { min-height: 360px; } }
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
                        <div>
                            <div class="page-pretitle">Modul Farmasi</div>
                            <h1 class="page-title">{{ $isEdit ? 'Edit' : 'Input' }} Penjualan Obat</h1>
                        </div>
                        <a href="{{ route('farmasi.penjualan-obat.index') }}" class="btn btn-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>

                    <form id="penjualan-obat-form" action="{{ $isEdit ? route('farmasi.penjualan-obat.update', $penjualanObat) : route('farmasi.penjualan-obat.store') }}" method="POST">
                        @csrf
                        @if($isEdit) @method('PUT') @endif
                        <div class="row g-3">
                            <div class="col-xl-8">
                                <section class="card patient-card h-100">
                                    <div class="card-header"><h2 class="card-title section-heading mb-0"><i class="bi bi-person-vcard me-2 text-primary"></i>Identitas Pasien</h2></div>
                                    <div class="card-body">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-4"><label class="form-label" for="no_rm">No. RM <span class="text-danger">*</span></label><input id="no_rm" name="no_rm" value="{{ old('no_rm', $penjualanObat->no_rm ?? '') }}" class="form-control @error('no_rm') is-invalid @enderror" placeholder="Masukkan No. RM" required>@error('no_rm')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                            <div class="col-md-5"><label class="form-label" for="no_copy_resep">No. Copy Resep</label><input id="no_copy_resep" name="no_copy_resep" value="{{ old('no_copy_resep', $penjualanObat->no_copy_resep ?? '') }}" class="form-control" placeholder="Nomor copy resep"></div>
                                            <div class="col-md-3"><button type="button" class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>Cari</button></div>
                                            <div class="col-12"><label class="form-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label><input id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien', $penjualanObat->nama_pasien ?? '') }}" class="form-control @error('nama_pasien') is-invalid @enderror" required>@error('nama_pasien')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                                            <div class="col-md-4"><label class="form-label" for="tanggal_lahir">Tanggal Lahir</label><input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir', isset($penjualanObat) && $penjualanObat->tanggal_lahir ? $penjualanObat->tanggal_lahir->format('Y-m-d') : '') }}" class="form-control"></div>
                                            <div class="col-md-4"><label class="form-label" for="jenis_kelamin">Jenis Kelamin</label><select id="jenis_kelamin" name="jenis_kelamin" class="form-select"><option value="">Pilih</option><option value="Laki-laki" @selected(old('jenis_kelamin', $penjualanObat->jenis_kelamin ?? '') === 'Laki-laki')>Laki-laki</option><option value="Perempuan" @selected(old('jenis_kelamin', $penjualanObat->jenis_kelamin ?? '') === 'Perempuan')>Perempuan</option></select></div>
                                            <div class="col-md-4"><label class="form-label" for="status_pasien">Status</label><input id="status_pasien" name="status_pasien" value="{{ old('status_pasien', $penjualanObat->status_pasien ?? '') }}" class="form-control"></div>
                                            <div class="col-12"><label class="form-label" for="alamat">Alamat</label><textarea id="alamat" name="alamat" rows="2" class="form-control">{{ old('alamat', $penjualanObat->alamat ?? '') }}</textarea></div>
                                            <div class="col-md-6"><label class="form-label" for="kecamatan">Kecamatan</label><input id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $penjualanObat->kecamatan ?? '') }}" class="form-control"></div>
                                            <div class="col-md-6"><label class="form-label" for="kabupaten">Kabupaten</label><input id="kabupaten" name="kabupaten" value="{{ old('kabupaten', $penjualanObat->kabupaten ?? '') }}" class="form-control"></div>
                                            <div class="col-md-4"><label class="form-label" for="pekerjaan">Pekerjaan</label><input id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $penjualanObat->pekerjaan ?? '') }}" class="form-control"></div>
                                            <div class="col-md-4"><label class="form-label" for="no_ktp">No. KTP</label><input id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $penjualanObat->no_ktp ?? '') }}" class="form-control"></div>
                                            <div class="col-md-4"><label class="form-label" for="telepon">No. Telepon / HP</label><input id="telepon" name="telepon" value="{{ old('telepon', $penjualanObat->telepon ?? '') }}" class="form-control"></div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-xl-4">
                                <div class="card mb-3">
                                    <div class="card-body depo-banner rounded text-center py-4">
                                        <div class="small text-white-50">Anda bekerja di DEPO</div>
                                        <div class="h2 text-white mb-0">GUDANG / APOTIK</div>
                                    </div>
                                </div>
                                <section class="card">
                                    <div class="card-header"><h2 class="card-title section-heading mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Data Transaksi</h2></div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-7"><label class="form-label" for="no_transaksi">No. Transaksi</label><input id="no_transaksi" name="no_transaksi" value="{{ old('no_transaksi', $penjualanObat->no_transaksi ?? $nomorTransaksi) }}" class="form-control" readonly></div>
                                            <div class="col-5 d-flex align-items-end"><button type="button" class="btn btn-outline-primary w-100">Cari Struk</button></div>
                                            <div class="col-6"><label class="form-label" for="akomodasi">Akomodasi</label><input id="akomodasi" name="akomodasi" type="number" min="0" step="0.01" value="{{ old('akomodasi', $penjualanObat->akomodasi ?? 0) }}" class="form-control"></div>
                                            <div class="col-6"><label class="form-label" for="berat_badan">BB (gram)</label><input id="berat_badan" name="berat_badan" type="number" min="0" value="{{ old('berat_badan', $penjualanObat->berat_badan ?? '') }}" class="form-control"></div>
                                            <div class="col-12"><label class="form-label" for="tanggal">Tanggal <span class="text-danger">*</span></label><input id="tanggal" name="tanggal" type="datetime-local" value="{{ old('tanggal', isset($penjualanObat) ? $penjualanObat->tanggal->format('Y-m-d\\TH:i') : now()->format('Y-m-d\\TH:i')) }}" class="form-control" required></div>
                                            <div class="col-12"><label class="form-label" for="nama_dokter">Nama Dokter</label><input id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter', $penjualanObat->nama_dokter ?? '') }}" class="form-control" placeholder="Pilih atau masukkan nama dokter"></div>
                                            <div class="col-12"><button type="button" class="btn btn-outline-secondary w-100"><i class="bi bi-printer me-2"></i>Print / Check SEP</button></div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-12">
                                <section class="card">
                                    <div class="card-header border-bottom-0">
                                        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                                            <li class="nav-item"><a href="#penjualan" class="nav-link active" data-bs-toggle="tab">Penjualan</a></li>
                                            <li class="nav-item"><a href="#retur" class="nav-link" data-bs-toggle="tab">Retur</a></li>
                                            <li class="nav-item"><a href="#jurnal" class="nav-link" data-bs-toggle="tab">Jurnal Obat / Alkes</a></li>
                                            <li class="nav-item"><a href="#lab-simrs" class="nav-link" data-bs-toggle="tab">Laboratorium SIMRS</a></li>
                                            <li class="nav-item"><a href="#lab-lis" class="nav-link" data-bs-toggle="tab">Laboratorium LIS</a></li>
                                            <li class="nav-item"><a href="#radiologi" class="nav-link" data-bs-toggle="tab">Radiologi</a></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div id="penjualan" class="tab-pane active show">
                                            <div class="table-responsive">
                                                <table id="item-obat-table" class="table table-vcenter item-table mb-0">
                                                    <thead><tr><th>#</th><th>Qty</th><th>Nama Obat / Alkes</th><th>HJA</th><th>Biaya</th><th>Signa</th><th>Aksi</th></tr></thead>
                                                    <tbody id="item-obat-body"></tbody>
                                                </table>
                                            </div>
                                            <div class="card-body border-top">
                                                <div class="row g-2 align-items-end">
                                                    <div class="col-md-4"><label class="form-label" for="cari_obat">Nama Obat / Alkes</label><input id="cari_obat" class="form-control" placeholder="Masukkan nama obat..."></div>
                                                    <div class="col-md-2"><label class="form-label" for="item_qty">Qty</label><input id="item_qty" type="number" min="1" value="1" class="form-control"></div>
                                                    <div class="col-md-2"><label class="form-label" for="item_harga">HJA</label><input id="item_harga" type="number" min="0" step="0.01" class="form-control"></div>
                                                    <div class="col-md-3"><label class="form-label" for="item_signa">Signa</label><input id="item_signa" class="form-control" placeholder="Contoh: 3 x 1"></div>
                                                    <div class="col-auto"><button id="tambah-item" type="button" class="btn btn-primary">Tambah</button></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="retur" class="tab-pane"><div class="card-body text-secondary">Data retur belum tersedia.</div></div>
                                        <div id="jurnal" class="tab-pane"><div class="card-body text-secondary">Data jurnal obat / alkes belum tersedia.</div></div>
                                        <div id="lab-simrs" class="tab-pane"><div class="card-body text-secondary">Data laboratorium SIMRS belum tersedia.</div></div>
                                        <div id="lab-lis" class="tab-pane"><div class="card-body text-secondary">Data laboratorium LIS belum tersedia.</div></div>
                                        <div id="radiologi" class="tab-pane"><div class="card-body text-secondary">Data radiologi belum tersedia.</div></div>
                                    </div>
                                    <div class="card-footer d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-outline-secondary">Struk</button><button type="button" class="btn btn-outline-secondary">No. Pengambilan</button><button type="button" class="btn btn-outline-secondary">E-Tiket</button><button type="button" class="btn btn-outline-secondary">Copy Resep</button><button type="button" class="btn btn-outline-secondary">Telaah Farmasi</button>
                                        <div class="ms-auto d-flex gap-2"><button id="tambah-item-footer" type="button" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Item</button></div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="action-footer bg-white border rounded mt-3 p-3 d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-lg-center">
                            <div class="d-flex flex-wrap gap-2"><button type="button" class="btn btn-outline-secondary">Print Preview</button><button type="button" class="btn btn-outline-primary">Mulai ›››› Penyediaan</button><button type="button" class="btn btn-outline-primary">Verifikasi ›››› Selesai</button><button type="button" class="btn btn-outline-primary">Penyerahan ›››› Diserahkan</button><button type="button" class="btn btn-outline-primary">Apotek Online</button><div class="form-check align-self-center"><input id="jasa_farmasi" name="jasa_farmasi" class="form-check-input" type="checkbox"><label for="jasa_farmasi" class="form-check-label">Jasa Farmasi</label></div></div>
                            <div class="d-flex gap-2"><button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button><a href="{{ route('farmasi.penjualan-obat.index') }}" class="btn btn-outline-danger">Batal</a></div>
                        </div>
                    </form>
                </div>
            </main>
            @include('layouts.footer')
        </div>
    </div>
    @include('layouts.script')
    <script>
        const itemsAwal = @json(old('items', $penjualanObat->items ?? []));
        const items = Array.isArray(itemsAwal) ? itemsAwal : [];
        const tbody = document.getElementById('item-obat-body');
        const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
        const itemTable = new DataTable('#item-obat-table', {
            ordering: true,
            searching: true,
            paging: true,
            pageLength: 5,
            lengthMenu: [5, 10, 25],
            scrollX: true,
            autoWidth: false,
            columnDefs: [{ orderable: false, targets: 6 }],
            language: {
                search: 'Cari item:',
                lengthMenu: 'Tampilkan _MENU_ item',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ item',
                infoEmpty: 'Belum ada item obat',
                emptyTable: 'Belum ada item obat',
                zeroRecords: 'Item tidak ditemukan',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
            }
        });

        const escapeHtml = (value) => { const element = document.createElement('span'); element.textContent = value || ''; return element.innerHTML; };
        @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Data belum dapat disimpan',
            html: `<ul class="text-start mb-0">${@json($errors->all()).map(error => `<li>${escapeHtml(error)}</li>`).join('')}</ul>`,
            confirmButtonText: 'Mengerti'
        });
        @endif
        function renderItems() {
            itemTable.clear();
            itemTable.rows.add(items.map((item, index) => {
                const qty = Number(item.qty) || 0, harga = Number(item.harga) || 0;
                return [index + 1, qty, escapeHtml(item.nama), rupiah.format(harga), rupiah.format(qty * harga), escapeHtml(item.signa || '-'), `<button type="button" class="btn btn-sm btn-outline-danger hapus-item" data-index="${index}" title="Hapus item"><i class="bi bi-trash"></i></button>`];
            }));
            itemTable.draw(false);
        }
        function tambahItem() {
            const nama = document.getElementById('cari_obat'), qty = document.getElementById('item_qty'), harga = document.getElementById('item_harga'), signa = document.getElementById('item_signa');
            if (!nama.value.trim() || Number(qty.value) < 1 || harga.value === '' || Number(harga.value) < 0) {
                Swal.fire({ icon: 'warning', title: 'Item belum lengkap', text: 'Isi nama obat, qty, dan harga dengan benar.', confirmButtonText: 'Mengerti' });
                return;
            }
            items.push({ nama: nama.value.trim(), qty: Number(qty.value), harga: Number(harga.value), signa: signa.value.trim() });
            nama.value = ''; qty.value = 1; harga.value = ''; signa.value = ''; nama.focus(); renderItems();
        }
        document.getElementById('tambah-item').addEventListener('click', tambahItem);
        document.getElementById('tambah-item-footer').addEventListener('click', () => document.getElementById('cari_obat').focus());
        tbody.addEventListener('click', function (event) {
            const button = event.target.closest('.hapus-item');
            if (!button) return;
            items.splice(Number(button.dataset.index), 1);
            renderItems();
        });
        document.getElementById('penjualan-obat-form').addEventListener('submit', function () {
            this.querySelectorAll('.item-input').forEach(input => input.remove());
            items.forEach((item, index) => ['nama', 'qty', 'harga', 'signa'].forEach(key => {
                const input = document.createElement('input'); input.type = 'hidden'; input.className = 'item-input';
                input.name = `items[${index}][${key}]`; input.value = item[key] ?? ''; this.appendChild(input);
            }));
        });
        renderItems();
    </script>
</body>
</html>
