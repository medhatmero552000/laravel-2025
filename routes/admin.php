<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\Grade\GradeController as GradeController;
use App\Http\Controllers\GradeController as ControllersGradeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix(LaravelLocalization::setLocale().'/admin')->middleware( [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ])->name('admin.')->group(function () {
    Route::middleware([ 'auth'])->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('index');

        /* --------------------------------- Grades --------------------------------- */
        Route::get('/grades', [ControllersGradeController::class, 'index'])->name('grades.index');
        Route::post('grades/store', [ControllersGradeController::class, 'store'])->name('grade.store');
        Route::put('/grades/update/{grade}', [ControllersGradeController::class, 'update'])->name('grade.update');
        Route::delete('grades/delete/{grade}', [ControllersGradeController::class, 'destroy'])->name('grade.destroy');
        /* -------------------------------- Classroom ------------------------------- */
        Route::resource('classrooms', ClassroomController::class);
        Route::delete('classroomsDeleteAll', [ClassroomController::class, 'destroyAll'])->name('classrooms.deleteAll');

    });

    require __DIR__.'/Auth.php';
});
