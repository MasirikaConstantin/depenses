<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSuite;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DepenseControllerStat;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AdminController::class, "index"])->middleware(['auth', 'verified','rolemanager:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','verified','rolemanager:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('user/{utilisateur}', [UserController::class,"voir"])->name('voir');
    Route::resource('admin', AdminSuite::class);
    Route::resource('categories', CategorieController::class);
    Route::patch('categories/{id}/to', [CategorieController::class, "toggleStatus"])->name('toggleStatus');
    Route::patch('/admin/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');

    

});
Route::get("/mes",function () {
    return User::all();
});
require __DIR__.'/auth.php';
