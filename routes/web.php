<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Controller;
use App\Models\Item;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginform']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('role:admin');

Route::get('/operator', function () {
    return view('operator.dashboard');
})->middleware('role:operator');


Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class)->except(['show']);
    Route::get('/items/export', [ItemController::class, 'export'])->name('items.export');
    Route::get('/users_admin', [UserController::class, 'index'])->name('users_admin');
    Route::get('/users_operator', [UserController::class, 'operator'])->name('users_operator');
    Route::post('/user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');
});



//  OPERATOR

Route::middleware(['role:operator'])->prefix('operator')->name('operator.')->group(function () {

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');

    Route::get('/lendings', [LendingController::class, 'index'])->name('lendings.index');

    Route::post('/lendings', [LendingController::class, 'store'])->name('lendings.store');
    Route::patch('/lendings/{id}/returned', [LendingController::class, 'returned'])->name('lendings.returned');
    Route::delete('/lendings/{id}', [LendingController::class, 'destroy'])->name('lendings.destroy');

    // ✅ FIX RESET (hapus operator. di sini)
    Route::post('/user/{id}/reset-password', [UserController::class, 'resetPassword'])
        ->name('user.resetPassword');

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');

    // ✅ TAMBAH DELETE
    Route::delete('/users/{id}', [UserController::class, 'destroy'])
        ->name('user.delete');

});
