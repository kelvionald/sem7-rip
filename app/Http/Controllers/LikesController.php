<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Services\PostsService;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Request $request, PostsService $postsService)
    {
        $post_id = $request->get('post_id', 0);
        $post = Post::query()->find($post_id);
        if ($post) {
            $user_id = User::getCurrent()->user_id;
            $like = Like::query()
                ->where('post_id', $post_id)
                ->where('user_id', $user_id)
                ->first();
            if ($like) {
                $like->delete();
            } else {
                Like::query()
                    ->create(compact('post_id', 'user_id'));
            }
            return $postsService->getPostsData(collect([Post::query()->find($post_id)]));
        }
        return '';
    }
}
