<?php


namespace App\Services;


use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PostsService
{
    public $nextOffset = 0;

    public function getPostsData(Collection $posts)
    {
        $user_ids = $posts->pluck('user_id');
        $statistics = $this->getStatistics($posts);
        $posts = $this->fillLiked($posts);
        $posts = $this->fillReposts($posts, $user_ids);
        $users = $this->getUsers($user_ids->unique());
        $nextOffset = $this->nextOffset;
        return compact('posts', 'users', 'statistics', 'nextOffset');
    }

    private function getStatistics(Collection $posts)
    {
        $postIds = $posts->pluck('post_id');
        $repostIds = $posts->pluck('repost_id');
        $comments = DB::table('post')
            ->selectRaw('commenting_id, COUNT(commenting_id) as "count"')
            ->whereIn('commenting_id', $postIds)
            ->groupBy('commenting_id')
            ->get()
            ->keyBy('commenting_id');
        $reposts = DB::table('post')
            ->selectRaw('repost_id, COUNT(post_id) as "count"')
            ->whereIn('repost_id', $repostIds)
            ->groupBy('repost_id')
            ->get()
            ->keyBy('repost_id');
        $likes = DB::table('like')
            ->selectRaw('post_id, COUNT(user_id) as "count"')
            ->whereIn('post_id', $postIds)
            ->groupBy('post_id')
            ->get()
            ->keyBy('post_id');
        return compact('comments', 'reposts', 'likes');
    }

    private function getUsers($user_ids)
    {
        return User::query()
            ->whereIn('user_id', $user_ids)
            ->get()
            ->keyBy('user_id');
    }

    private function fillLiked(Collection $posts)
    {
        $postIds = $posts->pluck('post_id');
        $likes = Like::query()
            ->where('user_id', User::getCurrent()->user_id)
            ->get()
            ->keyBy('post_id');
        $posts = $posts->map(function (Post $post) use ($likes) {
            $post->liked = isset($likes[$post->post_id]);
            return $post;
        });
        return $posts;
    }

    private function fillReposts(Collection $posts, Collection &$user_ids)
    {
        $repostPosts1 = $posts->filter(function (Post $post) {
            return $post->repost_id;
        });
        $repostPosts = Post::query()
            ->whereIn('post_id', $repostPosts1->pluck('repost_id')->unique())
            ->get()
            ->keyBy('post_id');
        $user_ids = $user_ids->merge($repostPosts->pluck('user_id'));
        $repostPosts1->map(function (Post $post) use ($repostPosts) {
            $post->repost = $repostPosts[$post->repost_id];
            return $post;
        });
        return $posts;
    }

    public function offsetBuilder(Builder $builder)
    {
        $count = 10;
        $offset = request()->input('offset', 0);
        $this->nextOffset = $offset + $count;
        $builder = $builder
            ->limit($count)
            ->offset($offset);
        return $builder;
    }
}
