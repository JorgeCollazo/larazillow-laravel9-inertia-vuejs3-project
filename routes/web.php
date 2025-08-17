<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RealtonListingController;
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

//Route::resource('listing', ListingController::class)->only(['create', 'store'/*, 'edit', 'update'*/])->middleware('auth');  // This 'only' method will disable the rest of the routes
//Route::resource('listing', ListingController::class)->except(['destroy']);  // This will show all except this one
//Route::resource('listing', ListingController::class);  // This will show all methods, you can use the ->only(['index', 'destroy'])->middleware('auth') method to select specific ones, the same as above
Route::resource('listing', ListingController::class)->only(['Index', 'show']);  // This will show all methods, you can use the ->only(['index', 'destroy'])->middleware('auth') method to select specific ones, the same as above

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)->only(['create', 'store']);

Route::prefix('realtor')
    -> name('realtor.')
    -> middleware('auth')
    ->group(function () {           // All routes placed inside this will get ruled by the rules above
        Route::name('realton-listing.restore')->put('listing/{realton_listing}/restore', [RealtonListingController::class, 'restore'])
            ->withTrashed(); // This will include soft deleted items in the route, so you can restore them
        Route::resource('realton-listing', RealtonListingController::class)
            ->only(['Index','destroy', 'edit', 'update', 'create', 'store'])
            ->withTrashed();         // To include soft deleted items in the routes
//          ->parameters(['realton-listing' => 'listing']); // Map URL parameter to method parameter(Replacing the name)
    });


