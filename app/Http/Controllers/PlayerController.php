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

    // Список игроков + поиск по нику / девизу
    public function index(\Illuminate\Http\Request $request)
    {
        $query = trim((string) $request->input('q'));

        $players = User::query()
            ->when($query !== '', function ($builder) use ($query) {
                $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $query) . '%';
                $builder->where(function ($sub) use ($like) {
                    $sub->where('username', 'like', $like)
                        ->orWhere('motto', 'like', $like);
                });
            })
            ->orderByDesc('account_created')
            ->paginate(20)
            ->withQueryString(); // сохраняет ?q= при переходе между страницами

        return view('player.index', [
            'players' => $players,
            'query'   => $query,
        ]);
    }
}
