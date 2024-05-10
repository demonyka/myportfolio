<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ProfileService
{
    public function getUser($identifier)
    {
        $user = User::whereNotNull('email_verified_at');
        if (Route::currentRouteNamed('profile.view.id')) {
            $user = $user->where('id', $identifier)->firstOrFail();
        } else {
            $user = $user->where('username', $identifier)->firstOrFail();
        }
        return $user;
    }

    public function find($value = '', int $limit = 5)
    {
        return User::where('external_data->fullname', 'like', "%{$value}%")
            ->whereNotNull('email_verified_at')
            ->withCount(['posts as likes' => function ($query) {
                $query->select(DB::raw('count(*)'))
                    ->join('post_likes', 'user_posts.id', '=', 'post_likes.post_id');
            }])
            ->orderByDesc('likes')
            ->limit($limit)
            ->get();
    }
}
