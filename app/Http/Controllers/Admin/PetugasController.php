<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PetugasDataTable;
use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PetugasDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }
        return view('admin/petugas/index');
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
            'username' => 'required|unique:users',
            'nip' => 'required|unique:petugas',
            'nama_petugas' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email:rfc,dns|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => Str::lower($request->username),
                'email' => Str::lower($request->email),
                'password' => 'ptgs' . Hash::make(Str::random('2'))
            ]);
            $user->assignRole('petugas');

            Petugas::create([
                'user_id' => $user->id,
                'username' => $request->username,
                'kode_petugas' => 'PTGS' . Str::random(2),
                'nip' => $request->nip,
                'nama_petugas' => $request->nama_petugas,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email
            ]);
        });
        return response()->json(['message' => 'Data berhasil disimpan!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return response()->json(['data' => $petugas]);
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
            'nip' => 'required',
            'nama_petugas' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        Petugas::findOrFail($id)->update([
            'nip' => $request->nip,
            'nama_petugas' => $request->nama_petugas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email
        ]);
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
        $petugas = Petugas::findOrFail($id);
        User::findOrFail($petugas->user_id)->delete();
        $petugas->delete();

        return response()->json(['message' => 'Berhasil dihapus!']);
    }
}
