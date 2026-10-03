<?php

use App\Http\Controllers\Admin\LocaleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\BusinessValueController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactLeadController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomepageSectionController;
use App\Http\Controllers\Admin\MediaFileController;
use App\Http\Controllers\Admin\ProcessStepController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SeoPageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\SetAdminLocale::class)->group(function () {
    Route::get('locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('homepage', [HomepageSectionController::class, 'index'])->name('homepage.index');
        Route::get('homepage/{homepage}/edit', [HomepageSectionController::class, 'edit'])->name('homepage.edit');
        Route::put('homepage/{homepage}', [HomepageSectionController::class, 'update'])->name('homepage.update');

        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::patch('projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.status');
        Route::resource('technologies', TechnologyController::class)->except(['show']);
        Route::resource('clients', ClientController::class)->except(['show']);
        Route::post('testimonials/invites', [TestimonialController::class, 'createInvite'])->name('testimonials.invites.store');
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('team', TeamMemberController::class)->except(['show']);
        Route::resource('statistics', StatisticController::class)->except(['show']);
        Route::resource('process-steps', ProcessStepController::class)->except(['show']);
        Route::resource('business-values', BusinessValueController::class)->except(['show']);
        Route::resource('awards', AwardController::class)->except(['show']);

        Route::resource('leads', ContactLeadController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::get('seo', [SeoPageController::class, 'index'])->name('seo.index');
        Route::get('seo/{seo}/edit', [SeoPageController::class, 'edit'])->name('seo.edit');
        Route::put('seo/{seo}', [SeoPageController::class, 'update'])->name('seo.update');

        Route::resource('media', MediaFileController::class)->only(['index', 'store', 'destroy']);
        Route::resource('users', UserController::class)->except(['show']);
    });
});
