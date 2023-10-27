<?php

namespace App\Http\Controllers;

use App\DataTables\PembayaranDataTable;
use App\Helpers\Universe;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

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
        DB::beginTransaction();

        $request->request->add([
            'status' => 'unpaid'
        ]);

        $request->validate([
            'bulan_bayar' => 'required',
        ], [
            'bulan_bayar.required' => 'Bulan bayar tidak boleh kosong!'
        ]);

        $kelas = Kelas::all()->first();
        $user = User::where('id', Auth::user()->id)->first();
        $siswa = Siswa::where('id', $request->siswa_id);

        foreach ($request->bulan_bayar as $bulan) {
            $pembayaran = Pembayaran::create([
                'user_id' => $user->id,
                'siswa_id' => $request->siswa_id,
                'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                'bulan_bayar' => $bulan,
                'tahun_bayar' => $request->tahun_bayar,
                'jumlah_bayar' => $request->jumlah_bayar,
            ]);
        }
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $pembayaran->id,
                'gross_amount' => $request->jumlah_bayar,
            ),
            'customer_details' => array(
                'first_name' => $request->nama_siswa,
                'last_name' => '',
                'email' => $user->email,
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        DB::commit();
        return view('pembayaran.pembayaran-detail', compact('snapToken', 'kelas', 'pembayaran', 'user'));

        DB::rollBack();
        return back()
            ->with('error', 'Siswa Dengan Nama : ' . $request->nama_siswa . ' Sudah Membayar Spp di bulan tersebut'
                . ' , Tahun : ' . $request->tahun_bayar . ' , Pembayaran Dibatalkan');
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $pembayaran = Pembayaran::find($request->pembayaran_id);
                $pembayaran->update(['status' => 'paid']);
            }
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
            $data = Pembayaran::with(['user', 'siswa' => function ($query) {
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

    // log activity
    public function log(Pembayaran $pembayaran)
    {
        return view('pembayaran.log', [
            'logs' => Activity::where('subject_type', Pembayaran::class)
                ->where('subject_id', $pembayaran->id)->latest()->get()
        ]);
    }
}
