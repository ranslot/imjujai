<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllPostsData extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): object
    {

        return $this->map(function ($post) {
            return [
                'id' => $post->id,
                'text' => $post->text,
                'tags' => $post->tags,
                'eat_or_cook' => $post->eat_or_cook,
                'file' => $post->file,
                'created_at' => $post->created_at->format(' H:i d M y'),
                'comments' => $post->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'text' => $comment->text,
                        'created_at' => $comment->created_at->format(' H:i d M y'),
                        'user' => [
                            'id' => $comment->user->id,
                            'name' => $comment->user->name,
                            'file' => $comment->user->file
                        ],
                    ];
                }),
                'likes' => $post->likes->map(function ($like) {
                    return [
                        'id' => $like->id,
                        'user_id' => $like->user_id,
                        'post_id' => $like->post_id
                    ];
                }),
                'user' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'file' => $post->user->file
                ]
            ];
        });
    }
}
