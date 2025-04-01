<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::prefix(LaravelLocalization::setLocale().'/front')->middleware( [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ])->name('front.')->group(function () {
    Route::middleware('web')->group(function(){
        Route::view('/', 'front.index');
    });

    require __DIR__.'/auth.php';
});


