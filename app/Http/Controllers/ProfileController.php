<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the profile view.
     */
    public function view($identifier)
    {
        $user = User::whereNotNull('email_verified_at');

        if (is_numeric($identifier)) {
            $user = $user->where('id', $identifier)->firstOrFail();
        } else {
            $user = $user->where('username', $identifier)->firstOrFail();
        }
        return inertia('Profile', ['user' => $user]);
    }

    public function edit(EditProfileRequest $request)
    {
        $user = auth()->user();
        $user->setExternalData('fullname', $request->fullname);
        $user->setExternalData('birthday', $request->birthday);
        $user->setExternalData('geolocation', $request->geolocation);
        $user->setExternalData('job', $request->job);
        $user->setExternalData('links', $request->links);

        if ($request->username) {
            $user->username = $request->username;
            $user->save();
        }

        return $user->username ? redirect()->route('profile.view.username', ['username' => $user->username]) : redirect()->route('profile.view.id', ['id' => $user->id]);
    }
}
