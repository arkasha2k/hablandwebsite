<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'totalUsers'  => User::count(),
            'onlineUsers' => User::where('last_online', '>=', now()->subMinutes(5)->timestamp)->count(),
            'newest'      => User::orderByDesc('account_created')->limit(8)->get(),
            'richest'     => User::orderByDesc('credits')->limit(8)->get(),
        ]);
    }
}
