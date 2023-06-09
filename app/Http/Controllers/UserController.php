<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsData;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Services\FileServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user === null) {
            return \redirect(\route('home.index'));
        }

        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $userLikes = Like::where('user_id', \auth()->user()->id)->get();
        $postsLikes = Post::whereIn('id', $userLikes->pluck('post_id'))
            ->orderBy('created_at', 'desc')
            ->get();
        $userAuthFollow = Follow::where('user_id', \auth()->user()->id)->get();
        $userFollowing = Follow::where('user_id', $user->id)->get();
        $userFollowers = Follow::where('followed_user_id', $user->id)->get();
        $userFollowingList = User::whereIn('id', $userFollowing->pluck('followed_user_id'))
            ->orderBy('created_at', 'desc')
            ->get();
        $userFollowersList = User::whereIn('id', $userFollowers->pluck('user_id'))
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('User', [
            'user' => $user,
            'postByUser' => new AllPostsData($posts),
            'userLikes' => $userLikes,
            'postsLikes' => new AllPostsData($postsLikes),
            'userAuthFollow' => $userAuthFollow,
            'userFollow' => ['userFollowing' => $userFollowing, 'userFollowers' => $userFollowers],
            'userFollowList' => ['userFollowingList' => $userFollowingList, 'userFollowersList' => $userFollowersList],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!is_string($request->input('file'))){
            $request->validate([
            'file' => 'mimes:png,jpg,jpeg',
            'description'
            ]);
        }
        
        $user = User::find($id);
        
        if ($user === null || $id !== (string)\auth()->user()->id) {
            return \redirect(\route('home.index'));
        }
        if(!is_string($request->input('file'))){
            $user->file = (new FileServices)->updateFile(\auth()->user(), $request, 'user');
        }else{
            $user->file = $request->input('file');
        }
        
        $user->description = $request->input('description'); 
        $user->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
