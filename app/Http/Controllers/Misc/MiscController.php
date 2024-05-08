<?php

namespace App\Http\Controllers\Misc;

use App\Http\Controllers\Controller;

class MiscController extends Controller
{
    public function view($page)
    {
        if (!config('misc.'.$page)) {
            abort(404);
        }
        $head = config('misc.'.$page.'.head');
        $title = config('misc.'.$page.'.title');
        $content = config('misc.'.$page.'.content');
        return inertia('Misc', ['head' => $head, 'title' => $title, 'content' => $content]);
    }
}
