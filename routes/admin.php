<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\grade\GradeController as GradeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix(LaravelLocalization::setLocale().'/admin')->middleware( [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ])->name('admin.')->group(function () {
    Route::middleware([ 'auth'])->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('index');

        /* --------------------------------- Grades --------------------------------- */
        Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
        Route::post('grades/store', [GradeController::class, 'store'])->name('grade.store');
    });

    require __DIR__.'/Auth.php';
});
