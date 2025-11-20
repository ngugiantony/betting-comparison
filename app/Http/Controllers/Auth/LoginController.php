<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Enums\CentyOtpVerified;
use App\Jobs\SendUserOtp;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $login = request()->input('centy_plus_id'); // Get the input value from the login form

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'centy_plus_id'; // Determine if the input is an email or centy_plus_id

        request()->merge([$fieldType => $login]); // Merge the input value into the request

        return $fieldType; // Return the field type (email or centy_plus_id)
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        return $this->guard()->attempt(
            $credentials,
            $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only('centy_plus_id', 'remember'))
            ->withErrors($errors);
    }

    protected function authenticated(Request $request, $user)
    {
//        if ($user->first_login) {
//           return redirect()->route('password.reset');
//        }
//        if ($user->needsOTPVerification()){
//            session(['otp_user_id' => $user->id]);
//            app('redirect')->setIntendedUrl(route($user->role . '.dashboard'));
//
//            Auth::guard('web')->logout();
//
//            return redirect()->route('otp.enter');
//        }
if (isset($user->role)) {
            return redirect()->route($user->role . '.dashboard');
        } else {
            return redirect()->route('login')->with("message", "Your user type is not recognized");
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'digits:4', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->first_login = false;
        $user->save();

        return redirect()->route('login')->with('status', 'Password reset successfully! Please Login with new password.');
    }

}
