<?php

namespace App\Http\Controllers;

use App\Models\UserPost;

class PostController extends Controller
{
    public function like($post_id): void
    {
        /* @var UserPost $post */
        $post = UserPost::findOrFail($post_id);
        $post->like();
    }

    public function delete($post_id)
    {
        /* @var UserPost $post */
        UserPost::where('id', $post_id)->where('user_id', auth()->user()->id)->delete();
    }
}
