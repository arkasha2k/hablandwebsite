<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    // Свой профиль
    public function me()
    {
        return redirect()->route('player.show', ['username' => Auth::user()->username]);
    }

    // Публичный профиль: /player/Nickname
    public function show(string $username)
    {
        $player = User::whereRaw('LOWER(username) = ?', [mb_strtolower($username)])->firstOrFail();

        return view('player.show', [
            'player' => $player,
            'isOwner' => Auth::check() && Auth::id() === $player->id,
        ]);
    }

    // Список игроков
    public function index()
    {
        return view('player.index', [
            'players' => User::orderByDesc('account_created')->paginate(20),
        ]);
    }
}
