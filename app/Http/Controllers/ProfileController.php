<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the registration view.
     */
    public function view($identifier)
    {
        $user = User::where('id', $identifier)
            ->orWhere('username', $identifier)
            ->whereNotNull('email_verified_at')
            ->firstOrFail();

        if($user->username && is_numeric($identifier)) {
            return redirect()->route('profile.view', ['identifier' => $user->username]);
        }
        return inertia('Profile', ['user' => $user]);
    }
}
