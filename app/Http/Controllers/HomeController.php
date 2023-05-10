<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsData;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return Inertia::render('Index', [
            'posts' => new AllPostsData($posts),
            'allUser' => User::all(),
        ]);
    }
}
