<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $primaryKey = 'day';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['day', 'hits', 'unique_visitors'];

    /**
     * Засчитать визит. Уникальность считаем по простому "отпечатку"
     * (ip+user-agent, захешированному md5) — без хранения персональных данных.
     */
    public static function track(string $fingerprint): void
    {
        $day = now()->toDateString();
        $row = static::firstOrNew(['day' => $day]);
        $row->hits++;

        // множество отпечатков за день храним в кэше (не в БД)
        $key = 'visit_fp_' . $day;
        $seen = cache()->get($key, []);
        if (!in_array($fingerprint, $seen, true)) {
            $seen[] = $fingerprint;
            cache()->put($key, array_slice($seen, -5000), now()->addDays(2));
            $row->unique_visitors = count($seen);
        }

        $row->save();
    }

    /** Суммарные показатели для главной */
    public static function stats(): array
    {
        $today = static::find(now()->toDateString());
        return [
            'total'      => (int) static::sum('hits'),
            'today'      => (int) ($today->hits ?? 0),
            'today_uv'   => (int) ($today->unique_visitors ?? 0),
            'week'       => (int) static::where('day', '>=', now()->subDays(6)->toDateString())->sum('hits'),
            'yesterday'  => (int) (static::find(now()->subDay()->toDateString())?->hits ?? 0),
        ];
    }
}
