<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;

class DashboardUserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id !== 2){
            return redirect()->route('dashboard.admin');
        }
        $id = Auth::user()->id;
        $data['hariIni'] = date('Y-m-d');
        $data['bulanIni'] = date('m');
        $data['tahunIni'] = date('Y');
        $data['namaBulan'] = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['absenHariIni'] = Absensi::whereDate('created_at', $data['hariIni'])->where('user_id', $id)->first();
        $data['historiBulanIni'] = Absensi::where('user_id', $id)->whereMonth('tgl_absensi', $data['bulanIni'])->whereYear('tgl_absensi', $data['tahunIni'])->get();
        $data['izinBulanIni'] = Izin::where('user_id', $id)->where('status_approval', 1)->whereMonth('tanggal_untuk_pengajuan', $data['bulanIni'])->whereYear('tanggal_untuk_pengajuan', $data['tahunIni'])->get();
        return view('dashboardUser.index')->with($data);
    }
}
