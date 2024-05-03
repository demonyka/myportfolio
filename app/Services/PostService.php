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
        return UserPost::create($data);
    }

    public function attachFiles(UserPost $post, $files)
    {
        $post->attachFiles($files);
    }

    public function getPosts($section_id)
    {
        $cacheKey = 'post.get.' . $section_id;

        return Cache::remember($cacheKey, 1440, function () use ($section_id) {
            return UserPost::where('section_id', $section_id)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(15);
        });
    }
}
