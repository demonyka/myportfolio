<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Route;

class ProfileController extends Controller
{
    /**
     * Display the registration view.
     */
    public function view($identifier)
    {
        $user = User::whereNotNull('email_verified_at');
        $routeName = Route::currentRouteName();

        if($routeName == 'profile.view' && is_numeric($identifier)) {
            $user = $user->where('id', $identifier)->firstOrFail();
            if($user->username) {
                return redirect()->route('profile.view.byUsername', ['username' => $user->username]);
            }
        } elseif ($routeName == 'profile.view.byUsername') {
            $user = $user->where('username', $identifier)->firstOrFail();
        }

        return inertia('Profile', ['user' => $user]);
    }
}
