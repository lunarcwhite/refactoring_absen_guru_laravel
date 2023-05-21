<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SettingAbsen;
use App\Models\Absensi;
use DB;

class KonfigurasiController extends Controller
{
    public function jamHari()
    {
        $data['users'] = User::where('role_id', 2)->get();
        return view('konfigurasi.daftarUser')->with($data);
    }

    public function jamHariSetting(Request $request, $id)
    {
        $data['user'] = User::where('id', $id)->first();
        $data['settings'] = SettingAbsen::where('user_id', $id)->orderBy('id')->get();
        return view('konfigurasi.settingJam&Hari')->with($data);
    }
    public function jamHariSettingUpdate(Request $request, $id)
    {
        $input = $request->all();
        // dd($input);
        foreach($input['id'] as $index => $value){
            $jam = $input['jam'][$index];
            $validated = $request->validate([
                $jam => 'date_format:format,H:i:s'
            ]);
            SettingAbsen::where('id', $value)->update([
                'jam' => $jam,
                'status' => $input['status'][$index]
            ]);
        }
        $notification = [
            'alert-type' => 'success',
            'message' => 'Berhasil Disimpan'
        ];
        return redirect()->back()->with($notification);
    }
    public function hariLibur()
    {
        $data['liburs'] = DB::table('hari_libur')->get();
        return view('konfigurasi.hariLibur')->with($data);
    }
    public function hariLiburStore(Request $request)
    {
        try {
            $users = User::where('role_id', 2)->get();
            foreach ($users as $key => $user) {
                $data['status_absensi'] = 5;
                $data['user_id'] = $user->id;
                $data['tgl_absensi'] = $request->tanggal;
                $data['created_at'] = $request->tanggal . '06:00:00';
                Absensi::create($data);
            }
            $libur['tanggal'] = $request->tanggal;
            $libur['keterangan'] = $request->keterangan;
            $libur['created_at'] = now();
            DB::table('hari_libur')->insert($libur);
    
            $notification = [
                'alert-type' => 'success',
                'message' => 'Berhasil Disimpan'
            ];
            return redirect()->back()->with($notification);
        } catch (\Throwable $th) {
            return redirect()->back()->with($th);
        }
        
    }
    public function hariLiburDelete($id)
    {
        $libur = DB::table('hari_libur')->where('id',$id)->first();
        try {
            Absensi::where('tgl_absensi',$libur->tanggal)->delete();
    
            $libur = DB::table('hari_libur')->where('id',$id)->delete();
            $notification = [
                'alert-type' => 'success',
                'message' => 'Berhasil Dihapus'
            ];
            return redirect()->back()->with($notification);
        } catch (\Throwable $th) {
            
            return redirect()->back();
        }

    }
    public function lokasi()
    {
        $lokasi = DB::table('setting_lokasi')->first();
        return view('konfigurasi.settingLokasi', compact('lokasi'));
    }
    public function lokasiUpdate(Request $request)
    {
        $validated = $request->validate([
            'radius' => 'integer'
        ]);
        
        DB::table('setting_lokasi')->update([
            'lokasi' => $request->lokasi,
            'radius' => $request->radius,
            'status' => $request->status
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Berhasil Disimpan'
        ];
        return redirect()->back()->with($notification);
    }
}
