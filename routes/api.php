<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Search\SearchController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    // ...

    // public routes
    /*
    [AuthController::class, 'getLogin']
    */
    Route::post('/login',   [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register',[ApiAuthController::class, 'register'])->name('register.api');
    Route::get('/search',[SearchController::class, 'search'])->name('search.api');

    Route::get('/search-medecin',[SearchController::class, 'searchMedecin'])->name('searchmedecin.api');
    //Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

    // ...
    //searchMedecin

});
