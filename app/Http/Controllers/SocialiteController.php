<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function githubLogin(){
        return Socialite::driver("github")->redirect();
    }

    public function githubRedirect(){
        $githubUser = Socialite::driver("github")->user();
        $user = User::updateOrCreate([
            "github_id"=> $githubUser->id,
        ],[
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);
        Auth::login($user);

        return redirect('/dashboard');
    }
}
