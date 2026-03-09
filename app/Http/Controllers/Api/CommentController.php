<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;



class CommentController extends Controller
{
    public function index(Post $post)
    {
        return $post->comments()
            ->with('user')
            ->latest()
            ->get();
    }

    public function store(Request $request, Post $post)
    {
        $user = $request->user();
        $validated = $request->validate([
            'content' => 'required|string|max:120'
        ]);

        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'content' => $validated['content'],
        ]);

        return response()->json(
            $comment->load('user'),
            201
        );
    }
}
