<?php

use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormPublicController;
use App\Http\Controllers\User\AcountWhatsaapController;
use App\Http\Controllers\User\AutoMessageController;
use App\Http\Controllers\User\ChangePasswordController;
use App\Http\Controllers\User\FormController;
use App\Http\Controllers\User\SetApiKeyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::group(['middleware' => ['role:Admin']], function() {
        Route::prefix('users')->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{id}/update', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
            Route::get('/{id}/forgot', [UserController::class, 'forgot'])->name('user.forgot');
            Route::put('/{id}/change', [UserController::class, 'change'])->name('user.change');
        });

        Route::prefix('subscription')->group(function() {
            Route::get('/', [SubscriptionController::class, 'index'])->name('subscription.index');
            Route::get('/create', [SubscriptionController::class, 'create'])->name('subscription.create');
            Route::post('/store', [SubscriptionController::class, 'store'])->name('subscription.store');
            Route::get('/{slug}/show', [SubscriptionController::class, 'show'])->name('subscription.show');
            Route::get('/{id}/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit');
            Route::put('/{id}/update', [SubscriptionController::class, 'update'])->name('subscription.update');
            Route::delete('/{id}/destroy', [SubscriptionController::class, 'destroy'])->name('subcription.destroy');
            Route::post('/bulkInsert', [SubscriptionController::class, 'bulkInsert'])->name('subscription.bulkInsert');
            Route::delete('/{subscription_id}/removeSubscribtion', [SubscriptionController::class, 'removeSubscribtion'])->name('subscription.removeSubscribtion');
        });
        
        Route::prefix('settings')->group(function() {
            Route::get('/', [PlatformController::class, 'index'])->name('setting');
            Route::post('/saved', [PlatformController::class, 'save'])->name('setting.save');
        });
    });

    Route::group(['middleware' => ['role:User']], function() {
        Route::prefix('forms')->group(function() {
            Route::get('/', [FormController::class, 'index'])->name('form.index');
            Route::get('/create', [FormController::class, 'create'])->name('form.create');
            Route::post('/store', [FormController::class, 'store'])->name('form.store');
            Route::get('/{id}/{slug}/show', [FormController::class, 'show'])->name('form.show');
            Route::put('/{id}/publish', [FormController::class, 'publish'])->name('form.publish');
            Route::put('/{id}/unpublish', [FormController::class, 'unpublish'])->name('form.unpublish');
            Route::post('/bulkInsertForm', [FormController::class, 'bulkInsertForm'])->name('form.bulkInsertForm');
            Route::delete('/{section_id}/deleteSection', [FormController::class, 'deleteSection'])->name('form.deleteSection');
            Route::delete('/{id}/destroy', [FormController::class, 'destroy'])->name('form.destroy');
        });

        Route::prefix('auto-message')->group(function() {
            Route::get('/', [AutoMessageController::class, 'index'])->name('auto.message.index');
            Route::get('/create', [AutoMessageController::class, 'create'])->name('auto.message.create');
            Route::post('/store', [AutoMessageController::class, 'store'])->name('auto.message.store');
            Route::get('/{id}/edit', [AutoMessageController::class, 'edit'])->name('auto.message.edit');
            Route::put('/{id}/update', [AutoMessageController::class, 'update'])->name('auto.message.update');
            Route::put('/{id}/updateStatus', [AutoMessageController::class, 'updateStatus'])->name('auto.message.updateStatus');
            Route::delete('/{id}/destroy', [AutoMessageController::class, 'destroy'])->name('auto.message.destroy');
        });

        Route::prefix('set-apikey')->group(function() {
            Route::get('/', [SetApiKeyController::class, 'index'])->name('apikey.index');
            Route::get('/create', [SetApiKeyController::class, 'create'])->name('apikey.create');
            Route::post('/store', [SetApiKeyController::class, 'store'])->name('apikey.store');
            Route::get('/{id}/connecting-to-wa', [SetApiKeyController::class, 'show'])->name('apikey.show');
            Route::get('/{id}/edit', [SetApiKeyController::class, 'edit'])->name('apikey.edit');
            Route::put('/{id}/update', [SetApiKeyController::class, 'update'])->name('apikey.update');
            Route::delete('/{id}/destroy', [SetApiKeyController::class, 'destroy'])->name('apikey.destroy');
            Route::get('/{id}/{unique}/relink', [SetApiKeyController::class, 'relink'])->name('apikey.relink');
        });

        Route::prefix('change-password')->group(function() {
            Route::get('/', [ChangePasswordController::class, 'index'])->name('change.password.index');
            Route::put('/{id}/update', [ChangePasswordController::class, 'update'])->name('change.password.update');
        });
    });
});

Route::get('{slug_user}/{slug_form}', [FormPublicController::class, 'index'])->name('form.public.show');
Route::post('/submit', [FormPublicController::class, 'submit'])->name('form.public.submit');

Route::get('{slug_user}/{slug_form}/priview', [FormPublicController::class, 'priview'])->name('form.unpublic.show');