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

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::get('/sort', [App\Http\Controllers\ItemController::class,'sort']);
    Route::get('/search',[App\Http\Controllers\ItemController::class,'search']);
    Route::get('/edit/{id}',[App\Http\Controllers\ItemController::class,'edit']);
    Route::patch('/update',[App\Http\Controllers\ItemController::class,'update']);
    Route::delete('/delete/{id}',[App\Http\Controllers\ItemController::class,'delete']);
});
