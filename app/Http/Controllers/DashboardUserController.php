<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id !== 2){
            return redirect()->route('dashboard.admin');
        }
        return view('dashboardUser.index');
    }
}
