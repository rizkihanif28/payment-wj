<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PembayaranDataTable;
use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class ManajemenPembayaranController extends Controller
{
    public function index(Request $request, PembayaranDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }
        return view('admin/manajemen-pembayaran/index');
    }

    public function destroy($id)
    {
        Pembayaran::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Data pembayaran berhasil dihapus!'
        ]);
    }
}
