<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\NewPostRequest;
use App\Models\User;
use App\Models\UserPost;
use App\Models\UserSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the profile view.
     */

    public function view($identifier)
    {
        $cacheKey = 'profile.view.' . $identifier;

        $user = Cache::remember($cacheKey, 60, function () use ($identifier) {
            $user = User::whereNotNull('email_verified_at');

            if (is_numeric($identifier)) {
                $user = $user->where('id', $identifier)->firstOrFail();
            } else {
                $user = $user->where('username', $identifier)->firstOrFail();
            }

            return $user;
        });

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

    public function newPost(NewPostRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var UserPost $post */
        $post = UserPost::create([
            'user_id' => $user->id,
            'section_id' => $request->section_id,
            'content' => $request->post
        ]);
        if ($request->hasFile('files')) {
            $post->attachFiles($request->file('files'));
        }
        Cache::forget('post.get.' . $request->section_id);
        return $post;
    }

    public function getPost($section_id)
    {
        $cacheKey = 'post.get.' . $section_id;

        $posts = Cache::remember($cacheKey, 1440, function () use ($section_id) {
            return UserPost::where('section_id', $section_id)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(15);
        });

        foreach ($posts as $post) {
            $post->author = $post->user;
        }

        return $posts;
    }

    public function editSection(Request $request)
    {
        $requestData = $request->all();

        /** @var User $user */
        $user = auth()->user();

        foreach ($requestData as $item) {
            if ($item['id'] !== null) {
                $section = UserSection::find($item['id']);
                if ($section) {
                    if ($item['name']) {
                        $section->updateName($item['name']);
                    } else {
                        $section->delete();
                    }
                }
            } else if ($item['name']) {
                $section = UserSection::create([
                    'user_id' => $user->id,
                    'name' => $item['name']
                ]);
            }
        }
        return $user->profileRedirect();
    }
}
