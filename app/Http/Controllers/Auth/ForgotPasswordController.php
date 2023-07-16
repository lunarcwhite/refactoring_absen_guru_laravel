<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Str;
use DB;
use Carbon\Carbon;
use Mail;
use App\Mail\MailTemplate;

class ForgotPasswordController extends Controller
{
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
            $emails = [
                'subject' => 'Reset Password Confirmation',
                'title' => 'Reset Password',
                'user' => DB::table('users')->where('email', $request->email)
                    ->pluck('username')
                    ->first(),
                'body' => 'You can reset password from link below :',
                'url' => route('resetPassword', $token),
            ];
            Mail::to($request->email)->send(new MailTemplate($emails));

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
}
