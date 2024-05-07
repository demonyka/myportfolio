<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\NewPostRequest;
use App\Mail\MailEmailConfirmation;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
use App\Models\UserSection;
use App\Services\LikeService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected PostService $postService;
    protected LikeService $likeService;

    public function __construct(PostService $postService, LikeService $likeService)
    {
        $this->postService = $postService;
        $this->likeService = $likeService;
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
        $section = UserSection::findOrFail($section_id);
        return $section->posts();
    }

    public function like($post_id)
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var UserPost $post */
        $post = UserPost::findOrFail($post_id);
        $post->like($user);
    }

    public function delete($post_id)
    {
        /** @var User $user */
        $user = auth()->user();
        /** @var UserPost $post */
        $post = UserPost::where('user_id', $user->id)->where('id', $post_id)->firstOrFail();
        $cacheKey = 'post.get.' . $post->section_id;
        Cache::forget($cacheKey);
        $post->deleteWithFiles();
        return back()->with('message', ['type' => 'success', 'text' => 'post.delete_success']);
    }
}
