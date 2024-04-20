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

class GoogleAuthController extends Controller
{
    public function redirect(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $google_user = Socialite::driver('google')->user();
        $user = User::where('email', $google_user->getEmail())->first();
        if (!$user) {
            $password = Str::random(32);
            $user = User::create([
                'external_data' => json_encode(['fullname' => $google_user->getName(), 'avatar_path' => $google_user->getAvatar()]),
                'email' => $google_user->getEmail(),
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
