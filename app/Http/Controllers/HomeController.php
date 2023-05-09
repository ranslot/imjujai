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
        $post = Post::orderBy('create_at', 'desc')->get();
        return Inertia::render('Index', [
            'post' => new AllPostsData($post),
            'allUser' => User::all(),
        ]);
    }
}
