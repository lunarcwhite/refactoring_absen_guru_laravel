<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        // If the validation fails, redirect back to the login page
        if ($validator->passes()) {
            $user = User::where('username', $request->username)
                ->orWhere('email', $request->username)
                ->first();
            if ($user) {
                // Attempt to log the user in
                $password = 'gbghfd65#2w45' . $request->password . 'sdghgh^$^';
                if (Auth::attempt(['username' => $request->username, 'password' => $password]) || Auth::attempt(['email' => $request->username, 'password' => $password])) {
                    // Authentication passed...
                    $request->session()->regenerate();
                    $notification = [
                        'message' => 'Login Berhasil',
                        'alert-type' => 'success',
                    ];
                    if(Auth::user()->role_id == 2){
                        return redirect()
                            ->intended('dashboard/user')
                            ->with($notification);
                    }elseif(Auth::user()->role_id == 1){
                        return redirect()
                            ->intended('dashboard')
                            ->with($notification);
                    }
                } else {
                    // Authentication failed...
                    $notification = [
                        'message' => 'Password Salah',
                        'alert-type' => 'error',
                    ];
                    return redirect()
                        ->back()
                        ->with($notification);
                }
            } else {
                $notification = [
                    'message' => 'Username atau Email tidak terdaftar',
                    'alert-type' => 'error',
                ];
                return redirect()
                    ->back()
                    ->with($notification);
            }
        } else {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
