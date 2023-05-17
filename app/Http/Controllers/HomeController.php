<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsData;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->filter(request(['tag', 'search']))->get();
        $userLikes = Like::where('user_id', \auth()->user()->id)->get();
        $userAuthFollow = Follow::where('user_id', \auth()->user()->id)->get();
        return Inertia::render('Index', [
            'posts' => new AllPostsData($posts),
            'userLikes' => $userLikes,
            'userAuthFollow' => $userAuthFollow,
        ]);
    }
}
