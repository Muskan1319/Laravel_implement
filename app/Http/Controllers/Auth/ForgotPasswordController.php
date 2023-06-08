<?php

namespace App\Http\Controllers\Auth;

//use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // public function showForgetPasswordForm()
    // {
    //    return view('auth.passwords.email');
    // }


    // public function submitForgetPasswordForm(Request $request)
    //   {
    //       $request->validate([
    //           'email' => 'required|email|exists:users',
    //       ]);
  
    //       $token = Str::random(64);
  
    //       DB::table('password_reset_tokens')->insert([
    //           'email' => $request->email, 
    //           'token' => $token, 
    //           'created_at' => Carbon::now()
    //         ]);
  
    //       Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
    //           $message->to($request->email);
    //           $message->subject('Reset Password');
    //       });
  
    //       return back()->with('message', 'We have e-mailed your password reset link!');
    //   }
}
