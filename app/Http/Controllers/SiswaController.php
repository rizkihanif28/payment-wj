<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

// use Yajra\DataTables\DataTables;

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
        $siswa = Siswa::all()->first();
        $periode = Periode::all();

        return view('siswa/status-pembayaranDetail', compact('siswa', 'periode'));
    }

    public function statusPembayaranBulan($tahun)
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();

        $periode = Periode::where('tahun', $tahun)
            ->first();

        $pembayaran = Pembayaran::with(['siswa'])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_bayar', $periode->tahun)
            ->get();

        return view('siswa/status-pembayaran-bulan', compact('siswa', 'periode', 'pembayaran'));
    }
}
