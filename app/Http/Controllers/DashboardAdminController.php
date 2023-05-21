<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id == 2){
            return redirect()->route('dashboard.user');
        }else{
            return view('dashboardAdmin.index');
        }
    }
}
