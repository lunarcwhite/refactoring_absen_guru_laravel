<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id !== 1){
            return redirect()->route('dashboard.user');
        }
        return view('dashboardAdmin.index');
    }
}
