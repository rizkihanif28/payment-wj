<?php

namespace App\Http\Controllers;

use App\DataTables\PembayaranDataTable;
use App\Models\Pembayaran;
use App\Models\Periode;
use App\Models\Petugas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Siswa::with(['kelas'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row"><a href="' . route('pembayaran.form', $row->nisn) . '"class="btn btn-primary btn-sm ml-2">
                <i class="fas fa-money-check"></i> BAYAR
                </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pembayaran/index');
    }

    public function formBayar($nisn)
    {
        $siswa = Siswa::with(['kelas'])
            ->where('nisn', $nisn)
            ->first();

        $periode = Periode::all();

        return view('pembayaran/formBayar', compact('siswa', 'periode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function periode($tahun)
    {
        $periode = Periode::where('tahun', $tahun)->first();
        return response()->json([
            'data' => $periode,
            'nominal_rupiah' => 'Rp ' . number_format($periode->nominal, 0, 2, '.'),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bayarValidate(Request $request)
    {
        $request->validate([
            'jumlah_bayar' => 'required',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong!'
        ]);

        $petugas = Petugas::where('user_id', Auth::user()->id)->first();

        $pembayaran = Pembayaran::whereIn('bulan_bayar', $request->bulan_bayar)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->where('siswa_id', $request->siswa_id)
            ->pluck('bulan_bayar')
            ->toArray();

        if (!$pembayaran) {
            DB::transaction(function () use ($request, $petugas) {
                foreach ($request->bulan_bayar as $bulan) {
                    Pembayaran::create([
                        'kode_pembayaran' => 'SPPWJ-' . Str::upper(Str::random(5)),
                        'petugas_id' => $petugas->id,
                        'siswa_id' => $request->siswa_id,
                        'nisn' => $request->nisn,
                        'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                        'tahun_bayar' => $request->tahun_bayar,
                        'bulan_bayar' => $bulan,
                        'jumlah_bayar' => $request->jumlah_bayar
                    ]);
                }
            });
            return redirect()->route('pembayaran.history-pembayaran')
                ->with('success', 'Transaksi berhasil disimpan!');
        } else {
            return back()
                ->with('error', 'Siswa Dengan Nama : ' . $request->nama_siswa . ' , NISN : ' .
                    $request->nisn . ' Sudah Membayar Spp di bulan (' .
                    implode($pembayaran,) . ")" . ' , di Tahun : ' . $request->tahun_bayar . ' , Pembayaran Dibatalkan');
        }
    }

    public function statusPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Siswa::with(['kelas'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row"><a href="' . route('pembayaran.status-pembayaran.detail', $row->nisn) . '"class="btn btn-primary btn-sm ml-2">
                    <i class="fas fa-info-circle"></i> DETAIL
                </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pembayaran/status-pembayaran');
    }
    public function statusPembayaranDetail(Siswa $siswa)
    {
        $periode = Periode::all();
        return view('pembayaran/status-pembayaranDetail', compact('siswa', 'periode'));
    }

    public function statusPembayaranList($nisn, $tahun)
    {
        $siswa = Siswa::where('nisn', $nisn)
            ->first();
        $periode = Periode::where('tahun', $tahun)
            ->first();

        $pembayaran = Pembayaran::with(['siswa'])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_bayar', $periode->tahun)
            ->get();


        return view('pembayaran/status-pembayaranList', compact('siswa', 'periode', 'pembayaran'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function historyPembayaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Pembayaran::with(['petugas', 'siswa' => function ($query) {
                $query->with('kelas');
            }])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="print"><a href="' . route('pembayaran.history.print', $row->id) .
                        '"class="btn btn-primary btn-sm"> <i class="fas fa-print fa-fw"></i>
                        </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pembayaran/history-pembayaran');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function PrintHistoryPembayaran($id)
    {
        $data['pembayaran'] = Pembayaran::with(['petugas', 'siswa'])
            ->where('id', $id)
            ->first();

        $pdf = FacadePdf::loadView('pembayaran/history-print-preview', $data);
        return $pdf->stream();
    }

    public function laporan()
    {
        return view('pembayaran/laporan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printLaporan(Request $request)
    {
        $tanggal = $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        $data['pembayaran'] = Pembayaran::with(['petugas', 'siswa'])
            ->whereBetween('tanggal_bayar', $tanggal)->get();

        if ($data['pembayaran']->count() > 0) {
            $pdf = FacadePdf::loadView('pembayaran/laporan-print-preview', $data);
            return $pdf->download('SPP-WJ ' .
                Carbon::parse(request()->tanggal_mulai)->format('d-m-Y') . '-' .
                Carbon::parse(request()->tanggal_selesai)->format('d-m-Y') .
                '.pdf');
        } else {
            return back()->with(
                'error',
                'Data pembayaran spp tanggal ' .
                    Carbon::parse(request()->tanggal_mulai)->format('d-m-Y') . 'sampai dengan ' .
                    Carbon::parse(request()->tanggal_selesai)->format('d-m-Y') . ' tidak tersedia'
            );
        }
    }
}
