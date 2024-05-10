<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function view($identifier)
    {
        /* @var User $user */
        $user = $this->profileService->getUser($identifier);
        $posts = $user->posts()
            ->with('user')
            ->withCount(['likes', 'likes as is_liked' => function ($query) {
                $query->where('user_id', optional(auth()->user())->id);
            }])
            ->paginate(15);
        return inertia('Profile/Profile', ['user' => $user, 'posts' => $posts]);
    }
    public function find(Request $request): JsonResponse
    {
        $value = $request->query('value');
        $users = $this->profileService->find($value);
        return response()->json($users);
    }
}
