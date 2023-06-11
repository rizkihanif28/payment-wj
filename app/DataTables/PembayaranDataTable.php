<?php

namespace App\DataTables;

use App\Models\Pembayaran;
use Yajra\DataTables\Facades\DataTables;

class PembayaranDataTable
{
    public function data()
    {
        $data = Pembayaran::with(['siswa' => function ($query) {
            $query->with('kelas');
        }, 'petugas'])->latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" id="' . $row->id .
                    '" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make('true');
    }
}
