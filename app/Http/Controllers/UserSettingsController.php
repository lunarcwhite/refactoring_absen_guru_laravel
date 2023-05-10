<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;
use Storage;
use Arr;

class UserSettingsController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    public function update(Request $request)
    {
        $validate = $request->validate([
            'no_hp' => 'numeric|max_digits:13',
            'email' => 'email',
            'nama' => 'string',
            'photo' => 'image|mimes:jpeg,png,jpg',
        ]);
        $id = Auth::user()->id;
        $input = $request->all();
        $data = Arr::except($input, ['_token','_method']);
        if ($request->hasFile('photo')) {
            $extension = $data['photo']->extension();
            $filename = 'photo_' . 'profile_' . $id .'.' . $extension;
            $data['photo']->storeAs('public/photo_profile/', $filename);
            $data['photo'] = $filename;
            if(Auth::user()->photo !== null){
                Storage::delete('photo_profile/',Auth::user()->photo);
            }
        }else{
            if(Auth::user()->photo){
                $data['photo'] = Auth::user()->photo;
            }else{
                $data['photo'] = null;
            }
        }
        User::where('id', $id)->update($data);
        $notificatin = [
            'alert-type' => 'success',
            'message' => 'Profile Berhasil Diperbarui'
        ];
        return redirect()->route('dashboard.profile')->with($notificatin);
    }
    public function changePassword(Request $request)
    {
        $validate = $request->validate([
            'kata_sandi_lama' => 'required',
            'kata_sandi_baru' => 'required|min_digits:5'
        ]);
        $sandi = Auth::user()->password;
        $id = $request->id;
        $oldPassword = 'gbghfd65#2w45' . $request->kata_sandi_lama . 'sdghgh^$^';
        if(Hash::check($oldPassword, $sandi)){
            $newPassword = bcrypt('gbghfd65#2w45' . $request->kata_sandi_baru . 'sdghgh^$^');
            User::where('id', $id)->update(['password' => $newPassword]);
            $notification = [
                'alert-type' => 'success',
                'message' => 'Kata Sandi Berhasil Diubah'
            ];
            return redirect()->route('dashboard.profile')->with($notification);
        }else{
            $notificatin = [
                'message' => 'Kata Sandi Lama Tidak Sesuai'
            ];
            return redirect()->route('dashboard.profile')->with($notificatin);
        }
    }
}
