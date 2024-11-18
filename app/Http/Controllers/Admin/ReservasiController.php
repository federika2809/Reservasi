<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Ruangan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    public function index()
    {
        if (Auth::user()->usertype == ('admin')) {
            $reservasi = Reservasi::with(['user', 'ruangan'])->latest()->paginate(10);
        } else {
            $reservasi = Reservasi::with(['ruangan'])
                ->where('id_user', Auth::id())
                ->latest()
                ->paginate(10);
        }
        
        return view('reservasi.index', compact('reservasi'));
    }

    public function create()
    {
        $ruangan = Ruangan::all();
        return view('reservasi.create', compact('ruangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'tanggal_kegiatan' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'tujuan_kegiatan' => 'required|string',
            'jumlah_peserta' => 'required|integer|min:1'
        ]);

        // Check for conflicting reservations
        $conflicting = Reservasi::where('id_ruangan', $request->id_ruangan)
            ->where('tanggal_kegiatan', $request->tanggal_kegiatan)
            ->where(function($query) use ($request) {
                $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $request->waktu_selesai]);
            })
            ->exists();

        if ($conflicting) {
            return back()->withErrors(['message' => 'Ruangan sudah direservasi untuk waktu tersebut'])
                        ->withInput();
        }

        $reservasi = Reservasi::create([
            'id_user' => Auth::user()->usertype == ('admin'),
            'id_ruangan' => $request->id_ruangan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tujuan_kegiatan' => $request->tujuan_kegiatan,
            'jumlah_peserta' => $request->jumlah_peserta,
            'status_verifikasi' => 'pending'
        ]);

        // Create notification for admin
        Notifikasi::create([
            'id_user' => Auth::user()->usertype == ('admin'),
            'id_reservasi' => $reservasi->id_reservasi,
            'status_verifikasi' => 'pending',
            'pesan' => 'Reservasi baru menunggu verifikasi'
        ]);

        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat dan menunggu verifikasi admin.');
    }

    public function edit(Reservasi $reservasi)
    {
        // $this->authorize('update', $reservasi);
        $ruangan = Ruangan::all();
        return view('reservasi.edit', compact('reservasi', 'ruangan'));
    }

    public function update(Request $request, Reservasi $reservasi)
    {
        // $this->authorize('update', $reservasi);

        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'tanggal_kegiatan' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'tujuan_kegiatan' => 'required|string',
            'jumlah_peserta' => 'required|integer|min:1'
        ]);

        $conflicting = Reservasi::where('id_ruangan', $request->id_ruangan)
            ->where('tanggal_kegiatan', $request->tanggal_kegiatan)
            ->where('id_reservasi', '!=', $reservasi->id_reservasi)
            ->where(function($query) use ($request) {
                $query->whereBetween('waktu_mulai', [$request->waktu_mulai, $request->waktu_selesai])
                    ->orWhereBetween('waktu_selesai', [$request->waktu_mulai, $request->waktu_selesai]);
            })
            ->exists();

        if ($conflicting) {
            return back()->withErrors(['message' => 'Ruangan sudah direservasi untuk waktu tersebut'])
                        ->withInput();
        }

        $reservasi->update($request->all());

        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function destroy(Reservasi $reservasi)
    {
        // $this->authorize('delete', $reservasi);
        
        $reservasi->delete();

        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function verifikasi(Request $request, Reservasi $reservasi)
    {
        // $this->authorize('verify', $reservasi);

        $request->validate([
            'status_verifikasi' => 'required|in:approved,rejected',
            'pesan' => 'required|string'
        ]);

        $reservasi->update([
            'status_verifikasi' => $request->status_verifikasi
        ]);

        // Create notification for user
        Notifikasi::create([
            'id_user' => $reservasi->id_user,
            'id_reservasi' => $reservasi->id_reservasi,
            'status_verifikasi' => $request->status_verifikasi,
            'pesan' => $request->pesan
        ]);

        return redirect()->route('reservasi.index')
            ->with('success', 'Status reservasi berhasil diperbarui.');
    }
}