<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\EditProfileRequest;
use App\Http\Requests\Profile\NewPostRequest;
use App\Mail\MailEmailConfirmation;
use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
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

        $post = $this->postService->create([
            'user_id' => $user->id,
            'section_id' => $request->section_id,
            'content' => $request->post
        ]);

        if ($request->hasFile('files')) {
            $this->postService->attachFiles($post, $request->file('files'));
        }

        Cache::forget('post.get.' . $request->section_id);

        return $post;
    }

    public function getPost($section_id)
    {
        $posts = $this->postService->getPosts($section_id);

        $posts = $this->likeService->getLikeCounts($posts);

        /** @var User $user */
        $user = auth()->user();
        foreach ($posts as $post) {
            $post->author = $post->user;
        }
        if ($user) {
            $posts = $this->likeService->getPostLikes($user, $posts);
        }

        return $posts;
    }

    public function like($post_id)
    {
        /** @var User $user */
        $user = auth()->user();
        $post = UserPost::findOrFail($post_id);

        return $this->likeService->like($post, $user);
    }
}
