<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;

class Pembayaran extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'user_id',
                'siswa_id',
                'kode_pembayaran',
                'status',
                'tanggal_bayar',
                'bulan_bayar',
                'tahun_bayar',
                'jumlah_bayar',
            ])
            ->setDescriptionForEvent(fn (string $eventName) => Auth::user()->username . " successfully {$eventName}")
            ->useLogName('Pembayaran');
    }

    // protected pembayaran 
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
