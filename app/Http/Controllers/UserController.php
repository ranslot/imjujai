<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsData;
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

        $posts = Post::where('user_id', $id)->orderBy('create_at', 'desc')->get();
        return Inertia::render('User', [
            'user' => $user,
            'postByUser' => new AllPostsData($posts),
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
        ]);

        $user = User::find($id);
        if ($user === null || $id !== \auth()->user()->id) {
            return \redirect(\route('home.index'));
        }

        $user->file = (new FileServices)->updateFile(\auth()->user(), $request, 'user');
        $user->save();

        return \redirect(\route('users.show', ['id' => \auth()->user()->id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
