<?php

namespace App\Http\Controllers;

use App\Events\Follow as EventsFollow;
use App\Listeners\FollowNotification;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
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
        $request->validate(['followed_user_id' => 'required']);

        $follow = new Follow;
        $follow->user_id = \auth()->user()->id;
        $follow->followed_user_id = $request->input('followed_user_id');
        $follow->save();

        \event(new EventsFollow($follow));
    }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $followed_user_id)
    {
        $user_id = \auth()->user()->id;
        $follow = Follow::where('user_id', $user_id)->where('followed_user_id', $followed_user_id)->first();
        $follow->delete();
    }
}
