<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Datatable\DatatableController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Search\searchAppointementController;






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

    Route::post('/login',   [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register',[ApiAuthController::class, 'register'])->name('register.api');
    Route::get('/search',[SearchController::class, 'search'])->name('search.api');

    Route::get('/search-medecin',[SearchController::class, 'searchMedecin'])->name('searchmedecin.api');

    Route::post('/login-admin',   [AdminAuthController::class, 'login'])->name('login-admin.api');
    //Route::post('/register-admin',[AdminAuthController::class, 'register'])->name('register-admin.api');
    Route::post('/login-patient',   [PatientAuthController::class, 'login'])->name('login-patient.api');
    Route::post('/register-patient',[PatientAuthController::class, 'register'])->name('register-patient.api');


});

Route::group(['middleware' => ['cors', 'json.response','validateAPIKey']], function () {
    Route::delete('/delete-datatable',[DatatableController::class, 'delete'])->name('delete-datatable.api');
    Route::post('/document-store',[DocumentController::class, 'documentStore'])->name('document-store.api');

    Route::get('/get-pro',[SearchController::class, 'getMedecin'])->name('get-pro.api');


    Route::get('/search-appointement',[searchAppointementController::class, 'searchAppointement'])->name('searchmedecin.api');

    
    //
    Route::get('/show-record',[DatatableController::class, 'showRecord'])->name('show-record.api');
    Route::post('/update-datatable',[DatatableController::class, 'update'])->name('update-datatable.api');
    Route::post('/insert-datatable',[DatatableController::class, 'insert'])->name('insert-datatable.api');
    Route::get('/list-datatable',[DatatableController::class, 'tabledata'])->name('list-datatable.api');
});
