<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 🆕 Действия администраторов (CMS-лог).
 */
class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'action', 'description', 'target_type', 'target_id', 'ip', 'created_at_int',
    ];

    /** Кто сделал запись */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::creating(function (ActivityLog $log) {
            if (empty($log->created_at_int)) {
                $log->created_at_int = time();
            }
        });
    }

    public function getCreatedAtIntAttribute($value): ?Carbon
    {
        return $value ? Carbon::createFromTimestamp((int) $value) : null;
    }

    /** Иконка + метка для типа действия */
    public function getActionLabelAttribute(): string
    {
        return match (true) {
            str_starts_with($this->action, 'news.create') => '📰 Новость создана',
            str_starts_with($this->action, 'news.update') => '✏️ Новость изменена',
            str_starts_with($this->action, 'news.delete') => '🗑 Новость удалена',
            str_starts_with($this->action, 'user.ban')   => '🔨 Бан выдан',
            str_starts_with($this->action, 'user.unban') => '✅ Бан снят',
            str_starts_with($this->action, 'user.rank')  => '🎖 Смена ранга',
            str_starts_with($this->action, 'user.edit')  => '📝 Профиль изменён',
            default => $this->action,
        };
    }

    /** Цвет бейджа по категории действия */
    public function getActionColorAttribute(): string
    {
        return match (true) {
            str_starts_with($this->action, 'news')  => 'cyan',
            str_contains($this->action, 'ban')      => 'rose',
            str_contains($this->action, 'rank')     => 'fuchsia',
            default                                => 'violet',
        };
    }

    /**
     * Записать действие в лог. Вызывается из админ-контроллеров.
     */
    public static function record(string $action, string $description,
                                  ?string $targetType = null, ?int $targetId = null): static
    {
        return static::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'description' => $description,
            'target_type' => $targetType,
            'target_id'   => $targetId,
            'ip'          => request()->ip(),
        ]);
    }
}
