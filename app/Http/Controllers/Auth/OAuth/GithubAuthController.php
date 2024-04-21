<?php

namespace App\Http\Controllers\Auth\OAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    public function redirect(Request $request)
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request)
    {
        $github_user = Socialite::driver('github')->user();
        $user = User::where('email', $github_user->getEmail())->first();
        if (!$user) {
            $password = Str::random(32);
            $user = User::create([
                'external_data' => json_encode(['fullname' => $github_user->getName(), 'avatar_path' => $github_user->getAvatar(), 'github' => $github_user->getNickname()]),
                'email' => $github_user->getEmail(),
                'password' => Hash::make($password),
            ]);
            $user->email_verified_at = Carbon::now();
            $user->save();
        } else if (!$user->email_verified_at) {
            $user->email_verified_at = Carbon::now();
            $user->save();
        }
        Auth::login($user, true);
        return redirect()->route('profile.view');
    }
}
