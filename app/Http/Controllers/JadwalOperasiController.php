<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJadwalOperasiRequest;
use App\Models\JadwalOperasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalOperasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            abort_unless($request->user()?->role === 'superadmin', 403);

            return $next($request);
        });
    }

    public function index(): View
    {
        return view('jadwal-operasi.index');
    }

    public function data(Request $request): JsonResponse
    {
        $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date'],
        ]);

        $columns = [
            'no_booking',
            'created_at',
            'tanggal_rencana_operasi',
            'tanggal_jadwal_operasi',
            'tanggal_operasi_tindakan',
            'no_rm',
            'nama_pasien',
            'tanggal_lahir',
            'jenis_kelamin',
            'golongan_darah',
            'no_bpjs',
            'jenis_pelayanan',
            'tipe_pelayanan',
            'keterangan_deskripsi',
            'pemberi_instruksi',
            'id',
        ];

        $query = JadwalOperasi::query();
        $recordsTotal = (clone $query)->count();

        $query
            ->when($request->filled('tanggal_mulai'), function ($query) use ($request) {
                $query->whereDate('tanggal_jadwal_operasi', '>=', $request->string('tanggal_mulai'));
            })
            ->when($request->filled('tanggal_selesai'), function ($query) use ($request) {
                $query->whereDate('tanggal_jadwal_operasi', '<=', $request->string('tanggal_selesai'));
            });

        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('no_booking', 'like', "%{$search}%")
                    ->orWhere('no_rm', 'like', "%{$search}%")
                    ->orWhere('nama_pasien', 'like', "%{$search}%")
                    ->orWhere('no_bpjs', 'like', "%{$search}%")
                    ->orWhere('jenis_pelayanan', 'like', "%{$search}%")
                    ->orWhere('tipe_pelayanan', 'like', "%{$search}%")
                    ->orWhere('keterangan_deskripsi', 'like', "%{$search}%")
                    ->orWhere('no_slip', 'like', "%{$search}%")
                    ->orWhere('pemberi_instruksi', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = (clone $query)->count();
        $orderIndex = (int) $request->input('order.0.column', 3);
        $orderColumn = $columns[$orderIndex] ?? 'tanggal_jadwal_operasi';
        $orderDirection = $request->input('order.0.dir') === 'desc' ? 'desc' : 'asc';
        $start = max((int) $request->input('start', 0), 0);
        $requestedLength = (int) $request->input('length', 10);
        $length = $requestedLength > 0 ? min($requestedLength, 100) : 10;

        $jadwalOperasi = $query
            ->orderBy($orderColumn, $orderDirection)
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'draw' => (int) $request->input('draw', 0),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $jadwalOperasi->map(function (JadwalOperasi $jadwal): array {
                $kategoriClass = $jadwal->tipe_pelayanan === 'Operatif'
                    ? 'bg-blue-lt text-blue'
                    : 'bg-azure-lt text-azure';
                $keterangan = e($jadwal->keterangan_deskripsi ?: '-');

                if ($jadwal->no_slip) {
                    $keterangan .= '<div class="text-secondary small mt-1">No. Slip: '.e($jadwal->no_slip).'</div>';
                }

                return [
                    'no_booking' => e($jadwal->no_booking),
                    'tanggal_pengajuan' => $jadwal->created_at->format('d/m/Y H:i'),
                    'tanggal_rencana' => $jadwal->tanggal_rencana_operasi->format('d/m/Y H:i'),
                    'tanggal_dijadwalkan' => $jadwal->tanggal_jadwal_operasi->format('d/m/Y H:i'),
                    'tanggal_operasi' => $jadwal->tanggal_operasi_tindakan?->format('d/m/Y H:i') ?? '-',
                    'no_rm' => e($jadwal->no_rm),
                    'nama_pasien' => e($jadwal->nama_pasien),
                    'tanggal_lahir' => $jadwal->tanggal_lahir->format('d/m/Y'),
                    'jenis_kelamin' => e($jadwal->jenis_kelamin),
                    'golongan_darah' => e($jadwal->golongan_darah ?: '-'),
                    'no_bpjs' => e($jadwal->no_bpjs ?: '-'),
                    'jenis_pelayanan' => e($jadwal->jenis_pelayanan),
                    'kategori' => '<span class="badge '.$kategoriClass.'">'.e($jadwal->tipe_pelayanan).'</span>',
                    'keterangan' => $keterangan,
                    'instruksi_dokter' => e($jadwal->pemberi_instruksi),
                    'aksi' => sprintf(
                        '<div class="btn-list flex-nowrap"><a href="%s" class="btn btn-sm">Edit</a><button type="button" class="btn btn-sm btn-outline-danger" data-delete-url="%s" data-patient-name="%s">Hapus</button></div>',
                        e(route('jadwal-operasi.edit', $jadwal)),
                        e(route('jadwal-operasi.destroy', $jadwal)),
                        e($jadwal->nama_pasien)
                    ),
                ];
            })->values(),
        ]);
    }

    public function create(): View
    {
        return view('jadwal-operasi.create');
    }

    public function store(StoreJadwalOperasiRequest $request): RedirectResponse
    {
        JadwalOperasi::create($request->validated());

        return redirect()
            ->route('jadwal-operasi.index')
            ->with('success', 'Jadwal operasi berhasil disimpan.');
    }

    public function edit(JadwalOperasi $jadwalOperasi): View
    {
        return view('jadwal-operasi.create', compact('jadwalOperasi'));
    }

    public function update(StoreJadwalOperasiRequest $request, JadwalOperasi $jadwalOperasi): RedirectResponse
    {
        $jadwalOperasi->update($request->validated());

        return redirect()
            ->route('jadwal-operasi.index')
            ->with('success', 'Jadwal operasi berhasil diperbarui.');
    }

    public function destroy(JadwalOperasi $jadwalOperasi): JsonResponse
    {
        $jadwalOperasi->delete();

        return response()->json([
            'message' => 'Jadwal operasi berhasil dihapus.',
        ]);
    }
}
