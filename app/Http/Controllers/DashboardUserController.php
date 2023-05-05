<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Absensi;

class DashboardUserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id !== 2){
            return redirect()->route('dashboard.admin');
        }
        $data['hariIni'] = date('Y-m-d');
        $data['bulanIni'] = date('m');
        $data['tahunIni'] = date('Y');
        $data['namaBulan'] = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['absenHariIni'] = Absensi::whereDate('created_at', $data['hariIni'])->where('user_id', Auth::user()->id)->first();
        $data['historiBulanIni'] = Absensi::where('user_id', Auth::user()->id)->whereMonth('created_at', $data['bulanIni'])->whereYear('created_at', $data['tahunIni'])->latest()->get();
        $data['absenBulanIni'] = Absensi::where('user_id', Auth::user()->id)->whereMonth('created_at', $data['bulanIni'])->whereYear('created_at', $data['tahunIni'])->get();
        return view('dashboardUser.index')->with($data);
    }
}
