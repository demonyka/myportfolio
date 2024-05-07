<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPost;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function attachFiles($files, UserPost $post): array
    {
        $filesUrl = [];
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/posts/'.$post->id, $filename);
            chmod(Storage::url($path), 0775);
            $filesUrl[] = Storage::url($path);
        }
        return $filesUrl;
    }

    public function getPosts($section_id, $page = 1)
    {
        $cacheKey = 'post.get.' . $section_id;
        Cache::forget($cacheKey);
        $posts = Cache::remember($cacheKey, 1440, function () use ($section_id, $page) {
            $posts = UserPost::where('section_id', $section_id)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->paginate(10);

            foreach ($posts as $post) {
                $post->author = $post->user;
            }
            return $posts;
        });
        /** @var User $user */
        $user = auth()->user();
        /** @var UserPost $post */
        foreach ($posts as $post) {
            if ($user) {
                $post['is_liked'] = $post->isLiked($user);
            }
            $post['like_count'] = $post->likeCount();
        }

        return $posts;
    }
}
