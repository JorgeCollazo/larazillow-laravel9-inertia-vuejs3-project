<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAccountController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show'])->middleware('auth'); // Applying a middleware, they run before the Controller Action

//Route::get('/', function () {                         // Commented out
//    return view('welcome');
//});

//Route::resource('listing', ListingController::class)->only(['Index', 'show', 'create', 'store']);  // This 'only' method will disable the rest of the routes
//Route::resource('listing', ListingController::class)->except(['destroy']);  // This will show all except this one
Route::resource('listing', ListingController::class);  // This will show all methods, you can use the ->only(['index', 'destroy'])->middleware('auth') method to select specific ones, the same as above

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)->only(['create', 'store']);


