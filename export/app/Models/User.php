<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    // У таблицы нет created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'username', 'password', 'mail', 'motto', 'look', 'gender',
        'rank', 'credits', 'account_created', 'last_login', 'last_online',
        'auth_ticket', 'ip_register', 'ip_current',
    ];

    protected $hidden = [
        'password', 'auth_ticket', 'ip_register', 'ip_current',
    ];

    protected function casts(): array
    {
        return [
            'credits'  => 'integer',
            'rank'     => 'integer',
            'password' => 'hashed', // драйвер HASH_DRIVER (habbo-md5)
        ];
    }

    /*
     | ВАЖНО: account_created / last_login / last_online — INT с Unix-time.
     | Аксессоры ниже отдают Carbon при ЧТЕНИИ, но при ЗАПИСИ в БД уходят
     | сырые числа (time()) — без этого MySQL ругался "Data truncated".
     */

    public function getAccountCreatedAttribute($value): ?Carbon
    {
        return $value ? Carbon::createFromTimestamp((int) $value) : null;
    }

    public function getLastLoginAttribute($value): ?Carbon
    {
        return $value ? Carbon::createFromTimestamp((int) $value) : null;
    }

    public function getLastOnlineAttribute($value): ?Carbon
    {
        return $value ? Carbon::createFromTimestamp((int) $value) : null;
    }

    // ---------- Хелперы ----------

    public function getAvatarUrl(int $headOnly = 0, string $size = 'b', string $direction = '2'): string
    {
        return 'https://www.habbo.com.tr/habbo-imaging/avatarimage?figure='
            . urlencode($this->look) . '&headonly=' . $headOnly
            . '&size=' . $size . '&direction=' . $direction;
    }

    /**
     * Заглушка аватара: стабильный «рандомный» эмодзи,
     * детерминированно зависящий от ника игрока.
     */
    public function getEmojiAttribute(): string
    {
        $pool = ['😀','😎','🤠','😺','🐸','🦊','🐼','🐧','🦄','🐙',
                 '👾','🤖','🎃','⚡','🔥','💎','🍕','🌈','⭐','🎮'];

        return $pool[crc32(mb_strtolower($this->username)) % count($pool)];
    }

    public function isOnline(): bool
    {
        return $this->last_online && $this->last_online->greaterThan(now()->subMinutes(5));
    }

    public function getRankNameAttribute(): string
    {
        return match (true) {
            $this->rank >= 7 => 'Владелец',
            $this->rank >= 6 => 'Администратор',
            $this->rank >= 5 => 'Менеджер',
            $this->rank >= 4 => 'Модератор',
            $this->rank >= 3 => 'Эксперт',
            default         => 'Житель',
        };
    }
}
