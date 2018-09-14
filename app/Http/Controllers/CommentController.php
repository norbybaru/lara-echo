<?php namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return response()->json($post->comments()->with('user')->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Post $post
     * @return string
     */
    public function store(Request $request, Post $post)
    {
        $comment = $post->comments()->create([
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ]);

        $comment = Comment::where('id', $comment->id)->with('user')->first();

        return $comment->toJson();
    }
}
