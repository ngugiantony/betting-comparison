<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Enums\CentyOtpVerified;
use App\Models\User;

class OTPVerificationController extends Controller
{
    public function enterOTP()
    {
        return view('auth.otp');
    }

    public function validateOTP(Request $request)
    {
        $request->validate([
            'centy_plus_otp' => 'required', 'digits:4', 'confirmed',
        ]);
        
        $user = User::find($request->session()->get('otp_user_id'));
        if (!$user) return redirect()->route('login')->with('status', 'Login again to get new OTP!.');
        session(['otp_user_id' => '']);

        if ($user->isOTPValid($request->centy_plus_otp)){
            Auth::guard('web')->login($user);
            
            $user->centy_plus_otp = null;
            $user->centy_plus_otp_verified = CentyOtpVerified::INACTIVE;
            $user->centy_plus_otp_verified_at = Carbon::now();
            $user->save();

            return redirect()->intended('/home')->with('status', 'Login Successful!!');
        } else {
            $user->centy_plus_otp = null;
            $user->centy_plus_otp_verified = CentyOtpVerified::INACTIVE;
            $user->save();
            
            return redirect()->route('otp.enter')->with('error', 'The OTP Entered Is Invalid!.');
        }
    }

}
