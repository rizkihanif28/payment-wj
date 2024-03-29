<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pembayaran;
use App\Models\Siswa;

class Periode extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun',
        'nominal'
    ];
}
