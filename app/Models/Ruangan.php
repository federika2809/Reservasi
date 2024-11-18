<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ruangan extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'lokasi',
        'fasilitas',
        'status',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservasi::class, 'id_ruangan');
    }

    public function isAvailable($tanggal, $waktu_mulai, $waktu_selesai)
    {
        return !$this->reservations()
            ->where('tanggal_kegiatan', $tanggal)
            ->where(function($query) use ($waktu_mulai, $waktu_selesai) {
                $query->whereBetween('waktu_mulai', [$waktu_mulai, $waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$waktu_mulai, $waktu_selesai]);
            })
            ->where('status_verifikasi', '!=', 'ditolak')
            ->exists();
    }
}
