<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Periode;
use Carbon\Carbon;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'user_id',
        'siswa_id',
        'kode_pembayaran',
        'status',
        'tanggal_bayar',
        'bulan_bayar',
        'tahun_bayar',
        'jumlah_bayar',
    ];

    public function getTanggalBayarAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getJumlahBayarAttribute($value)
    {
        return "Rp " . number_format($value, 0, 2, '.');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
