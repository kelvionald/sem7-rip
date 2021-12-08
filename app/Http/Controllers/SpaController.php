<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpaController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user() && $request->url() == route('auth')) {
            return redirect('/profile');
        }
        return view('spa');
    }

    public function ulogin()
    {
        $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        $data = json_decode($s, true);
        $user = User::query()
            ->where('network', $data['network'])
            ->where('identity', $data['identity'])
            ->first();
        if (!$user) {
            $user = User::query()
                ->create([
                    'network' => $data['network'],
                    'identity' => $data['identity'],
                    'role_id' => User::ROLE_USER,
                ]);
            $user->update([
                'nickname' => '#' . $user->user_id,
                'login' => 'p' . $user->user_id,
            ]);
        } else {
            if ($user->is_block) {
                return;
            }
        }
        Auth::login($user, true);
        return redirect('/profile');
    }

    public function admin(Request $request)
    {
        if (Auth::user() && $request->url() == route('auth')) {
            return redirect('/profile');
        }
        return view('spa');
    }

    public function adminlogin(Request $request)
    {
        $user = User::query()
            ->where('login', $request->input('login'))
            ->where('password', $request->input('password'))
            ->where('role_id', User::ROLE_ADMIN)
            ->first();
        if (!$user) {
            return;
        }
        Auth::login($user, true);
        return redirect('/admin');
    }

    public function logout()
    {
        $user = User::getCurrent();
        Auth::logout();
        return redirect('/');
    }
}
