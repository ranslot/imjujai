<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\FileServices;
use Illuminate\Http\Request;

class PostController extends Controller
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
        $post = new Post;
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg',
            'text' => 'required',
        ]);

        $fileService = new FileServices;

        $post->user_id = \auth()->user()->id;
        $post->file = $fileService->updateFile($post, $request, 'post');
        $post->text = $request->input('text');
        $post->eat_or_cook = $request->input('eatOrCook');
        $post->tags = $request->input('tags');

        $post->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        // Check if the model has a non-empty file property
        if (!empty($post->file)) {
            // Get the current file path
            $currentFile = \public_path() . $post->file;

            // Check if the current file exists and is not the default user placeholder image
            if (\file_exists($currentFile)) {
                // Delete the current file
                \unlink($currentFile);
            }
        }

        $post->delete();
    }
}
