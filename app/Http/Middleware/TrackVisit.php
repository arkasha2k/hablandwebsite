<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;

class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        // считаем только GET-заходы на страницы, не API и не ботов
        if ($request->isMethod('GET') && !$request->expectsJson()) {
            try {
                $ua = (string) $request->userAgent();
                $isBot = preg_match('/bot|crawl|spider|slurp|preview|facebookexternalhit/i', $ua);
                if (!$isBot) {
                    Visit::track(md5($request->ip() . '|' . $ua));
                }
            } catch (\Throwable $e) {
                // статистика не должна ронять страницу
            }
        }

        return $next($request);
    }
}
