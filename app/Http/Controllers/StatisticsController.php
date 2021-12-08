<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use App\Services\UploadService;
use App\Services\UsersService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function common(Request $request)
    {
        $currDay = Carbon::now();
        $dayBeforeMonth = Carbon::now()->addMonths(-2);

        $usersCount = User::query()->count();
        $postsCount = Post::query()->count();
        $usersCountByMonth = User::query()
            ->whereBetween('created_at', [$dayBeforeMonth, $currDay])
            ->count();
        $postsCountByMonth = Post::query()
            ->whereBetween('created_at', [$dayBeforeMonth, $currDay])
            ->count();
        $usersByDateByMonth = User::query()
            ->selectRaw('date(created_at), count(user_id)')
            ->whereBetween('created_at', [$dayBeforeMonth, $currDay])
            ->groupByRaw('date(created_at)')
            ->get();
        $postsByDateByMonth = Post::query()
            ->selectRaw('date(created_at), count(post_id)')
            ->whereBetween('created_at', [$dayBeforeMonth, $currDay])
            ->groupByRaw('date(created_at)')
            ->get();

        return compact(
            'usersCount',
            'postsCount',
            'usersCountByMonth',
            'postsCountByMonth',
            'usersByDateByMonth',
            'postsByDateByMonth',
        );
    }
}
