<?php

namespace App\Services;

use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;

class LikeService
{
    public function getPostLikes($user, $posts)
    {
        $postLikes = PostLike::where('user_id', $user->id)
            ->whereIn('post_id', $posts->pluck('id'))
            ->get()
            ->keyBy('post_id');

        foreach ($posts as $post) {
            $post['is_liked'] = $postLikes->has($post->id);
        }

        return $posts;
    }

    public function getLikeCounts($posts)
    {
        foreach ($posts as $post) {
            $post['like_count'] = PostLike::where('post_id', $post->id)->count();
        }

        return $posts;
    }

    public function like(UserPost $post, User $user)
    {
        return $post->like($user);
    }
}
