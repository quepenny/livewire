<?php

use Illuminate\Support\Facades\Route;
use Quepenny\Livewire\Http\Controllers\SocialLoginController;
use Quepenny\Livewire\Settings;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::livewire('contact', 'pages::enquiry')->name('contact');
Route::get('terms', fn () => view('legal.terms'))->name('terms');
Route::get('privacy', fn () => view('legal.privacy'))->name('privacy');
Route::get('cookies', fn () => view('legal.cookies'))->name('cookies');
Route::get('email/verified', fn () => view('auth.email-verified'))->name('email.verified');

Route::middleware([
   config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('settings', Settings::class)->name('settings');
});

Route::prefix('social-login')->group(function () {
    Route::get('/{driver}', [SocialLoginController::class, 'redirectToProvider'])->name('social-login');
    Route::get('/{driver}/callback', [SocialLoginController::class, 'handleProviderCallback']);
});
