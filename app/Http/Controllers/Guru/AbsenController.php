<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\SettingAbsen;
use Storage;
use DB;

class AbsenController extends Controller
{
    public function notification($alert,$message)
    {
        $notification = [
            'alert' => $alert,
            'message' => $message
        ];
        return redirect()->back()->with($notification);
    }
    public function index()
    {
        // dd(date('l')) = "Sunday";
        $id = Auth::user()->id;
        $data['absen'] = Absensi::where('user_id', $id)->where('tanggal_absensi', date('Y-m-d'))->first();
        $data['pulang'] = Absensi::where('user_id', $id)->where('tanggal_absensi', date('Y-m-d'))
            ->pluck('photo_absen_pulang')
            ->first();
        $data['hari'] = SettingAbsen::where('hari', date('l'))->where('user_id', $id)->first();
        $data['izinHariIni'] = Izin::where('user_id', $id)->whereDate('tanggal_untuk_pengajuan', date('Y-m-d'))->first();
        $data['lokasi'] = DB::table('setting_lokasi')->first();
        return view('guru.absen.index')->with($data);
    }

    public function store(Request $request)
    {
        $lokasi = DB::table('setting_lokasi')->first();
        $koordinat = explode(',', $lokasi->lokasi);
        $latitude = $koordinat[0];
        $longitude = $koordinat[1];
        $radiusLokasi = $lokasi->radius; 
        $validate = $request->validate([
            'swafoto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $foto = $request->file('swafoto');
        $lokasiAbsen = $request->lokasi;
        $lokasiUser = explode(",", $lokasiAbsen);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak = $this->distance($latitude, $longitude, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);
        $tanggal = date('Y-m-d');
        $id = Auth::user()->id;
        $absen = Absensi::where('user_id', $id)->where('tanggal_absensi', $tanggal)->first();
        if ($lokasi->status == 1 && $radius > $radiusLokasi) {
            return redirect()
                ->back()
                ->withErrors('Anda Berada Diluar Radius Absen. Jarak Anda '. $radius . ' Meter Dari Sekolah');
        } else {
            try {
                if ($request->hasFile('swafoto')) {
                    $extension = $foto->extension();
                    if($absen != null && $absen->photo_absen_masuk != null){
                        $filename = 'swafoto_' . 'pulang_' . $id . '_' . Carbon::now() . '.' . $extension;
                        $foto->storeAs('public/swafoto_absensi_pulang/' . date('Y-m-d'), $filename);
                    }else{
                        $filename = 'swafoto_' . 'masuk_' . $id . '_' . Carbon::now() . '.' . $extension;
                        $foto->storeAs('public/swafoto_absensi_masuk/' . date('Y-m-d'), $filename);
                    }
                    $fotoDb = $filename;
                }
                $status = 1;
                $izin = Izin::where('user_id', $id)->whereDate('tanggal_untuk_pengajuan', $tanggal)->first();
                $created_at = Carbon::now();
                $data = [
                    'photo_absen_masuk' => $fotoDb,
                    'user_id' => $id,
                    'tanggal_absensi' => $tanggal,
                    'status_absensi' => $status,
                    'created_at' => $created_at,
                    'lokasi_absen_masuk' => $lokasiAbsen
                ];
    
                if($absen != null && $absen->status_absensi == 7 ){
                    Storage::delete('public/pengajuan/'.$izin->tipe.'/'.$izin->tanggal_untuk_pengajuan,$izin->dokumen);
                    $izin->delete();
                    $absen->update($data);
                }else{
                    if ($izin != null && $izin->where('status_approval', 2 || $izin->where('status_approval', 2))) {
                        $izin->delete();
                    }
                    if ($absen && $absen->photo_absen_masuk != null) {
                        $absen->update([
                            'photo_absen_pulang' => $fotoDb,
                            'lokasi_absen_pulang' => $lokasiAbsen,
                            'updated_at' => Carbon::now()
                        ]);
                    } else {
                          Absensi::insert($data);
                    } 
                }
            } catch (\Throwable $th) {
                Absensi::latest()->delete();
                return redirect()->back()->withErrors($th->getMessage());
            }
            return redirect()
                ->back()
                ->with('success','Absen Berhasil');
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
