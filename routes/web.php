<?php

use App\Http\Controllers\DeployController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Livewire\Cookies;
use App\Http\Livewire\Enquiry;
use App\Http\Livewire\Privacy;
use App\Http\Livewire\Settings;
use App\Http\Livewire\Terms;
use Illuminate\Support\Facades\Route;

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
