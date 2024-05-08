<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ProfileService
{
    public function getUser($identifier)
    {
        $cacheKey = 'profile.view.' . $identifier;

        return Cache::remember($cacheKey, 60, function () use ($identifier) {
            $user = User::whereNotNull('email_verified_at');

            if (Route::currentRouteNamed('profile.view.id')) {
                $user = $user->where('id', $identifier)->firstOrFail();
            } else {
                $user = $user->where('username', $identifier)->firstOrFail();
            }

            return $user;
        });
    }

    public function updateProfile(User $user, array $data): void
    {
        $user->setExternalData('fullname', $data['fullname']);
        $user->setExternalData('birthday', $data['birthday']);
        $user->setExternalData('geolocation', $data['geolocation']);
        $user->setExternalData('job', $data['job']);
        $user->setExternalData('links', $data['links']);

        if (isset($data['username'])) {
            $user->username = $data['username'];
        }

        if (isset($data['avatar'])) {
            $user->setAvatar($data['avatar']);
        }

        $user->save();
    }

    public function updateSections(User $user, array $sections): void
    {
        foreach ($sections as $sectionData) {
            if (isset($sectionData['id'])) {
                $section = UserSection::find($sectionData['id']);
                if ($section) {
                    if (isset($sectionData['name'])) {
                        $section->updateName($sectionData['name']);
                    } else {
                        $section->delete();
                    }
                }
            } else if (isset($sectionData['name'])) {
                UserSection::create([
                    'user_id' => $user->id,
                    'name' => $sectionData['name']
                ]);
            }
        }
    }
    public function find($value = '', int $limit = 5)
    {
        $cacheKey = 'user.find.' . $value . $limit;
        return Cache::remember($cacheKey, 60, function () use ($value, $limit) {
            return User::where('external_data->fullname', 'like', "%{$value}%")
                ->whereNotNull('email_verified_at')
                ->withCount(['posts as likes' => function ($query) {
                    $query->select(DB::raw('count(*)'))
                        ->join('post_likes', 'user_posts.id', '=', 'post_likes.post_id');
                }])
                ->orderByDesc('likes')
                ->limit($limit)
                ->get();
        });

    }
}
