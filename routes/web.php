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

Route::prefix('codes')->group(function () {
    Route::get('/', [App\Http\Controllers\CodeController::class, 'CodeIndex']);
    Route::get('/add', [App\Http\Controllers\CodeController::class, 'CodeAdd']);
    Route::post('/add', [App\Http\Controllers\CodeController::class, 'CodeAdd']);
    Route::get('/delete-list', [App\Http\Controllers\CodeController::class, 'CodeDeleteList']);
    Route::get('/delete/{id}', [App\Http\Controllers\CodeController::class, 'CodeDelete']);
    Route::get('/search', [App\Http\Controllers\CodeController::class, 'CodeSearch']);
});

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'ItemIndex']);
    Route::get('/download', [App\Http\Controllers\ItemController::class, 'ItemDownload']); 
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'ItemAdd']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'ItemAdd']);
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'ItemEdit']);
    Route::post('/update/{id}', [App\Http\Controllers\ItemController::class, 'ItemUpdate']);
    Route::get('/delete/{id}', [App\Http\Controllers\ItemController::class, 'ItemDelete']);
    Route::get('/search', [App\Http\Controllers\ItemController::class, 'ItemSearch']);
});

Route::prefix('inventories')->group(function () {
    Route::get('/', [App\Http\Controllers\InventoryController::class, 'InventoryIndex']);
    Route::get('/download', [App\Http\Controllers\InventoryController::class, 'InventoryDownload']);
    Route::get('/{id}', [App\Http\Controllers\InventoryController::class, 'InventoryRecord']);
    Route::get('/{id}/search', [App\Http\Controllers\InventoryController::class, 'InventorySearch']);
    Route::get('/update/{id}', [App\Http\Controllers\InventoryController::class, 'InventoryUpdate']);
    Route::post('/input/{id}', [App\Http\Controllers\InventoryController::class, 'InventoryInput']);
});

Route::prefix('finance')->group(function () {
    Route::get('/', [App\Http\Controllers\FinanceController::class, 'RevenueIndex']);
});

Route::prefix('users')->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'UserList']);
    Route::get('/add-form', [App\Http\Controllers\UserController::class, 'UserAddForm']);
    Route::get('/admi/add-form', [App\Http\Controllers\UserController::class, 'UserAdmiAddForm']);
    Route::post('/add', [App\Http\Controllers\UserController::class, 'UserAdd']);
    Route::post('/admi/add', [App\Http\Controllers\UserController::class, 'UserAdmiAdd']);
    Route::get('/delete-list', [App\Http\Controllers\UserController::class, 'UserDeleteList']);
    Route::get('/admi/delete-list', [App\Http\Controllers\UserController::class, 'UserAdmiDeleteList']);
    Route::get('/delete/{id}', [App\Http\Controllers\UserController::class, 'UserDelete']);
    Route::get('/admi/delete/{id}', [App\Http\Controllers\UserController::class, 'UserAdmiDelete']);
});



