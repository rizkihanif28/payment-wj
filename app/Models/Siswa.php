<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Periode;
use App\Models\Petugas;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'kode_siswa',
        'nisn',
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'email',
        'alamat',
        'telepon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
