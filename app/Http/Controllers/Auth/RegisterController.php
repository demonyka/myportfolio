<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function view(): Response
    {
        return inertia('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'external_data' => json_encode(['fullname' => $request->fullname])
        ]);

        event(new Registered($user));

        $email = new EmailController();
        $email->sendConfirmation($user->email);

        Auth::login($user, true);

        return $user->profileRedirect();
    }
}
