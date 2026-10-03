<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $raw = (string) ($request->header('Accept-Language')
            ?? $request->query('lang')
            ?? 'ar');
        $locale = strtolower(substr(trim(explode(',', $raw)[0]), 0, 2));
        $locale = in_array($locale, ['ar', 'en'], true) ? $locale : 'ar';

        app()->setLocale($locale);

        return $next($request);
    }
}
