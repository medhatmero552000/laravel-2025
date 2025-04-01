<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Admin;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix(LaravelLocalization::setLocale().'/admin')->middleware( [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ])->name('admin.')->group(function () {
    Route::middleware([ 'auth'])->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('index');
    });

    require __DIR__.'/Auth.php';
});
