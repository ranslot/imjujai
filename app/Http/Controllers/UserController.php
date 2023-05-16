<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsData;
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
    public function show(string $id)
    {
        $user = User::find($id);
        if ($user === null) {
            return \redirect(\route('home.index'));
        }

        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        $userLikes = Like::where('user_id', \auth()->user()->id)->get();
        return Inertia::render('User', [
            'user' => $user,
            'postByUser' => new AllPostsData($posts),
            'userLikes' => $userLikes,
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
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg',
            'description'
        ]);
        $user = User::find($id);

        if ($user === null || $id !== (string)\auth()->user()->id) {
            return \redirect(\route('home.index'));
        }

        $user->file = (new FileServices)->updateFile(\auth()->user(), $request, 'user');
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
