<div class="table-responsive result-grid">
    <div class="px-3 py-2 small text-secondary border-bottom">Tarik header kolom ke sini untuk mengelompokkan data berdasarkan kolom tersebut.</div>
    <table class="table table-bordered table-vcenter mb-0 text-nowrap">
        <thead><tr>@foreach ($columns as $column)<th>{{ $column }} :</th>@endforeach</tr></thead>
        <tbody><tr class="empty-result"><td colspan="{{ count($columns) }}">&lt;Tidak ada data untuk ditampilkan&gt;</td></tr></tbody>
    </table>
</div>
