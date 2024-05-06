<?php

namespace App\Services;

use App\Mail\ForgotPasswordMail;
use App\Mail\MailEmailConfirmation;
use App\Mail\NewPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordService
{
    public function sendForgotPassword(User $user): void
    {
        $token = Str::random(64);
        Cache::put("reset_password_{$token}", $user->email, Carbon::now()->addMinutes(30));
        Mail::to($user->email)->send(new ForgotPasswordMail(route('auth.forgot-password.store', ['token' => $token]), json_decode($user->external_data, true)['fullname']));
    }

    public function sendNewPassword($token)
    {
        $email = Cache::get("reset_password_{$token}");
        if (!$email) {
            abort(404);
        }
        $password = Str::random();
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();
        Mail::to($user->email)->send(new NewPasswordMail($password, json_decode($user->external_data, true)['fullname']));
        Cache::forget("reset_password_{$token}");
    }
}
