<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\NewPostRequest;
use App\Models\User;
use App\Models\UserPost;
use App\Models\UserSection;
use App\Services\PostService;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected ProfileService $profileService;
    protected PostService $postService;

    public function __construct(ProfileService $profileService, PostService $postService)
    {
        $this->profileService = $profileService;
        $this->postService = $postService;
    }

    public function view($identifier)
    {
        $user = $this->profileService->getUser($identifier);

        $sections = $user->sections;

        return inertia('Profile/Profile', ['user' => $user, 'sections' => $sections, 'popularAuthors' => $this->getMostLikedAuthors()]);
    }

    public function edit(EditProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $data = $request->all();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar');
        }

        $this->profileService->updateProfile($user, $data);

        return $user->profileRedirect();
    }

    public function editSection(Request $request)
    {
        $requestData = $request->all();

        /** @var User $user */
        $user = auth()->user();

        $this->profileService->updateSections($user, $requestData);

        return $user->profileRedirect();
    }

    private function getMostLikedAuthors()
    {
        return $this->postService->getMostLikedAuthors();
    }
}
