<?php

use Illuminate\Support\Facades\Route;
use Quepenny\Livewire\Http\Controllers\DeployController;
use Quepenny\Livewire\Http\Controllers\SocialLoginController;
use Quepenny\Livewire\Http\Livewire\Cookies;
use Quepenny\Livewire\Http\Livewire\Enquiry;
use Quepenny\Livewire\Http\Livewire\Privacy;
use Quepenny\Livewire\Http\Livewire\Settings;
use Quepenny\Livewire\Http\Livewire\Terms;

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

Route::get('contact', Enquiry::class)->name('contact');
Route::get('terms', Terms::class)->name('terms');
Route::get('privacy', Privacy::class)->name('privacy');
Route::get('cookies', Cookies::class)->name('cookies');
Route::post('deploy', DeployController::class);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('settings', Settings::class)->name('settings');
});

Route::prefix('social-login')->group(function () {
    Route::get('/{driver}', [SocialLoginController::class, 'redirectToProvider'])->name('social-login');
    Route::get('/{driver}/callback', [SocialLoginController::class, 'handleProviderCallback']);
});
