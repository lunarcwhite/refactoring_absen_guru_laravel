<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
                if (Auth::attempt(['username' => $request->username, 'password' => $password]) || Auth::attempt(['email' => $request->username, 'password' => $password]) || Auth::attempt(['nuptk' => $request->username, 'password' => $password])) {
                    // Authentication passed...
                    $request->session()->regenerate();
                    return redirect()
                        ->intended('dashboard')
                        ->with('success','Login Berhasil');
                } else {
                    // Authentication failed...
                    return redirect()
                        ->back()
                        ->withErrors('Password Salah');
                }
            } else {
                return redirect()
                    ->back()
                    ->withErrors('Username atau Email tidak terdaftar');
            }
        } else {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
