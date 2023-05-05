<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Auth;

class RekapanPresensiController extends Controller
{
    public function index(Request $request)
    {
        
        if($request->filled('bulan')){
            $tmp = explode("-", $request->bulan);
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['bulans'] = Absensi::whereYear('created_at', $tmp[0])->whereMonth('created_at', $tmp[1])->where('user_id', Auth::user()->id)->get();
            return view('rekapan.index')->with($data);
        }else{
            $bulans = null;
            return view('rekapan.index', compact('bulans'));
        }
    }
}
