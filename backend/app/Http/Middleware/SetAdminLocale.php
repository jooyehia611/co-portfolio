<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('admin_locale', 'ar');

        if ($request->has('lang') && in_array($request->query('lang'), ['ar', 'en'], true)) {
            $locale = $request->query('lang');
            session(['admin_locale' => $locale]);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
