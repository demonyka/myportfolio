<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Models\User;
use App\Models\UserSection;
use App\Services\PostService;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileService $profileService;
    protected PostService $postService;

    public function __construct(ProfileService $profileService, PostService $postService)
    {
        $this->profileService = $profileService;
        $this->postService = $postService;
    }

    public function view($identifier, Request $request)
    {
        $user = $this->profileService->getUser($identifier);
        $sections = $user->sections;

        /** @var UserSection $section */
        if ($request->section) {
            $section = UserSection::where('name', $request->section)->first();
        } else {
            $section = UserSection::where('user_id', $user->id)->first();
        }
        $posts = null;
        if ($section) {
            $page = $request->page;
            $posts = $section->posts()->orderBy('created_at', 'desc')->paginate($page);
            foreach ($posts as $post) {
                $post->author = $post->user;
                $this->postService->formatPost($post, auth()->user());
            }
        }

        return inertia('Profile/Profile', ['user' => $user, 'sections' => $sections, 'section' => $section, 'posts' => $posts]);
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

    public function editSection(Request $request): RedirectResponse
    {
        $sections = $request->all();

        /** @var User $user */
        $user = auth()->user();

        $this->profileService->updateSections($user, $sections);

        return $user->profileRedirect();
    }

    public function find(Request $request): JsonResponse
    {
        $value = $request->query('value');
        $users = $this->profileService->find($value);
        return response()->json($users);
    }
}
