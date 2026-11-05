<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 🆕 Читаемо-записываемая модель таблицы bans эмулятора.
 * Таблица лежит в той же БД, что и users (проверено на вашем дампе),
 * поэтому Laravel работает с ней напрямую через Eloquent.
 */
class Ban extends Model
{
    protected $table = 'bans';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'user_id', 'ip', 'machine_id', 'user_staff_id',
        'timestamp', 'ban_expire', 'ban_reason', 'type', 'cfh_topic',
    ];

    protected function casts(): array
    {
        return [
            'user_id'       => 'integer',
            'user_staff_id' => 'integer',
            'timestamp'     => 'integer',
            'ban_expire'    => 'integer',
            'cfh_topic'     => 'integer',
        ];
    }

    /** Бан всё ещё активен? (ban_expire = 0 означает бессрочный) */
    public function isActive(): bool
    {
        return $this->ban_expire === 0 || $this->ban_expire > time();
    }

    public function getExpiresAtAttribute(): ?Carbon
    {
        return $this->ban_expire > 0 ? Carbon::createFromTimestamp($this->ban_expire) : null;
    }

    /** Кто забанил */
    public function staff()
    {
        return $this->belongsTo(User::class, 'user_staff_id');
    }

    /** Кого забанили */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'ip'      => 'По IP',
            'machine' => 'По железу',
            'super'   => 'SUPER (акк + IP + железо)',
            default   => 'Аккаунт',
        };
    }

    public function scopeActive($q)
    {
        return $q->where(fn ($w) => $w->where('ban_expire', 0)->orWhere('ban_expire', '>', time()));
    }
}
