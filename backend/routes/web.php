<?php

use App\Http\Controllers\Api\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
Route::get('/robots.txt', [SeoController::class, 'robots']);

/*
| Serve the React SPA from public/app.html for all non-admin/non-api paths.
| This keeps frontend + API on the same InfinityFree domain (avoids CORS / bot-check issues).
*/
Route::get('/{any?}', function () {
    $spa = public_path('app.html');
    abort_unless(is_file($spa), 404, 'Frontend build missing. Upload public/app.html and public/assets.');

    return response(file_get_contents($spa), 200, [
        'Content-Type' => 'text/html; charset=UTF-8',
    ]);
})->where('any', '^(?!admin|api|up|storage).*$');
