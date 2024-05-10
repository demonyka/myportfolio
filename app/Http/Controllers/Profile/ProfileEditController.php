<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileEditController extends Controller
{
    public function store(EditProfileRequest $request)
    {
        /* @var User $user */
        $user = auth()->user();
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar');
            $user->setAvatar($data['avatar']);
        }
        $user->setExternalData('fullname', $data['fullname']);
        $user->setExternalData('birthday', $data['birthday']);
        $user->setExternalData('phone', $data['phone']);
        $user->setExternalData('citizen', $data['citizen']);
        $user->setExternalData('city', $data['city']);
        $user->setExternalData('jobs', $data['jobs']);
        $user->setExternalData('education', $data['education']);
        $user->setExternalData('about', $data['about']);
        return $user->profileRedirect();
    }
}
