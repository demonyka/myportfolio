<?php

namespace App\Services;

use App\Mail\ForgotPasswordMail;
use App\Mail\MailEmailConfirmation;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailService
{
    public function sendConfirmation($email): void
    {
        $user = User::where('email', $email)->firstOrFail();
        if($user->email_verified_at) {
            abort(403);
        }
        $token = Str::random(64);
        Cache::put("email_confirmation_{$token}", $email, Carbon::now()->addMinutes(30));
        Mail::to($email)->send(new MailEmailConfirmation(route('auth.email-confirmation.get', ['token' => $token]), json_decode($user->external_data, true)['fullname']));
    }

    public function getConfirmation($token): User
    {
        $email = Cache::get("email_confirmation_{$token}");
        if(!$email) {
            abort(404);
        }
        $user = User::where('email', $email)->firstOrFail();
        $user->email_verified_at = Carbon::now();
        $user->save();
        Cache::forget("email_confirmation_{$token}");
        return $user;
    }
}
