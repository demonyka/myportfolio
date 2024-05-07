<?php

namespace App\Services;

use App\Models\PostLike;
use App\Models\User;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class LikeService
{
    public function getUserLikes($user, $post)
    {
        return PostLike::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->exists();
    }

    public function getPostLikes($post, $date = null)
    {
        $cacheKey = 'post_likes_' . $post->id;

        return Cache::remember($cacheKey, 5, function () use ($post, $date) {
            if ($date == null) {
                $date = Carbon::now();
            }
            return PostLike::where('post_id', $post->id)->where('created_at', '>=', $date)->count();
        });
    }

    public function like(UserPost $post, User $user): array
    {
        Cache::forget('post_likes_' . $post->id);
        $like = PostLike::where('user_id', $user->id)->where('post_id', $post->id)->first();
        if ($like) {
            $like->delete();
            return ['is_liked' => false, 'like_count' => PostLike::where('post_id', $post->id)->count()];
        } else {
            PostLike::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            return ['is_liked' => true, 'like_count' => PostLike::where('post_id', $post->id)->count()];
        }
    }

    public function getMostLikedAuthors()
    {
        $cacheKey = 'post.get.mostLikedAuthors';
        Cache::forget($cacheKey);
        return Cache::remember($cacheKey, 1440, function () {
            $posts = UserPost::all();
            foreach ($posts as $post) {
                $post['like_count'] = $this->getPostLikes($post, Carbon::now()->subDays(7));
            }

            return $posts->groupBy('user_id')
                ->map(function ($posts) {
                    return [
                        'user_id' => $posts->first()->user_id,
                        'like_count' => $posts->sum('like_count'),
                    ];
                })
                ->sortByDesc('like_count')
                ->take(5)
                ->map(function ($item) {
                    $user = User::find($item['user_id']);
                    $user['like_count'] = $item['like_count'];
                    return $user;
                });
        });
    }
}
