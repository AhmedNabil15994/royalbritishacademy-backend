<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;
use Modules\Authentication\Foundation\{Authentication,MobileAuthentication};
use Modules\Authentication\Http\Requests\Frontend\{LoginRequest,verificationOtpRequest};
use Modules\Authentication\Notifications\Frontend\WelcomeNotification;

class LoginController extends Controller
{
    use Authentication,MobileAuthentication;

    /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {
        return view('authentication::frontend.login');
    }

    public function showVerificationOtp($mobile)
    {
        return view('authentication::frontend.verify-otp',compact('mobile'));
    }

    /**
     * Login method
     */
    public function postLogin(LoginRequest $request)
    {
        $this->sendOtp($request->mobile);

        return redirect()->route('frontend.auth.verification-otp',$request->mobile);
    }

    /**
     * Login method
     */
    public function verificationOtp(verificationOtpRequest $request)
    {
        $isVerified = $this->otpCheck($request->mobile,$request->otp);

        if(!$isVerified){

            $errors = new MessageBag([
                'otp' => [__("Invalid OTP")],
            ]);

            return redirect()->back()->with(["errors" => $errors]);
        }
        
        $redirectRoute = $this->loginOrRegister($request->mobile);
        
        return redirect()->route($redirectRoute);
    }


    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('frontend.home');
    }
}
