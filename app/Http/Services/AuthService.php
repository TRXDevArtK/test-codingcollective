<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{
    private $userRepository, $socialite;

    public function __construct(UserRepository $userRepository, Socialite $socialite)
    {
        $this->userRepository = $userRepository;
        $this->socialite = $socialite;
    }

    private function generateHashPassword($uniqueIdentity){
        $generate = Hash::make($uniqueIdentity, [
            'rounds' => 12,
        ]);

        return $generate;
    }

    public function redirOauth(){
        if (Auth::check()) {
            return ["you now login, here your data :", Auth::user()];
        }

        return Socialite::driver('google')->redirect();
    }

    public function login(){
        if (Auth::check()) {
            return ["you now login, here your data :", Auth::user()];
        }

        $user = Socialite::driver('google')->user();
        $init = $this->userRepository;

        $init = $init->updateOrCreate([
            'where' => ['email' => $user->email],
            'data' => [
                'email' => $user->getEmail(),
                'username' => trim($user->getName()),
                // email can't be same + some rando, can be better but this is enough for now
                'password' => $this->generateHashPassword($user->getEmail().strval(rand(100, 10000000))),
                'oauth_token' => $user->token,
                'oauth_id' => $user->getId(),
                'candidate_permission' => "[1,1,1,1]" //pls costumize later in DB
            ]
        ]);

        //this can be more advance rather than use Auth()
        //you can basically use google or other oauth logout 3rd api to remove token
        //but for now let's make it simple
        Auth::loginUsingId($init->id, $remember = true);

        return redirect("/");
    }

    public function logout(){
        Auth::logout();
        return "you now logout";
    }

    public function getLoginUserData(){
        $data = Auth::user();
        return $data;
    }
}
