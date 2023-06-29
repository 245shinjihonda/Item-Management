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
    Route::get('/add', [App\Http\Controllers\UserController::class, 'UserAdd']);
    Route::get('/delete-list', [App\Http\Controllers\UserController::class, 'UserDeleteList']);
    Route::get('/delete', [App\Http\Controllers\UserController::class, 'UserDelete']);
});

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::get('/delete', [App\Http\Controllers\ItemController::class, 'ItemDelete']);
});

Route::prefix('inventories')->group(function () {
    Route::get('/', [App\Http\Controllers\InventoryController::class, 'InventoryRecord']);
    Route::get('/update', [App\Http\Controllers\InventoryController::class, 'InventoryUpdate']);
    Route::get('/input', [App\Http\Controllers\InventoryController::class, 'InventoryInput']);
});



