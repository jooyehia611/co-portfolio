<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, ['ar', 'en'], true)) {
            session(['admin_locale' => $locale]);
            app()->setLocale($locale);
        }

        return back();
    }
}
