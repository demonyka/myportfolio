<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPost;
use Illuminate\Support\Facades\Cache;

class PostService
{
    public UserPost $post;
    protected LikeService $likeService;
    public function __construct(UserPost $post, LikeService $likeService)
    {
        $this->post = $post;
        $this->likeService = $likeService;
    }

    public function create(array $data)
    {
        Cache::forget('post.get.' . $data['section_id']);
        return UserPost::create($data);
    }

    public function attachFiles(UserPost $post, $files)
    {
        $post->attachFiles($files);
    }

    public function getPosts($section_id)
    {
        $cacheKey = 'post.get.' . $section_id;

        $posts = Cache::remember($cacheKey, 1440, function () use ($section_id) {
            $posts = UserPost::where('section_id', $section_id)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(15);

            foreach ($posts as $post) {
                $post->author = $post->user;
            }
            return $posts;
        });
        /** @var User $user */
        $user = auth()->user();
        foreach ($posts as $post) {
            if ($user) {
                $post['is_liked'] = $this->likeService->getUserLikes($user, $post);
            }
            $post['like_count'] = $this->likeService->getPostLikes($post);
        }

        return $posts;
    }
}
