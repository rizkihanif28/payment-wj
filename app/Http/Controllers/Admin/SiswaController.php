<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SiswaDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-siswa'])->only(['index', 'show']);
        $this->middleware(['permission:create-siswa'])->only(['create', 'store']);
        $this->middleware(['permission:update-siswa'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-siswa'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SiswaDataTable $datatable)
    {
        if ($request->ajax()) {
            return $datatable->data();
        }

        $siswa = Siswa::all();
        $kelas = Kelas::all();

        return view('admin/siswa/index', compact('siswa', 'kelas'));
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
            'nama_siswa' => 'required',
            'username' => 'required|unique:users',
            'nisn' => 'required|unique:siswas',
            'nis' => 'required|unique:siswas',
            'email' => 'required|unique:users',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => Str::lower($request->username),
                'email' => Str::lower($request->email),
                'password' => 'wj' . Hash::make(Str::random('5'))
            ]);
            $user->assignRole('siswa');

            Siswa::create([
                'user_id' => $user->id,
                'kode_siswa' => 'SSW' . Str::upper(Str::random(5)),
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'kelas_id' => $request->kelas_id,
            ]);
        });
        return response()->json(['message' => 'Data berhasil di simpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
