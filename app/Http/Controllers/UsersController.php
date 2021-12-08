<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use App\Services\UploadService;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function get(Request $request)
    {
        $user_ids = $request->get('user_ids', '');
        if (empty($user_ids)) {
            $user_ids = [User::getCurrent()->user_id];
        } else {
            $user_ids = explode(',', $user_ids);
        }
        $users = User::query()
            ->whereIn('user_id', $user_ids)
            ->get();
        $users = $users->map(function (User $u) {
            return $u->toArray(1);
        });
        return compact('users');
    }

    public function getAll(Request $request)
    {
        if (!User::getCurrent()->isAdmin()) {
            return;
        }
        $users = User::query()->get();
        $users = $users->map(function (User $u) {
            return $u->toArray(1);
        });
        return compact('users');
    }

    public function block(Request $request)
    {
        if (!User::getCurrent()->isAdmin()) {
            return;
        }
        $user_id = $request->input('user_id');
        $user = User::query()
            ->where('role_id', User::ROLE_USER)
            ->find($user_id);
        $user->is_block = !$user->is_block;
        if ($user->is_block) {
            $user->remember_token = '';
        }
        $user->save();
    }

    public function save(Request $request)
    {
        $data = $request->all([
            'login',
            'nickname',
            'description',
        ]);
        User::getCurrent()->update($data);
        User::query()
            ->where('user_id', User::getCurrent()->user_id)
            ->update([
                'description' => $data['description']
            ]);
        return '';
    }

    public function setPhoto(Request $request, UploadService $uploadService)
    {
        $photo = $uploadService->savePhoto($request);
        User::getCurrent()->update(['photo_id' => $photo->photo_id]);
        return '';
    }

    public function getNew(Request $request)
    {
        $users = User::query()
            ->where('user_id', '!=', User::getCurrent()->user_id)
            ->limit(5)
            ->orderBy('user_id', 'DESC')
            ->get();
        return compact('users');
    }

    public function search(Request $request)
    {
        $q = $request->get('q');
        $q = mb_ereg_replace('%', '', $q);
        $users = User::query()
            ->whereRaw('login LIKE \'%' . $q . '%\'')
            ->orWhereRaw('nickname LIKE \'%' . $q . '%\'')
            ->where('user_id', '!=', User::getCurrent()->user_id)
            ->get();
        return compact('users');
    }

    public function follow(Request $request)
    {
        $user_id = $request->input('user_id');
        if ($user_id == User::getCurrent()->user_id) {
            return;
        }
        $user = User::query()->find($user_id);
        if ($user) {
            Follower::query()->create([
                'reader_id' => User::getCurrent()->user_id,
                'readable_id' => $user_id,
            ]);
            $user->refresh();
            $user = $user->toArray(true);
            return compact('user');
        }
    }

    public function unfollow(Request $request)
    {
        $user_id = $request->input('user_id');
        if ($user_id == User::getCurrent()->user_id) {
            return;
        }
        $user = User::query()->find($user_id);
        if ($user) {
            Follower::query()
                ->where('reader_id', User::getCurrent()->user_id)
                ->where('readable_id', $user_id)
                ->delete();
            $user->refresh();
            $user = $user->toArray(true);
            return compact('user');
        }
    }
}
