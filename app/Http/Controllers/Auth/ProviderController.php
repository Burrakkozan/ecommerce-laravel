<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        try {
            $SocialUser = Socialite::driver($provider)->user();
            $user = User::where([
                'provider' => $provider,
                'provider_id' => $SocialUser->id
            ])->first();
            if(!$user){
                if(User::where('email',$SocialUser->getEmail())->exists()){
                    return redirect('/login')->withErrors(['email' => 'This Email uses different method to login']);
                }
                $password = Str::random(12);
                $user = User::create([
                    'name' => $SocialUser->getName(),
                    'email' => $SocialUser->getEmail(),
                    'username' => User::generateUserName($SocialUser->getNickname()),
                    'provider' => $provider,
                    'provider_id' => $SocialUser->getId(),
                    'provider_token' => $SocialUser->token,
//                   'photo' => $SocialUser->getAvatar(),
                    'is_active' => true,
                     'password' => bcrypt($password),
//                   'email_verified_at' => now(),
                ]);
                $user->sendEmailVerificationNotification();
                $user->update([
                   'password' => Hash::make($password),
                ]);
            }

            Auth::login($user);
            return redirect('/dashboard');

        } catch (\Exception $e){
            return redirect('/login')->with('error','Something went wrong');
        }

    }
}
