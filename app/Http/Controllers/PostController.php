<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\NewPostRequest;
use App\Models\User;
use App\Models\UserPost;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function like($post_id): void
    {
        /* @var User $user */
        $user = auth()->user();
        /* @var UserPost $post */
        $post = UserPost::findOrFail($post_id);
        $post->like($user);
    }

    public function delete($post_id): void
    {
        /* @var UserPost $post */
        UserPost::where('id', $post_id)->where('user_id', auth()->user()->id)->delete();
    }

    public function store(NewPostRequest $request): RedirectResponse
    {
        /* @var User $user */
        $user = auth()->user();
        $data = [
            'title' => $request->title,
            'text' => $request->text,
            'links' => $request->links
        ];
        /* @var UserPost $post */
        $post = UserPost::create([
            'user_id' => $user->id,
            'data' => json_encode($data),
        ]);

        if ($request->hasFile('files')) {
            $post->attachFiles($request->file('files'));
        }

        return $user->profileRedirect();
    }
}
