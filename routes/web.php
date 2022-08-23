<?php

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

Route::get('/', function () {
    return redirect()->route('breaks');
});



Route::middleware(['auth'])->group(function() {

    /////////////////////////
    /// COLLECTION ROUTES ///
    Route::get('/collection/{username}',[\App\Http\Controllers\CollectionController::class, 'show'])->name('collection');

    ////////////////////
    /// BREAK ROUTES ///
    Route::get('/breaks', [\App\Http\Controllers\BreakController::class,'index'])->name('breaks');
    Route::get('/break/new',[\App\Http\Controllers\BreakController::class,'create'])->name('newBreak');
    Route::post('/break',[\App\Http\Controllers\BreakController::class,'save'])->name('saveBreak');
    Route::delete('/break/{id}',[\App\Http\Controllers\BreakController::class,'delete'])->name('deleteBreak');

    ///////////////////
    /// USER ROUTES ///
    Route::get('/user/{user}', [\App\Http\Controllers\UserController::class,'show'])->name('profile');
    Route::post('/user/{user}', [\App\Http\Controllers\UserController::class,'update'])->name('updateProfile');
});

Route::get('/break/{id}',[\App\Http\Controllers\BreakController::class,'show'])->name('showBreak');
Route::get('/break/{id}/calendar',[\App\Http\Controllers\BreakController::class,'downloadInvite'])->name('calendarInvite');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
