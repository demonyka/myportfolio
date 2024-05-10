<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected ProfileService $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    public function store(Request $request): RedirectResponse
    {
        $sections = $request->all();

        /** @var User $user */
        $user = auth()->user();

        $this->profileService->updateSections($user, $sections);

        return $user->profileRedirect();
    }
}
