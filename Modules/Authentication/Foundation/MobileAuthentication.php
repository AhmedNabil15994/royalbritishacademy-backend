<?php

namespace Modules\Authentication\Foundation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Authentication\Entities\OtpRequest;
use Modules\User\Entities\User;

trait MobileAuthentication
{
    public static function sendOtp($mobile)
    { 
        optional(OtpRequest::where('mobile' , $mobile)->first())->delete();
        return OtpRequest::create(['mobile' => $mobile],['mobile' => $mobile]);
    }
    public static function otpCheck($mobile,$otp)
    { 
        $request =  OtpRequest::where(['mobile' => $mobile,'otp' => $otp])->first();
        return $request && !$request->is_expired;
    }

    public function loginOrRegister($mobile, $loginType = 'frontend')
    { 
        $user =  User::where('mobile',$mobile)->first();
        
        if($user){
            $route = 'frontend.home';
        }else{

            $user = User::create(['mobile' => $mobile]);
            $user->refresh();
            $route = 'frontend.profile.edit';
        }

        switch($loginType){
            case 'frontend':
                $this->frontLogin($user);
        }

        return $route;
    }

    public function frontLogin($user){

        Auth::login($user);
    }
}
