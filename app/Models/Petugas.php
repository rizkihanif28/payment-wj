<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_petugas',
        'nip',
        'nama_petugas',
        'jenis_kelamin',
        'email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
