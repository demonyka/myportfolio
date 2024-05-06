<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Mail\MailEmailConfirmation;
use App\Models\User;
use App\Services\EmailService;
use App\Services\PasswordService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Response;

class PasswordController extends Controller
{
    protected PasswordService $passwordService;
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }
    /**
     * Display the forgot password view.
     */
    public function view(): Response
    {
        return inertia('Auth/ForgotPassword');
    }

    public function send(ForgotPasswordRequest $request): RedirectResponse
    {
        $email = $request->email;
        $user = User::where('email', $email)->whereNotNull('email_verified_at')->first();
        if (!$user) {
            return back()->with('message', ['type' => 'error', 'text' => 'validation.user.not_found']);
        }
        $this->passwordService->sendForgotPassword($user);
        return back()->with('message', ['type' => 'success', 'text' => 'email.password.recover_send']);
    }

    public function store($token)
    {
        $this->passwordService->sendNewPassword($token);
        return redirect()->route('auth.login.view')->with('message', ['type' => 'success', 'text' => 'email.password.new_send']);
    }
}
