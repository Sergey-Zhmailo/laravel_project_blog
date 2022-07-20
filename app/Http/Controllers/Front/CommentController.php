<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment_process(CommentRequest $commentRequest)
    {
        $post = Post::query()->findOrFail($commentRequest->input('post_id'));

        $res = $post->comments()->create($commentRequest->input());

        if ($res) {
            return redirect()->route('post', $post->slug)->with(['success' => 'Success! Your comment was published']);
        } else {
            return redirect()->route('post', $post->slug)->withErrors(['msg' => 'Error']);
        }
    }
}
