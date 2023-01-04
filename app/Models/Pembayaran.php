<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Periode;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'kode_pembayaran ',
        'petugas_id',
        'siswa_id',
        'nisn',
        'tanggal_bayar',
        'bulan_bayar',
        'tahun_bayar',
        'jumlah_bayar',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
