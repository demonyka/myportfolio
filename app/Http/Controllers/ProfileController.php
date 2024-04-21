<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProfileController extends Controller
{
    /**
     * Display the profile view.
     */
    public function view($identifier)
    {
        $user = User::whereNotNull('email_verified_at');
        $routeName = Route::currentRouteName();

        if($routeName == 'profile.view.byId' && is_numeric($identifier)) {
            $user = $user->where('id', $identifier)->firstOrFail();
            if($user->username) {
                return redirect()->route('profile.view.byUsername', ['username' => $user->username]);
            }
        } elseif ($routeName == 'profile.view.byUsername') {
            $user = $user->where('username', $identifier)->firstOrFail();
        }
        return inertia('Profile', ['user' => $user]);
    }

    public function edit(EditProfileRequest $request)
    {
        $user = auth()->user();
        $user->setExternalData('fullname', $request->fullname);
        $user->setExternalData('username', $request->username);
        $user->setExternalData('birthday', $request->birthday);
        $user->setExternalData('geolocation', $request->geolocation);
        $user->setExternalData('job', $request->job);
        $user->setExternalData('links', $request->links);
        return redirect()->back()->with('message', ['type' => 'success', 'text' => 'Успех']);
    }
}
