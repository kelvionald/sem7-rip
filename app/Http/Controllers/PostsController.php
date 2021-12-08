<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Services\PostsService;
use App\Services\S3Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use function Psy\debug;

class PostsController extends Controller
{
    private function attachImages($post, $images)
    {
        foreach ($images as $image) {
            Image::query()
                ->where('yc_key', $image['yc_key'])
                ->whereNull('post_id')
                ->update([
                    'post_id' => $post->post_id,
                ]);
        }
    }

    public function create(Request $request)
    {
        $user = User::getCurrent();
        $post = Post::query()
            ->create([
                'user_id' => $user->user_id,
                'content' => trim($request->get('content')),
                'commenting_id' => $request->get('commenting_id', null),
            ]);
        $images = $request->input('images', []);
        $this->attachImages($post, $images);
        return $post;
    }

    public function get(Request $request, PostsService $postsService)
    {
        $user_ids = $request->get('user_ids', '');
        if (empty($user_ids)) {
            $user_ids = [User::getCurrent()->user_id];
        } else {
            $user_ids = explode(',', $user_ids);
        }
        $order = request()->input('order', 'true');
        if ($order == 'true') {
            $order = 'DESC';
        } else {
            $order = 'asc';
        }
        $posts = $postsService->offsetBuilder(Post::query()
            ->whereIn('user_id', $user_ids)
            ->where('commenting_id', null)
            ->orderBy('post_id', $order)
        )->get();

        return $postsService->getPostsData($posts);
    }

    public function getPost(Request $request, PostsService $postsService)
    {
        $post_id = $request->get('post_id', 0);
        $post = Post::query()->find($post_id);
        if ($post) {
            $posts = collect([$post]);
            $data = $postsService->getPostsData($posts);

            $comments = Post::query()
                ->where('commenting_id', $post_id)
                ->get();
            $data['comments'] = $postsService->getPostsData($comments);
            return $data;
        }
    }

    public function search(Request $request, PostsService $postsService)
    {
        $q = $request->get('q');
        $q = mb_ereg_replace('%', '', $q);
        $posts = Post::query()
            ->whereRaw('content LIKE \'%' . $q . '%\'')
            ->get();
        $data = $postsService->getPostsData($posts);
        return $data;
    }

    public function getNew(Request $request, PostsService $postsService)
    {
        $posts = Post::query()
            ->limit(5)
            ->orderBy('post_id', 'DESC')
            ->get();
        $data = $postsService->getPostsData($posts);
        return $data;
    }

    public function repost(Request $request, PostsService $postsService)
    {
        $post_id = $request->get('post_id', 0);
        $post = Post::query()->find($post_id);
        if ($post && mb_strlen($post->content)) {
            $user = User::getCurrent();
            Post::query()
                ->create([
                    'repost_id' => $post_id,
                    'user_id' => $user->user_id,
                    'content' => $request->get('content', ''),
                ]);

            $images = $request->input('images', []);
            $this->attachImages($post, $images);

            $data = $postsService->getPostsData(collect([$post]));
            return $data;
        }
    }

    public function feed(Request $request, PostsService $postsService)
    {
        $user_id = User::getCurrent()->user_id;
        $posts = DB::table('post')
            ->selectRaw('post.*')
            ->rightJoin('follower', 'readable_id', '=', 'post.user_id')
            ->where('follower.reader_id', $user_id)
            ->get();
        $posts = $posts->map(function ($row) {
            $postModel = new Post;
            return $postModel->forceFill((array)$row);
        });
        return $postsService->getPostsData($posts);
    }

    public function count(Request $request)
    {
        $user_id = $request->get('user_id', '');
        if (empty($user_id)) {
            $user_id = User::getCurrent()->user_id;
        }
        $postsCount = Post::query()
            ->selectRaw('COUNT(post_id) AS "count"')
            ->where('user_id', $user_id)
            ->first()['count'];
        return compact('postsCount');
    }

    public function uploadImage(Request $request, S3Service $s3Service)
    {
        $uuid = Uuid::uuid4();
        $filepath = $request->file('photo')->getRealPath();
        $result = $s3Service->uploadImage($uuid, $filepath);
        if ($result) {
            $image = Image::query()->create([
                'yc_key' => $uuid,
            ]);
            return compact('image');
        }
    }
}
