<?php

namespace App\Services;

use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class LikeService
{
    public function like(UserPost $post, User $user)
    {
        Cache::forget('post_likes_' . $post->id);
        $like = PostLike::where('user_id', $user->id)->where('post_id', $post->id)->first();
        if ($like) {
            $like->delete();
        } else {
            PostLike::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        }
    }
}
