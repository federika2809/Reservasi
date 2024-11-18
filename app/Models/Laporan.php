<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_user',
        'id_ruangan',
        'id_reservasi',
        'tanggal_kegiatan',
        'tujuan_kegiatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }
    
}
