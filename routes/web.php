<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SiteController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\SetLocale;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website (content comes from the database, managed in /admin)
|--------------------------------------------------------------------------
*/
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/page/{page:slug}', [SiteController::class, 'page'])->name('page.show');

Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

// FMB Developments Ltd (real estate)
Route::get('/development', [SiteController::class, 'development'])->name('development');
Route::get('/development/projects', [SiteController::class, 'projects'])->name('projects.index');
Route::get('/development/projects/{slug}', [SiteController::class, 'project'])->name('project.show');
Route::get('/landowners', [SiteController::class, 'landowners'])->name('landowners');

// Garments (static pages)
Route::get('/garments/services', [SiteController::class, 'garmentsServices'])->name('garments.services');
Route::view('/our-management', 'management');
Route::view('/collection/men-knit', 'collection-men-knit');
Route::view('/collection/women-knit', 'collection-women-knit');
Route::view('/collection/kid-knit', 'collection-kid-knit');
Route::view('/collection/home-tex', 'collection-home-tex');

// Language switch: English / বাংলা
Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, SetLocale::SUPPORTED, true), 404);
    session(['locale' => $locale]);

    return back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:20,1')->name('login.submit');

    Route::middleware(['auth', AuthenticateSession::class, EnsureAdmin::class])->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Projects
        Route::patch('projects/{project}/toggle/{field}', [Admin\ProjectController::class, 'toggle'])->name('projects.toggle');
        Route::post('projects/{id}/restore', [Admin\ProjectController::class, 'restore'])->whereNumber('id')->name('projects.restore');
        Route::delete('projects/{id}/force', [Admin\ProjectController::class, 'forceDelete'])->whereNumber('id')->name('projects.force-delete');
        Route::resource('projects', Admin\ProjectController::class)->except('show');

        Route::post('projects/{project}/images', [Admin\ProjectMediaController::class, 'storeImages'])->name('projects.images.store');
        Route::put('projects/{project}/images', [Admin\ProjectMediaController::class, 'updateImages'])->name('projects.images.update');
        Route::patch('projects/{project}/images/{image}/cover', [Admin\ProjectMediaController::class, 'useAsCover'])->name('projects.images.cover');
        Route::delete('projects/{project}/images/{image}', [Admin\ProjectMediaController::class, 'destroyImage'])->name('projects.images.destroy');
        Route::post('projects/{project}/units', [Admin\ProjectMediaController::class, 'storeUnit'])->name('projects.units.store');
        Route::put('projects/{project}/units/{unit}', [Admin\ProjectMediaController::class, 'updateUnit'])->name('projects.units.update');
        Route::delete('projects/{project}/units/{unit}', [Admin\ProjectMediaController::class, 'destroyUnit'])->name('projects.units.destroy');

        // Website content
        Route::resource('banners', Admin\BannerController::class)->except('show');
        Route::resource('pages', Admin\PageController::class)->except('show');
        Route::resource('testimonials', Admin\TestimonialController::class)->except('show');
        Route::resource('faqs', Admin\FaqController::class)->except('show');
        Route::resource('menus', Admin\MenuItemController::class)->except('show');
        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        // Media library
        Route::get('media', [Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('media', [Admin\MediaController::class, 'store'])->name('media.store');
        Route::patch('media/{medium}', [Admin\MediaController::class, 'update'])->name('media.update');
        Route::delete('media/{medium}', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

        // Enquiries (website leads)
        Route::get('enquiries/export', [Admin\EnquiryController::class, 'export'])->name('enquiries.export');
        Route::resource('enquiries', Admin\EnquiryController::class)->only(['index', 'show', 'update', 'destroy']);

        // Account
        Route::get('profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [Admin\ProfileController::class, 'password'])->name('profile.password');
    });
});
