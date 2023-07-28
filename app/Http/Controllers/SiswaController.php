<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Periode;
use App\Models\Petugas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function indexHistory(Request $request)
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();

        $pembayaran = Pembayaran::with(['siswa' => function ($query) {
            $query->with('kelas');
        }])
            ->where('siswa_id', $siswa->id)
            ->get();

        return view('siswa/history-pembayaran', compact('pembayaran', 'siswa'));
    }

    public function statusPembayaranDetail()
    {
        $periode = Periode::all();

        $siswa = Siswa::where('user_id', Auth::user()->id)->first();

        return view('siswa/status-pembayaranDetail', compact('periode', 'siswa'));
    }

    public function statusPembayaranBulan($tahun)
    {
        $periode = Periode::where('tahun', $tahun)
            ->first();

        $siswa = Siswa::where('user_id', Auth::user()->id)
            ->first();

        $pembayaran = Pembayaran::with(['siswa'])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_bayar', $periode->tahun)
            ->oldest()
            ->get();

        return view('siswa/status-pembayaran-bulan', compact('siswa', 'periode', 'pembayaran'));
    }

    public function formBayarSiswa($nisn)
    {
        $siswa = Siswa::with(['kelas'])
            ->first();
        $periode = Periode::all();

        return view('siswa/formBayar', compact('siswa', 'periode'));
    }

    public function siswaBayarPeriode($tahun)
    {
        $periode = Periode::where('tahun', $tahun)->first();
        return response()->json([
            'data' => $periode,
            'nominal_rupiah' => 'Rp ' . number_format($periode->nominal, 0, 2, '.'),

        ]);
    }

    public function siswaBayarValidate(Request $request)
    {
        $request->validate([
            'jumlah_bayar' => 'required',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong!'
        ]);

        $pembayaran = Pembayaran::whereIn('bulan_bayar', $request->bulan_bayar)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->where('siswa_id', $request->siswa_id)
            ->pluck('bulan_bayar')
            ->toArray();

        if (!$pembayaran) {
            DB::transaction(function () use ($request) {
                foreach ($request->bulan_bayar as $bulan) {
                    Pembayaran::create([
                        'kode_pembayaran' => 'SPPWJ-' . Str::upper(Str::random(5)),
                        'siswa_id' => $request->siswa_id,
                        'nisn' => $request->nisn,
                        'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                        'tahun_bayar' => $request->tahun_bayar,
                        'bulan_bayar' => $bulan,
                        'jumlah_bayar' => $request->jumlah_bayar
                    ]);
                }
            });
            return redirect()->route('siswa.history-pembayaran')
                ->with('success', 'Transaksi berhasil disimpan!');
        } else {
            return back()
                ->with('error', 'Siswa Dengan Nama : ' . $request->nama_siswa . ' , NISN : ' .
                    $request->nisn . ' Sudah Membayar Spp di bulan (' .
                    implode($pembayaran,) . ")" . ' , di Tahun : ' . $request->tahun_bayar . ' , Pembayaran Dibatalkan');
        }
    }
}
