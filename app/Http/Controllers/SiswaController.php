<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Periode;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\User;
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
        DB::beginTransaction();

        $request->validate([
            'jumlah_bayar' => 'required',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong!'
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $pembayaran = Pembayaran::whereIn('bulan_bayar', $request->bulan_bayar)
            ->where('tahun_bayar', $request->tahun_bayar)
            ->where('siswa_id', $request->siswa_id)
            ->pluck('bulan_bayar')
            ->toArray();

        // membuat pembayaran
        if (!$pembayaran) {
            foreach ($request->bulan_bayar as $bulan) {
                Pembayaran::create([
                    'user_id' => $user->id,
                    'siswa_id' => $request->siswa_id,
                    'kode_pembayaran' => 'SPPWJ-' . Str::upper(Str::random(5)),
                    'status' => 'paid',
                    'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                    'bulan_bayar' => $bulan,
                    'tahun_bayar' => $request->tahun_bayar,
                    'jumlah_bayar' => $request->jumlah_bayar,
                ]);
            }
            DB::commit();
            return redirect()->route('siswa.history-pembayaran')
                ->with('success', 'Transaksi berhasil disimpan!');
        } else {
            DB::rollBack();
            return back()
                ->with('error', $request->nama_siswa . ' Sudah Membayar Spp di bulan (' .
                    implode($pembayaran,) . ") " . $request->tahun_bayar . ' Pembayaran Dibatalkan');
        }
    }
}
