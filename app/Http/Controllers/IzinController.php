<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Absensi;
use App\Models\Izin;

class IzinController extends Controller
{
    public function index()
    {
        $data['izins'] = Izin::where('user_id', Auth::user()->id)->get();
        return view('izin.index')->with($data);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'tanggal_pengajuan' => 'required',
            'dokumen' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tipe' => 'required',
            'keterangan' => 'required'
        ]);
        $dokumen = $request->file('dokumen');
        $absen = Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', $request->tanggal_pengajuan)->count();
        $izin = Izin::where('user_id', Auth::user()->id)->where('tanggal_untuk_pengajuan', $request->tanggal_pengajuan)->count();
        if ($request->tanggal_pengajuan >= date("Y-m-d")) {
            if($absen > 0 || $izin > 0){
                $message = $izin == 1 ? $message = "Melakukan Pengajuan Izin" : "Melakukan Absen"; 
                $notification = [
                    'message' => 'Pengajuan Gagal. Anda Sudah ' .$message.' Pada '.$request->tanggal_pengajuan,
                    'alert-type' => 'error',
                ];
                return redirect()
                    ->route('dashboard.presensi.izin')
                    ->with($notification);
            }else{
                if ($request->hasFile('dokumen')) {
                    $extension = $dokumen->extension();
                    $filename = 'dokumen_' . 'pengajuan_'.$request->tipe.'_' .Auth::user()->id.'_'. Carbon::now() . '.' . $extension;
                    $dokumen->storeAs('public/pengajuan/'.$request->tipe.'/'.$request->tanggal_pengajuan, $filename);
                    $dokumen = $filename;
                }
                $data = [
                    'tanggal_untuk_pengajuan' => $request->tanggal_pengajuan,
                    'user_id' => Auth::user()->id,
                    'dokumen' => $dokumen,
                    'tipe' => $request->tipe,
                    'keterangan' => $request->keterangan
                ];
                Izin::create($data);
                $notification = [
                    'message' => 'Pengajuan Berhasil',
                    'alert-type' => 'success',
                ];
                return redirect()
                    ->route('dashboard.presensi.izin')
                    ->with($notification);
            }
        } else {
            $notification = [
                'message' => 'Pengajuan Tidak Bisa Untuk Tanggal Yang Sudah Lewat Dari Tanggal Hari Ini',
                'alert-type' => 'error',
            ];
            return redirect()
                ->route('dashboard.presensi.izin')
                ->with($notification);
        }
        
        
    }
    public function show($id)
    {
        return Izin::find($id)->toJson();
    }
}
