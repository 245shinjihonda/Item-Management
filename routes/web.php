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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'UserList']);
    Route::get('/add-form', [App\Http\Controllers\UserController::class, 'UserAddForm']);
    Route::post('/add', [App\Http\Controllers\UserController::class, 'UserAdd']);
    Route::get('/delete-list', [App\Http\Controllers\UserController::class, 'UserDeleteList']);
    Route::get('/delete/{id}', [App\Http\Controllers\UserController::class, 'UserDelete']);
});

Route::prefix('password')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'UserPassword']);
    Route::post('/update-form', [App\Http\Controllers\UserController::class, 'UserPasswordForm']);
    Route::post('/update/{id}', [App\Http\Controllers\UserController::class, 'UserPasswordUpdate']);
});

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'ItemIndex']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'ItemAdd']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'ItemAdd']);
    Route::get('/delete', [App\Http\Controllers\ItemController::class, 'ItemDelete']);
});

Route::prefix('inventories')->group(function () {
    Route::get('/', [App\Http\Controllers\InventoryController::class, 'InventoryRecord']);
    Route::get('/update', [App\Http\Controllers\InventoryController::class, 'InventoryUpdate']);
    Route::get('/input', [App\Http\Controllers\InventoryController::class, 'InventoryInput']);
});



