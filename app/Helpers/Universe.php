<?php

namespace App\Helpers;

use App\Models\Petugas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;


class Universe
{
    public static function petugas()
    {
        return Petugas::where('user_id', Auth::user()->id)->first();
    }
    public static function siswa()
    {
        return Siswa::where('user_id', Auth::user()->id)->first();
    }
}
