<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PeriodeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PeriodeDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }
        return view('admin/periode/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|unique:periodes',
            'nominal' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        Periode::create($request->all());
        return response()->json(['message' => 'Berhasil di tambahkan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periode = Periode::findOrFail($id);
        return response()->json(['data' => $periode]);
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
        $validator = Validator::make($request->all(), [
            'tahun' => 'required',
            'nominal' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        Periode::findOrFail($id)->update($request->all());
        return response()->json(['message' => 'Berhasil diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Periode::findOrFail($id)->delete();
        return response()->json(['message' => 'Berhasil hapus data!']);
    }
}
