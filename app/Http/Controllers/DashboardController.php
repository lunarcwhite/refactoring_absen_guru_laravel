<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // $notification = [
        //     'message' => 'Login Berhasil',
        //     'alert-type' => 'success',
        // ];
        if(Auth::user()->role_id == 2){
            return redirect()->route('dashboard.user');
        }else{
            return redirect()->route('dashboard.admin');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = [
            'message' => 'Logout Berhasil',
            'alert-type' => 'success',
        ];
        return redirect()
            ->route('login')
            ->with($notification);
    }
}
