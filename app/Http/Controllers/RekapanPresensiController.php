<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Auth;
use App\Models\User;

class RekapanPresensiController extends Controller
{
    public function index(Request $request)
    {
        
        if($request->filled('bulan')){
            $tmp = explode("-", $request->bulan);
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['bulans'] = Absensi::whereYear('tgl_absensi', $tmp[0])->whereMonth('tgl_absensi', $tmp[1])->where('user_id', Auth::user()->id)->get();
        }else{
            $data['bulans'] = null;
        }

        return view('rekapan.index')->with($data);
    }
    public function guru(Request $request)
    {
        $data['users'] = User::where('role_id', 2)->get();
        if($request->filled('bulan')){
            $tmp = explode("-", $request->bulan);
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['bulans'] = Absensi::whereYear('tgl_absensi', $tmp[0])->whereMonth('tgl_absensi', $tmp[1])->where('user_id', $request->id)->get();
        }else{
            $data['bulans'] = null;
        }
        return view('rekapan.guru')->with($data);
    }
    public function hariIni()
    {
        $user = User::where('role_id', 2)->get();
        $absens = array();
        foreach ($user as $key => $value) {
            $absen = Absensi::where('user_id', $value->id)->where('tgl_absensi', date('Y-m-d'))->first();
            if(!$absen){
                $value['status'] = 'Belum Absen';
                $value['jam'] = null;
                array_push($absens, $value);
            }else{
                if($absen->status_absensi == 1){
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
                array_push($absens, $value);
            }
        }
        return view('rekapan.hariIni', compact('absens'));
    }
    public function showGuru($id, Request $request)
    {
        if($request->filled('bulan')){
            $tmp = explode("-", $request->bulan);
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['bulans'] = Absensi::whereYear('tgl_absensi', $tmp[0])->whereMonth('tgl_absensi', $tmp[1])->where('user_id', $id)->get();
        }else{
            $data['bulans'] = null;
        }
        $data['user'] = User::where('id', $id)->first();
        return view('rekapan.show')->with($data);
    }
    public function tanggal(Request $request)
    {
        if($request->filled('tanggal')){
            $tmp = explode("-", $request->tanggal);
            $data['tglIni'] = $tmp[2];
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['absens'] = Absensi::with('user')->where('tgl_absensi', $request->tanggal)->get();
        }else{
            $data['absens'] = null;
        }
        return view('rekapan.tanggal')->with($data);
    }
}
