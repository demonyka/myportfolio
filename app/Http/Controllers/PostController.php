<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\NewPostRequest;
use App\Mail\MailEmailConfirmation;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PostController extends Controller
{
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

        $user = auth()->user();

        $posts = Cache::remember($cacheKey, 1440, function () use ($section_id) {
            return UserPost::where('section_id', $section_id)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(15);
        });

        foreach ($posts as $post) {
            $post->author = $post->user;
            $post['like_count'] = PostLike::where('post_id', $post->id)->count();
        }

        if ($user) {
            $postLikes = PostLike::where('user_id', $user->id)
                ->whereIn('post_id', $posts->pluck('id'))
                ->get()
                ->keyBy('post_id');

            foreach ($posts as $post) {
                $post['is_liked'] = $postLikes->has($post->id);
            }
        }


        return $posts;
    }

    public function like($post_id)
    {
        $user = auth()->user();
        return UserPost::findOrFail($post_id)->like($user);
    }
}
