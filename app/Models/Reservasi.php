<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Reservasi extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_user' ,
        'id_ruangan',
        'tanggal_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
        'tujuan_kegiatan',
        'jumlah_peserta',
        'status_verifikasi'
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user' );
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_reservasi');
    }
}