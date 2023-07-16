<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Absensi;

class KelolaIzinController extends Controller
{
    public function show($id)
    {
        return Izin::with('user')->findOrFail($id)->toJson();
    }
    public function pending()
    {
        $data['izins'] = Izin::where('status_approval', 2)->get();
        return view('admin.izin.pending')->with($data);
    }
    public function konfirmasi(Request $request)
    {
        $izin = Izin::where('id', $request->id_pengajuan)->first();
        try {
            if ($request->konfirmasi_pengajuan === 'setuju') {
                Izin::where('id', $request->id_pengajuan)->update([
                    'status_approval' => 1,
                ]);
                $tipe = $izin->tipe;
    
                if ($tipe === 'izin') {
                    $data['status_absensi'] = 4;
                } elseif ($tipe === 'sakit') {
                    $data['status_absensi'] = 3;
                } elseif ($tipe === 'cuti') {
                    $data['status_absensi'] = 2;
                }
    
            } elseif ($request->konfirmasi_pengajuan === 'tolak') {
                Izin::where('id', $request->id_pengajuan)->update([
                    'status_approval' => 0,
                ]);
                $data['status_absensi'] = 7;
            }
            $data['tgl_absensi'] = $izin->tanggal_untuk_pengajuan;
            $data['user_id'] = $izin->user_id;
            $absen = Absensi::where('tgl_absensi', $izin->tanggal_untuk_pengajuan)
                ->where('user_id', $izin->user_id)
                ->first();
            if (!$absen) {
                $data['created_at'] = $data['tgl_absensi'] . ' 06:00:00';
                $data['updated_at'] = null;
                Absensi::create($data);
            } else {
                $absen->update([
                    'status_absensi' => $data['status_absensi'],
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()
            ->back()
            ->withErrors($th->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Aksi Berhasil Dilakukan');
    }
    public function ditolak()
    {
        $data['ditolaks'] = Izin::where('status_approval', 0)->get();
        return view('admin.izin.ditolak')->with($data);
    }
    public function disetujui()
    {
        $data['disetujuis'] = Izin::where('status_approval', 1)->get();
        return view('admin.izin.disetujui')->with($data);
    }
}
