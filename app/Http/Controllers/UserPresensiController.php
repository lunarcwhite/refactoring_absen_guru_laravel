<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Absensi;
class UserPresensiController extends Controller
{
    public function index()
    {
        return view('presensi.index');
    }

    public function absen(Request $request)
    {
        $validate = $request->validate([
            'swafoto' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $swafoto = $request->file('swafoto');
        $lokasi = $request->lokasi;
        $user = Auth::user()->user_id;
        if ($request->hasFile('swafoto')) {
            $extension = $swafoto->extension();
            $filename = 'swafoto_'.'masuk_'.Carbon::now().'.'.$extension;
            $swafoto->storeAs(
                'public/swafoto_absensi_masuk/'.date("Y-m-d"),$filename
            );
        }
        $notification = [
            'message' => 'Absen Berhasil',
            'alert-type' => 'success',
        ];
        return redirect()->route('dashboard.user')->with($notification);
    }
}
