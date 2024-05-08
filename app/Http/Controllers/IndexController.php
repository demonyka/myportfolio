<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function view()
    {
        return inertia('Index');
    }
}
