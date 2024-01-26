<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Auth;
use App\Models\User;

class RekapanPresensiController extends Controller
{
    public function guru(Request $request)
    {
        $data['users'] = User::whereNot('role_id', 1)->orderBy('nama', 'asc')->get();
        return view('admin.rekapan.guru')->with($data);
    }
    public function hariIni()
    {
        $user = User::whereNot('role_id', 1)->orderBy('nama', 'asc')->get();
        $absens = array();
        foreach ($user as $key => $value) {
            $absen = Absensi::where('user_id', $value->id)->where('tanggal_absensi', date('Y-m-d'))->first();
            if(!$absen){
                $value['status'] = 'Belum Absen';
                $value['jam'] = null;
            }else{
                if($absen->status_absensi == 0){
                    $value['status'] = 'Tidak Absen';
                }elseif($absen->status_absensi == 1){
                    if ($absen->created_at->format('H:i:s') < '08:00:00') {
                        $value['status'] = 'Hadir';
                    } else {
                        $value['status'] = 'Terlambat';
                    } 
                }elseif($absen->status_absensi == 2){
                    $value['status'] = 'Cuti';
                }elseif($absen->status_absensi == 3){
                    $value['status'] = 'Sakit';
                }elseif($absen->status_absensi == 4){
                    $value['status'] = 'Izin';
                }elseif($absen->status_absensi == 5){
                    $value['status'] = 'Hari Libur';
                }elseif($absen->status_absensi == 6){
                    $value['status'] = 'Tidak Ada Jadwal ';
                }elseif($absen->status_absensi == 7){
                    $value->status_absensi = 'Pengajuan Izin Ditolak';
                }else{
                    $value['status'] = 'Error';
                }
                $value['jam'] = $absen->created_at->format('H:i:s');
            }
            array_push($absens, $value);
        }
        return view('admin.rekapan.hariIni', compact('absens'));
    }
    public function showGuru($id, Request $request)
    {
        $data['user'] = User::where('id', $id)->first();
        $data['absens'] = Absensi::where('user_id', $id)->orderBy('tanggal_absensi','asc')->get();
        return view('admin.rekapan.show')->with($data);
    }
    public function tanggal(Request $request)
    {
        if($request->filled('tanggal')){
            $tmp = explode("-", $request->tanggal);
            $data['tglIni'] = $tmp[2];
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['absens'] = Absensi::with('user')->where('tanggal_absensi', $request->tanggal)->get();
        }else{
            $data['absens'] = null;
        }
        return view('admin.rekapan.tanggal')->with($data);
    }

    public function deleteAbsen($id)
    {
        try {
            Absensi::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
        return redirect()->back()->with('success', 'Absensi berhasil dihapus!');
    }

    public function tambahAbsen(Request $request)
    {
        $request->validate([
            'tanggal_absensi' => 'required|unique:absensis,tanggal_absensi',
            'status_absensi' => 'required'
        ]);

        try {
            $absen = new Absensi;
            $absen->create($request->input());
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
        return redirect()->back()->with('success', 'Absen berhasil ditambahkan!');
    }
}
