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
            chmod(storage_path('app/public/posts/'.$post->id), 0775);
            chmod(storage_path('app/' . $path), 0775);
            $filesUrl[] = Storage::url($path);
        }
        return $filesUrl;
    }
    public function formatPost($post, $user): void
    {
        if ($user) {
            $post['is_liked'] = $post->likes()->where('user_id', $user->id)->exists();
        }
        $post['like_count'] = $post->likes()->count();
    }
}
