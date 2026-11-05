<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ban;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 🆕 Панель управления отелём: /admin (доступ rank >= 4)
 */
class AdminController extends Controller
{
    // ---------- Дашборд ----------
    public function dashboard()
    {
        return view('admin.dashboard', [
            'users'       => User::count(),
            'online'      => User::where('last_online', '>=', now()->subMinutes(5)->timestamp)->count(),
            'newsTotal'   => News::count(),
            'bansActive'  => Ban::active()->distinct('user_id')->count('user_id'),
            // visits хранит счётчик по дням: одна строка = один день
            'visitsToday' => DB::table('visits')->where('day', today()->format('Y-m-d'))->value('hits') ?? 0,
            'recentLogs'  => ActivityLog::with('user')->latest('id')->limit(8)->get(),
        ]);
    }

    // ---------- Новости: список ----------
    public function news(Request $request)
    {
        $q = News::query()->orderByDesc('created_at_int');

        if ($search = trim((string) $request->query('q'))) {
            $q->where('title', 'like', "%{$search}%");
        }

        return view('admin.news.index', [
            'items'  => $q->paginate(10)->withQueryString(),
            'search' => $search,
        ]);
    }

    public function newsCreate()
    {
        return view('admin.news.form', ['item' => new News()]);
    }

    public function newsStore(Request $request)
    {
        $data = $this->validateNews($request);
        $item = News::create($data);

        ActivityLog::record('news.create', "Создана новость «{$item->title}»", 'news', $item->id);

        return redirect()->route('admin.news.index')->with('success', 'Новость опубликована!');
    }

    public function newsEdit(News $news)
    {
        return view('admin.news.form', ['item' => $news]);
    }

    public function newsUpdate(Request $request, News $news)
    {
        $news->update($this->validateNews($request));

        ActivityLog::record('news.update', "Изменена новость «{$news->title}»", 'news', $news->id);

        return redirect()->route('admin.news.index')->with('success', 'Новость обновлена.');
    }

    public function newsDestroy(News $news)
    {
        $title = $news->title;
        $news->delete();

        ActivityLog::record('news.delete', "Удалена новость «{$title}»", 'news', $news->id);

        return back()->with('success', 'Новость удалена.');
    }

    private function validateNews(Request $request): array
    {
        return $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'body'     => ['required', 'string', 'max:10000'],
            'image'    => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'in:update,contest,event'],
            'featured' => ['boolean'],
        ], [], ['title' => 'заголовок', 'body' => 'текст']);
    }

    // ---------- Игроки: список ----------
    public function users(Request $request)
    {
        $q = User::query()->orderByDesc('last_online');

        if ($search = trim((string) $request->query('q'))) {
            $q->where('username', 'like', "%{$search}%");
        }
        if ($request->query('rank') !== null && $request->query('rank') !== '') {
            $q->where('rank', (int) $request->query('rank'));
        }

        $bannedIds = Ban::active()->pluck('user_id')->all();

        return view('admin.users.index', [
            'items'  => $q->paginate(15)->withQueryString(),
            'search' => $search,
            'banIds' => $bannedIds,
        ]);
    }

    public function userEdit(User $user)
    {
        return view('admin.users.form', [
            'user' => $user,
            'bans' => Ban::with('staff')->where('user_id', $user->id)->latest('id')->get(),
        ]);
    }

    public function userUpdate(Request $request, User $user)
    {
        $data = $request->validate([
            'motto'   => ['nullable', 'string', 'max:64'],
            'credits' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'rank'    => ['required', 'integer', 'min:0', 'max:7'],
        ]);

        $oldRank = $user->rank;
        $user->fill($data)->save();

        if ($oldRank !== $user->rank) {
            ActivityLog::record('user.rank',
                "Ранг {$user->username}: {$oldRank} → {$user->rank}", 'user', $user->id);
        } else {
            ActivityLog::record('user.edit',
                "Профиль {$user->username} отредактирован", 'user', $user->id);
        }

        return redirect()->route('admin.users.index')->with('success', 'Игрок сохранён.');
    }

    // ---------- Баны ----------
    public function banStore(Request $request, User $user)
    {
        $data = $request->validate([
            'reason' => ['required', 'string', 'max:200'],
            'type'   => ['required', 'in:account,ip,machine,super'],
            'days'   => ['nullable', 'integer', 'min:0', 'max:3650'],
        ], [], ['reason' => 'причина']);

        $days = (int) ($data['days'] ?? 0);

        $ban = Ban::create([
            'user_id'       => $user->id,
            'ip'            => $user->ip_current ?? '',
            'machine_id'    => '',
            'user_staff_id' => $request->user()->id,
            'timestamp'     => time(),
            'ban_expire'    => $days > 0 ? time() + $days * 86400 : 0,
            'ban_reason'    => $data['reason'],
            'type'          => $data['type'],
        ]);

        ActivityLog::record('user.ban',
            "Забанен {$user->username} (" . $ban->type_label . ', ' .
            ($days > 0 ? "{$days} дн." : 'навсегда') . "): {$data['reason']}",
            'ban', $ban->id);

        return back()->with('success', "Бан выдан: {$user->username}.");
    }

    public function banDestroy(Request $request, Ban $ban)
    {
        $who = optional($ban->user)->username ?? ('user#' . $ban->user_id);
        $ban->delete();

        ActivityLog::record('user.unban', "Снят бан #{$ban->id} для {$who}", 'ban', $ban->id);

        return back()->with('success', 'Бан снят.');
    }

    // ---------- Логи действий ----------
    public function logs(Request $request)
    {
        $q = ActivityLog::with('user')->latest('id');

        if ($action = (string) $request->query('action')) {
            $q->where('action', 'like', $action . '%');
        }

        return view('admin.logs', [
            'items'  => $q->paginate(25)->withQueryString(),
            'action' => $action,
        ]);
    }
}
