<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the registration view.
     */
    public function view($id): Response
    {
        $user = User::where('id', $id)->whereNotNull('email_verified_at')->firstOrFail();
        return inertia('Profile', ['user' => $user]);
    }
}
