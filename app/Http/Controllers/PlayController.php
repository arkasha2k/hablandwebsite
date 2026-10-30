<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlayController extends Controller
{
    /*
     | Страница игры: /play
     |
     | SSO для Arcturus (Morningstar):
     | 1. Генерируем уникальный билет и пишем его в users.auth_ticket
     | 2. Передаём билет клиенту в URL: client/index.html?ticket=...
     | 3. Nitro-клиент отправляет билет эмулятору при подключении,
     |    Arcturus находит юзера по auth_ticket и логинит без пароля.
     | Билет перевыпускается при каждом заходе на /play — старые ссылки умирают.
     */
    public function index()
    {
        // Гостя отправляем на логин, после входа вернётся сюда автоматически
        if (! Auth::check()) {
            return redirect()->guest(route('login'));
        }

        /** @var User $user */
        $user   = Auth::user();
        $ticket = $this->issueTicket($user);

        $clientUrl = asset('client/index.html');
        $clientUrl .= (str_contains($clientUrl, '?') ? '&' : '?') . 'ticket=' . $ticket;

        return view('play', [
            'clientUrl'    => $clientUrl,
            'clientExists' => file_exists(public_path('client/index.html')),
        ]);
    }

    // API: текущий онлайн (подсчёт из users)
    public function online()
    {
        // Если в твоей таблице users есть колонка `online` (1 = в игре),
        // замени строку ниже на: User::where('online', 1)->count()
        $online = User::where('last_online', '>=', now()->subMinutes(5)->timestamp)->count();

        return response()->json(['online' => $online])
            ->header('Cache-Control', 'no-store');
    }

    private function issueTicket(User $user): string
    {
        // Формат свободный: Arcturus ищет юзера по точному совпадению auth_ticket.
        // Префикс id- помогает отладке, 40 случайных символов — от перебора.
        $ticket = $user->id . '-' . Str::random(40);

        $user->forceFill(['auth_ticket' => $ticket])->save();

        return $ticket;
    }
}
