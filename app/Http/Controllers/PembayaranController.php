<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Periode;
use App\Models\Petugas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use NumberFormatter;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;

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
    public function bayarValidate(Request $request, $nisn)
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
                <i class="fas fa-money-check"></i> DETAIL
                </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pembayaran/status-pembayaran');
    }
    public function statusPembayaranDetail()
    {
        $periode = Periode::all();
        $siswa = Siswa::all()->first();
        return view('pembayaran/status-pembayaranDetail', compact('siswa', 'periode'));
    }

    public function statusPembayaranList()
    {
        $siswa = Siswa::all()->first();
        $periode = Periode::all()->first();

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
                    $btn = '<div class="print"><a href="' . route('pembayaran.history-pembayaran', $row->id) .
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
