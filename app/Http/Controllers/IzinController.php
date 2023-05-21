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
        return Izin::with('user')->findOrFail($id)->toJson();
    }
    public function pending()
    {
        $data['izins'] = Izin::where('status_approval', 2)->get();
        return view('izin.pending')->with($data);
    }
    public function konfirmasi(Request $request)
    {
        $izin = Izin::where('id', $request->id_pengajuan)->first();
        if($request->konfirmasi_pengajuan === "setuju"){
            Izin::where('id', $request->id_pengajuan)->update([
                'status_approval' => 1
            ]);
            $tipe = $izin->tipe;
    
            if($tipe === 'izin'){
                $data['status_absensi'] = 4;
            }elseif($tipe === 'sakit'){
                $data['status_absensi'] = 3;
            }elseif($tipe === 'cuti'){
                $data['status_absensi'] = 2;
            }

            $notification = [
                'alert-type' => 'success',
                'message' => 'Pengajuan Disetujui'
            ];
        }else if($request->konfirmasi_pengajuan === "tolak"){
            Izin::where('id', $request->id_pengajuan)->update([
                'status_approval' => 0
            ]);
            $data['status_absensi'] = 7;
            $notification = [
                'alert-type' => 'success',
                'message' => 'Pengajuan Ditolak'
            ];
        }else{
            $notification = [
                'alert-type' => 'error',
                'message' => 'Konfirmasi Pengajuan Izin Gagal'
            ];
        }
        $data['tgl_absensi'] = $izin->tanggal_untuk_pengajuan;
        $data['user_id'] = $izin->user_id;
        $absen = Absensi::where('tgl_absensi', $izin->tanggal_untuk_pengajuan)->where('user_id',$izin->user_id)->first();
        if(!$absen){
            $data['created_at'] = $data['tgl_absensi'].' 06:00:00';
            $data['updated_at'] = null;
            Absensi::create($data);
        }else{
            $absen->update([
                'status_absensi' => $data['status_absensi'],
            ]);
        }
        
        return redirect()->back()->with($notification);
    }
    public function ditolak()
    {
        $data['ditolaks'] = Izin::where('status_approval', 0)->get();
        return view('izin.ditolak')->with($data);
    }
    public function disetujui()
    {
        $data['disetujuis'] = Izin::where('status_approval', 1)->get();
        return view('izin.disetujui')->with($data);
    }
}
