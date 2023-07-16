<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use Mail;
use App\Mail\MailTemplate;

class ResetPasswordController extends Controller
{
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
            $user = DB::table('users')->where('email', $updatePassword->email);
            $user->update(['password' => bcrypt($request->password)]);

            $emails = [
                'subject' => 'Change Password Confirmation',
                'title' => 'Change Password',
                'user' => $user->pluck('username')->first(),
                'body' => 'Your password has been changes on : ' . Carbon::now(),
                'url' => null,
            ];
            Mail::to($updatePassword->email)->send(new MailTemplate($emails));
            DB::table('password_resets')
                ->where([
                    'token' => $request->token,
                ])
                ->delete();
            $notification = [
                'message' => 'Your password has been changed!',
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
