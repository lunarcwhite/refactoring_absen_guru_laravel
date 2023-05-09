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
        $data['absen'] = Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->count();
        $data['izinHariIni'] = Izin::where('user_id', Auth::user()->id)->where('tanggal_untuk_pengajuan', date('Y-m-d'))->count();
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
        if ($request->hasFile('dokumen')) {
            $extension = $dokumen->extension();
            $filename = 'dokumen_' . 'pengajuan_'.$request->tipe.'_' .Auth::user()->id.'_'. Carbon::now() . '.' . $extension;
            $dokumen->storeAs('public/pengajuan/'.$request->tipe.'/'.date('Y-m-d'), $filename);
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
    public function show($id)
    {
        return Izin::find($id)->toJson();
    }
}
