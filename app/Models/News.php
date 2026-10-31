<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 🆕 НОВЫЙ ФАЙЛ: app/Models/News.php
 */
class News extends Model
{
    protected $table = 'news';

    // У таблицы нет created_at/updated_at — время хранится в created_at_int (unixtime)
    public $timestamps = false;

    protected $fillable = [
        'title', 'body', 'image', 'category', 'featured', 'created_at_int',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
        ];
    }

    /** При создании новости автоматически проставляем текущий unixtime */
    protected static function booted(): void
    {
        static::creating(function (News $n) {
            if (empty($n->created_at_int)) {
                $n->created_at_int = time();
            }
        });
    }

    /** Аксессор: отдаёт Carbon при чтении (как в модели User) */
    public function getCreatedAtIntAttribute($value): ?Carbon
    {
        return $value ? Carbon::createFromTimestamp((int) $value) : null;
    }

    /** Метка категории для бейджа */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'update'  => 'Обновление',
            'contest' => 'Конкурс',
            default   => 'Событие',
        };
    }

    /** Цвет бейджа категории */
    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'update'  => 'cyan',
            'contest' => 'emerald',
            default   => 'fuchsia',
        };
    }

    public function scopePublished($q)
    {
        return $q->where('created_at_int', '<=', time())->orderByDesc('created_at_int');
    }
}
