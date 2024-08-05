<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZapTapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::impersonate();


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'allUsers'])->name('users');
        Route::get('/user/create', [AdminController::class, 'create'])->name('user.create');
        Route::get('/user/edit/{id}', [AdminController::class, 'edit'])->name('user.edit');
        Route::post('/user/store', [AdminController::class, 'store'])->name('user.store');

        Route::get('/user/password/update/{id}', [AdminController::class, 'showPasswordForm'])->name('user.password.update');
        Route::post('/user/password/update/{id}', [AdminController::class, 'updatePassword'])->name('user.password.update');
        Route::delete('/user/destroy/{id}', [AdminController::class, 'destroy'])->name('user.destroy');

    });


});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [ZapTapController::class, 'index'])->name('dashboard');
    Route::get('/zaptap/create', [ZapTapController::class, 'create'])->name('zaptap.create');
    Route::post('/zaptap/store', [ZapTapController::class, 'store'])->name('zaptap.store');
    Route::get('/zaptap/show/{id}', [ZapTapController::class, 'show'])->name('zaptap.show');
    Route::get('/zaptap/edit/{id}', [ZapTapController::class, 'edit'])->name('zaptap.edit');
    Route::put('/zaptap/update/{id}', [ZapTapController::class, 'update'])->name('zaptap.update');
    Route::delete('/zaptap/destroy/{id}', [ZapTapController::class, 'destroy'])->name('zaptap.destroy');
    Route::get('/zaptap/test/{id}', [ZapTapController::class, 'test'])->name('zaptap.test');
});




require __DIR__.'/auth.php';
