<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Absensi;
class PresensiController extends Controller
{
    public function index()
    {
        $data['absen'] = Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))->pluck('absen_masuk')->count();
        $data['pulang'] = Absensi::where('user_id', Auth::user()->id)->whereDate('created_at', date('Y-m-d'))
            ->pluck('absen_pulang')
            ->first();
        return view('presensi.index')->with($data);
    }

    public function absenMasuk(Request $request)
    {
        $validate = $request->validate([
            'swafoto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $data['absen_masuk'] = $request->file('swafoto');
        $data['lokasi_absen_masuk'] = $request->lokasi;
        $latitudeTempat = -6.91818;
        $longitudeTempat = 107.61953;
        $lokasiUser = explode(",", $data['lokasi_absen_masuk']);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak = $this->distance($latitudeTempat, $longitudeTempat, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);
        $data['tgl_absensi'] = date('Y-m-d');
        $data['user_id'] = Auth::user()->id;
        if ($radius > 100) {
            $notification = [
                'message' => 'Anda Berada Diluar Radius Absen, Jarak Anda '. $radius . ' Meter Dari Sekolah',
            ];
            return redirect()
                ->back()
                ->with($notification);
        } else {
            if ($request->hasFile('swafoto')) {
                $extension = $data['absen_masuk']->extension();
                $filename = 'swafoto_' . 'masuk_' . $data['user_id'] . '_' . Carbon::now() . '.' . $extension;
                $data['absen_masuk']->storeAs('public/swafoto_absensi_masuk/' . date('Y-m-d'), $filename);
                $data['absen_masuk'] = $filename;
            }
            Absensi::create($data);
            $notification = [
                'message' => 'Absen Masuk Berhasil',
                'alert-type' => 'success',
            ];
            return redirect()
                ->route('dashboard.user')
                ->with($notification);
        }
    }

    public function absenPulang(Request $request)
    {
        $validate = $request->validate([
            'swafoto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $absen = $request->file('swafoto');
        $lokasi = $request->lokasi;
        $user = Auth::user()->id;
        $latitudeTempat = -6.91818;
        $longitudeTempat = 107.61953;
        $lokasiUser = explode(",", $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak = $this->distance($latitudeTempat, $longitudeTempat, $latitudeUser, $longitudeUser);
        $radius = round($jarak['meters']);
        if ($radius > 100) {
            $notification = [
                'message' => 'Anda Berada Diluar Radius Absen, Jarak Anda '. $radius . ' Meter Dari Sekolah',
            ];
            return redirect()
                ->back()
                ->with($notification);
        } else {
            if ($request->hasFile('swafoto')) {
                $extension = $absen->extension();
                $filename = 'swafoto_' . 'pulang_' . $user . '_' . Carbon::now() . '.' . $extension;
                $absen->storeAs('public/swafoto_absensi_pulang/' . date('Y-m-d'), $filename);
    
                Absensi::where('user_id', $user)->update([
                    'absen_pulang' => $filename,
                    'lokasi_absen_pulang' => $lokasi,
                    'updated_at' => Carbon::now(),
                ]);
            }
            $notification = [
                'message' => 'Absen Pulang Berhasil',
                'alert-type' => 'success',
            ];
            return redirect()
                ->route('dashboard.user')
                ->with($notification);
        }
        
    }
    function distance($lat1, $lon1, $lat2, $lon2)
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
