<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\NewPostRequest;
use App\Mail\MailEmailConfirmation;
use App\Models\User;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    public function sendConfirmation($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        if($user->email_verified_at) {
            abort(403);
        }
        $token = Str::random(64);
        Cache::put("email_confirmation_{$token}", $email, now()->addMinutes(30));
        Mail::to($email)->send(new MailEmailConfirmation(route('api.user.email-confirmation.get', ['token' => $token]), json_decode($user->external_data, true)['fullname']));
        return back()->with('message', ['type' => 'success', 'text' => 'profile.email_confirm_send']);
    }

    public function getConfirmation($token)
    {
        $email = Cache::get("email_confirmation_{$token}");
        if(!$email) {
            abort(410);
        }
        $user = User::where('email', $email)->firstOrFail();
        $user->email_verified_at = Carbon::now();
        $user->save();
        Cache::forget("email_confirmation_{$token}");
        return $user->profileRedirect()->with('message', ['type' => 'success', 'text' => 'profile.email_confirm_success']);
    }
}
