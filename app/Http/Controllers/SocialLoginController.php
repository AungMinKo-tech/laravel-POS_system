<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //redirect to social login provider
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    //callback from social login provider
    public function callback($provider){
        $SocialLoginData = Socialite::driver($provider)->user();

        // dd($data);

        $user = User::updateOrCreate([
            'provider_id' => $SocialLoginData->id,
        ],[
            'name'=> $SocialLoginData->name,
            'email'=> $SocialLoginData->email,
            'nickname'=> $SocialLoginData->nickname,
            // 'profile'=> $SocialLoginData->avatar,
            'provider'=> $provider,
            'provider_id'=> $SocialLoginData->id,
            'provider_token'=> $SocialLoginData->token,
        ]);

    Auth::login($user);

    return to_route('user#Home');
    }
}
