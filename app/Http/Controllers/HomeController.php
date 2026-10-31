<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // авторизованному обновляем last_online (раз в минуту), чтобы счётчик в шапке был живым
        if ($user = $request->user()) {
            if (!$user->last_online || $user->last_online->lt(now()->subMinute())) {
                $user->forceFill(['last_online' => time()])->save();
                Cache::forget('site_online_count');
            }
        }

        return view('home', [
            'totalUsers'  => User::count(),
            'onlineUsers' => self::onlineCount(),
            'news'        => News::published()->limit(4)->get(),
            'newest'      => User::orderByDesc('account_created')->limit(8)->get(),
            'richest'     => User::orderByDesc('credits')->limit(8)->get(),
        ]);
    }

    // общий счётчик онлайна (используется и в шаблоне шапки)
    public static function onlineCount(): int
    {
        return (int) Cache::remember('site_online_count', 30, fn () =>
            User::where('last_online', '>=', now()->subMinutes(5)->timestamp)->count()
        );
    }
}
