<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id == 2){
            return redirect()->route('dashboard.user');
        }
    }
    public function indexUser()
    {
        return view('dashboardUser.index');
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
