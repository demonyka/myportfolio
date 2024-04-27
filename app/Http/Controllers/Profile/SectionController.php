<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Models\User;
use App\Models\UserPost;
use Illuminate\Http\RedirectResponse;

class SectionController extends Controller
{
    public function posts($section_id)
    {
        $posts = UserPost::where('section_id', $section_id)->paginate(5);
        return $posts;
    }
}
