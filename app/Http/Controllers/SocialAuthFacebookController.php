<?php

namespace App\Http\Controllers;
use Socialite;
use App\Services\SocialFacebookAccountService;

use Illuminate\Http\Request;

class SocialAuthFacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        auth()->login($user);
        return redirect()->to('/');
    }

}
