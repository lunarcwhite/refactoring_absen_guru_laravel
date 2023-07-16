<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Auth;

class HistoriAbsenGuruController extends Controller
{
    public function index(Request $request)
    {
        
        if($request->filled('bulan')){
            $tmp = explode("-", $request->bulan);
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['bulans'] = Absensi::whereYear('tanggal_absensi', $tmp[0])->whereMonth('tanggal_absensi', $tmp[1])->where('user_id', Auth::user()->id)->get();
        }else{
            $data['bulans'] = null;
        }

        return view('guru.histori_absen.index')->with($data);
    }
}
