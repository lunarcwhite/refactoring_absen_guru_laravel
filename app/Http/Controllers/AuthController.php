<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use DB;
use Auth;
use Str;
use Mail;
use Carbon\Carbon;
use App\Mail\ChangePassword;

class AuthController extends Controller
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
                if (Auth::attempt(['username' => $request->username, 'password' => $request->password]) || Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                    // Authentication passed...
                    $request->session()->regenerate();
                    $notification = [
                        'message' => 'Login Berhasil',
                        'alert-type' => 'success',
                    ];
                    return redirect()
                        ->intended('dashboard')
                        ->with($notification);
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
            $input = $request->all();
            $input['role_id'] = 2;
            $input['password'] = bcrypt($request->password);
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

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordProses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->passes()) {
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
            $details = [
                'subject' => 'Reset Password Confirmation',
                'title' => 'Reset Password',
                'body' => 'You can reset password from link below :',
                'url' => route('resetPassword', $token)
            ];
            Mail::to($request->email)->send(new ChangePassword($details));

            // Mail::send('auth.resetPasswordConfirmation', ['token' => $token], function ($message) use ($request) {
            //     $message->to($request->email);
            //     $message->subject('Reset Password');
            // });

            $notification = [
                'message' => 'We have e-mailed your password reset link!',
                'alert-type' => 'success',
            ];

            return redirect()
                ->route('login')
                ->with($notification);
        } else {
            $notification = [
                'message' => 'Email tidak terdaftar',
                'alert-type' => 'error',
            ];
            return redirect()
                ->back()
                ->with($notification);
        }
    }

    public function resetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPasswordProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
        ]);
        if ($validator->passes()) {
            $updatePassword = DB::table('password_resets')
                ->where([
                    'token' => $request->token,
                ])
                ->first();

            if (!$updatePassword) {
                $notification = [
                    'message' => 'Invalid',
                    'alert-type' => 'error',
                ];
                return back()
                    ->withInput()
                    ->with($notification);
            }

            User::where('email', $updatePassword->email)->update(['password' => bcrypt($request->password)]);

            $details = [
                'subject' => 'Change Password Confirmation',
                'title' => 'Change Password',
                'body' => 'Your password has been changes on : ' . Carbon::now(),
                'url' => null
            ];
            Mail::to($updatePassword->email)->send(new ChangePassword($details));
            DB::table('password_resets')
                ->where(['token' => $request->token])
                ->delete();
                $notification = [
                    'message' => 'Your password has been changed!',
                    'alert-type' => 'success',
                ];
            return redirect()->route('login')->with($notification);

        } else {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
