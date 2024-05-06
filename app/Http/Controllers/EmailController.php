<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\NewPostRequest;
use App\Mail\MailEmailConfirmation;
use App\Models\User;
use App\Models\UserPost;
use App\Services\EmailService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    public function sendConfirmation($email): RedirectResponse
    {
        $this->emailService->sendConfirmation($email);
        return back()->with('message', ['type' => 'success', 'text' => 'profile.email_confirm_send']);
    }

    public function getConfirmation($token): RedirectResponse
    {
        $user = $this->emailService->getConfirmation($token);
        return $user->profileRedirect()->with('message', ['type' => 'success', 'text' => 'profile.email_confirm_success']);
    }
}
