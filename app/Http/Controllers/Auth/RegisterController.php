<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
        ]);
        if ($validator->passes()) {
            $password = 'gbghfd65#2w45' . $request->password . 'sdghgh^$^';
            $input = $request->all();
            $input['role_id'] = 2;
            $input['password'] = bcrypt($password);
            User::create($input);
            $notification = [
                'message' => 'Registrasi Berhasil',
                'alert-type' => 'success',
            ];
            return redirect()
                ->route('login')
                ->with($notification);
        } else {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
