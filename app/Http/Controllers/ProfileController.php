<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

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
        $sections = $user->sections;
        return inertia('Profile/Profile', ['user' => $user, 'sections' => $sections]);
    }

    public function edit(EditProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->setExternalData('fullname', $request->fullname);
        $user->setExternalData('birthday', $request->birthday);
        $user->setExternalData('geolocation', $request->geolocation);
        $user->setExternalData('job', $request->job);
        $user->setExternalData('links', $request->links);
        if ($request->hasFile('avatar')) {
            $user->setAvatar($request->file('avatar'));
        }
        if ($request->username) {
            $user->username = $request->username;
            $user->save();
        }

        return $user->profileRedirect();
    }
}
