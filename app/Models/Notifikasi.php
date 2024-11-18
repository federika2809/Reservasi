<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notifikasi extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_notifikasi';
    public $timestamps = false;
    protected $fillable = [
        'id_admin',
        'id_user',
        'id_reservasi',
        'status_verifikasi',
        'pesan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }
}
