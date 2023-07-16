<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.konfigurasi.daftarUser')->with($data);
    }

    public function jamHariSetting(Request $request, $id)
    {
        $data['user'] = User::where('id', $id)->first();
        $data['settings'] = SettingAbsen::where('user_id', $id)->orderBy('id')->get();
        return view('admin.konfigurasi.settingJam&Hari')->with($data);
    }
    public function jamHariSettingUpdate(Request $request, $id)
    {
        $input = $request->all();
        // dd($input);
        try {
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
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }

        return redirect()->back()->with('success', 'Jam dan Hari Absen Berhasil Diperbarui');
    }
    public function hariLibur()
    {
        $data['liburs'] = DB::table('hari_libur')->get();
        return view('admin.konfigurasi.hariLibur')->with($data);
    }
    public function hariLiburStore(Request $request)
    {
        try {
            $users = User::where('role_id', 2)->get();
            foreach ($users as $key => $user) {
                $data['status_absensi'] = 5;
                $data['user_id'] = $user->id;
                $data['tanggal_absensi'] = $request->tanggal;
                $data['created_at'] = $request->tanggal . '06:00:00';
                Absensi::create($data);
            }
            $libur['tanggal'] = $request->tanggal;
            $libur['keterangan'] = $request->keterangan;
            $libur['created_at'] = now();
            DB::table('hari_libur')->insert($libur);
    
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
        return redirect()->back()->with('success', 'Hari Libur Berhasil Disimpan');
        
    }
    public function hariLiburDelete($id)
    {
        $libur = DB::table('hari_libur')->where('id',$id)->first();
        try {
            Absensi::where('tanggal_absensi',$libur->tanggal)->update([
                'status_absensi' => 1
            ]);
    
            $libur = DB::table('hari_libur')->where('id',$id)->delete();

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
        return redirect()->back()->with('success', 'Hari Libur Berhasil Dihapus');
    }
    public function lokasi()
    {
        $lokasi = DB::table('setting_lokasi')->first();
        return view('admin.konfigurasi.settingLokasi', compact('lokasi'));
    }
    public function lokasiUpdate(Request $request)
    {
        $validated = $request->validate([
            'radius' => 'integer'
        ]);
        
        try {
            DB::table('setting_lokasi')->update([
                'lokasi' => $request->lokasi,
                'radius' => $request->radius,
                'status' => $request->status
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
        return redirect()->back()->with('success', 'Lokasi Absen Berhasil Diperbarui');
    }
}
