<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Absensi;
use App\Models\Izin;

class PengajuanIzinController extends Controller
{
    public function index()
    {
        $data['izins'] = Izin::where('user_id', Auth::user()->id)->get();
        return view('guru.pengajuan_izin.index')->with($data);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'tanggal_pengajuan' => 'required',
            'dokumen' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tipe' => 'required',
            'keterangan' => 'required',
        ]);
        $id = Auth::user()->id;
        $dokumen = $request->file('dokumen');
        $absen = Absensi::where('user_id', $id)
            ->whereDate('created_at', $request->tanggal_pengajuan)
            ->count();
        $izin = Izin::where('user_id', $id)
            ->where('tanggal_untuk_pengajuan', $request->tanggal_pengajuan)
            ->count();
        try {
            if ($request->tanggal_pengajuan >= date('Y-m-d')) {
                if ($absen > 0 || $izin > 0) {
                    $message = $izin == 1 ? ($message = 'Melakukan Pengajuan Izin') : 'Melakukan Absen';
                    return redirect()
                        ->back()
                        ->withErrors('Pengajuan Gagal. Anda Sudah ' . $message . ' Pada ' . $request->tanggal_pengajuan);
                } else {
                    if ($request->hasFile('dokumen')) {
                        $extension = $dokumen->extension();
                        $filename = 'dokumen_' . 'pengajuan_' . $request->tipe . '_' . $id . '_' . Carbon::now() . '.' . $extension;
                        $dokumen->storeAs('public/pengajuan/' . $request->tipe . '/' . $request->tanggal_pengajuan, $filename);
                        $dokumen = $filename;
                    }
                    $data = [
                        'tanggal_untuk_pengajuan' => $request->tanggal_pengajuan,
                        'user_id' => $id,
                        'dokumen' => $dokumen,
                        'tipe' => $request->tipe,
                        'keterangan' => $request->keterangan,
                    ];
                    Izin::create($data);
                }
            } else {
                return redirect()
                    ->back()
                    ->withErrors('Pengajuan Tidak Bisa Untuk Tanggal Yang Sudah Lewat Dari Tanggal Hari Ini');
            }
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withErrors('Terjadi Suatu Kesalahan!');
        }
        return redirect()
            ->back()
            ->with('success', 'Pengajuan ' . $request->tipe . ' Berhasil');
    }
    public function show($id)
    {
        return Izin::with('user')
            ->findOrFail($id)
            ->toJson();
    }
}
