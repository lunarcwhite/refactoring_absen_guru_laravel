<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use App\Models\SettingAbsen;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $id = $user->id;
        $role_id = $user->role_id;
        $data['hariIni'] = date('Y-m-d');
        $data['bulanIni'] = date('m');
        $data['tahunIni'] = date('Y');
        $data['namaBulan'] = ["", "Januari", 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        if($role_id == 2){
        $data['jam'] = SettingAbsen::where('hari', date('l'))->where('user_id', $id)->first();
        $data['absenHariIni'] = Absensi::where('tanggal_absensi', $data['hariIni'])->where('user_id', $id)->first();
        $data['historiBulanIni'] = Absensi::where('user_id', $id)->whereMonth('tanggal_absensi', $data['bulanIni'])->whereYear('tanggal_absensi', $data['tahunIni'])->get();
        $data['izinBulanIni'] = Izin::where('user_id', $id)->where('status_approval', 1)->whereMonth('tanggal_untuk_pengajuan', $data['bulanIni'])->whereYear('tanggal_untuk_pengajuan', $data['tahunIni'])->get();
            return view('guru.dashboard.index')->with($data);
        }elseif($role_id == 1 || $role_id == 3){
            $data['absenHariIni'] = $data['absenHariIni'] = Absensi::where('tanggal_absensi', $data['hariIni']);
            $user = User::where('role_id', 2)->get();
            $data['izins'] = Izin::where('status_approval', 2);
            $data['belumAbsen'] = 0;
            foreach($user as $item){
                if(!Absensi::where('tanggal_absensi', $data['hariIni'])->where('user_id', $item->id)->count() > 0){
                    $data['belumAbsen'] += 1;
                }

            }
            return view('admin.dashboard.index')->with($data);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = [
            'message' => 'Logout Berhasil',
            'alert-type' => 'success',
        ];
        return redirect()
            ->route('login')
            ->with($notification);
    }
}
