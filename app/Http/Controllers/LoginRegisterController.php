<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use DB;

class LoginRegisterController extends Controller
{
    //
    public function welcomePage(){
        return view('welcome');
    }

    public function SendOTP(Request $request){

        $email=$request->input('email');
        $otp=$request->input('otp');
        $update = \DB::table('users')->where('email','=',$email)->update(['password' => $otp]);
        
        if($update){
            return "true";
        }
        // $data = array('email'=>$email , 'otp'=>$otp);
        // Mail::send('mail',$data, function($message) use ($email) {
        //             $message->to($email , 'OTP')->subject
        //             ('OTP for login');
        //             $message->from('monikarana6935@gmail.com','techtonic');

        // });
    }

    public function CheckOTP(Request $request){
        $email=$request->input('email');
        $otp=$request->input('otp'); 
        $checkOTP=User::select('password')->where('email','=',$email)->first();
        // print_r($checkOTP->password);
        if($otp==$checkOTP->password){
            session_start();
            $_SESSION['email']=$email;
            return "true";
        }else{
            return "false";
        }
    }
}
