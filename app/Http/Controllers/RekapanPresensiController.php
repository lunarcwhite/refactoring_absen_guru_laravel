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
        
        $data['users'] = User::where('role_id', 2)->get();
        if($request->filled('bulan')){
            $tmp = explode("-", $request->bulan);
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['bulans'] = Absensi::whereYear('created_at', $tmp[0])->whereMonth('created_at', $tmp[1])->where('user_id', Auth::user()->id)->get();
        }else{
            $data['bulans'] = null;
        }
        if(Auth::user()->role_id == 1){
            return view('rekapan.indexAdmin')->with($data);
        }else{
            return view('rekapan.index')->with($data);
        }
    }

    public function show($id, Request $request)
    {
        if($request->filled('bulan')){
            $tmp = explode("-", $request->bulan);
            $namaBulan = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $data['bulanIni'] = $namaBulan[$tmp[1] * 1];
            $data['tahunIni'] = $tmp[0];
            $data['bulans'] = Absensi::whereYear('created_at', $tmp[0])->whereMonth('created_at', $tmp[1])->where('user_id', $id)->get();
        }else{
            $data['bulans'] = null;
        }
        $data['user'] = User::where('id', $id)->first();
        return view('rekapan.show')->with($data);
    }
}
