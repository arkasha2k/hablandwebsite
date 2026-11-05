<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * 🆕 Пускать только персонал отеля (rank >= 4 — модератор и выше).
 */
class EnsureStaff
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || $request->user()->rank < 4) {
            abort(403, 'Доступ только для персонала отеля.');
        }

        return $next($request);
    }
}
