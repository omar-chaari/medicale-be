<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Datatable\DatatableController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\Search\SearchAppointementController;
use App\Http\Controllers\Search\SearchConsultationController;

use App\Http\Controllers\Search\SearchAppointementProController;

use App\Http\Controllers\Search\AppointementProCalendrierController;

use Illuminate\Http\Response;


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
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register.api');
    Route::get('/search', [SearchController::class, 'search'])->name('search.api');

    Route::get('/search-medecin', [SearchController::class, 'searchMedecin'])->name('searchmedecin.api');

    Route::post('/login-admin',   [AdminAuthController::class, 'login'])->name('login-admin.api');
    //Route::post('/register-admin',[AdminAuthController::class, 'register'])->name('register-admin.api');
    Route::post('/login-patient',   [PatientAuthController::class, 'login'])->name('login-patient.api');
    Route::post('/register-patient', [PatientAuthController::class, 'register'])->name('register-patient.api');
    Route::get('/patient/activation/{token}', [PatientAuthController::class, 'activateAccount'])->name('patient.activation');
  
});

Route::group(['middleware' => ['cors', 'json.response', 'validateAPIKey']], function () {
    Route::delete('/delete-datatable', [DatatableController::class, 'delete'])->name('delete-datatable.api');
    Route::post('/document-store', [DocumentController::class, 'documentStore'])->name('document-store.api');

    Route::post('/consultation-store', [ConsultationController::class, 'store'])->name('consultation-store.api');

    
    Route::get('/get-pro', [SearchController::class, 'getMedecin'])->name('get-pro.api');
    Route::get('/search-consulatation', [SearchConsultationController::class, 'searchConsultation'])->name('search-consulatation.api');

    
    Route::get('/search-appointement', [searchAppointementController::class, 'searchAppointement'])->name('search-appointement.api');
    Route::get('/search-appointement-pro', [SearchAppointementProController::class, 'searchAppointement'])->name('search-appointement-pro.api');
    Route::get('/appointement-calendrier', [AppointementProCalendrierController::class, 'searchAppointement'])->name('appointement-calendrier.api');




    Route::post('/change-password-pro-admin',   [ApiAuthController::class, 'change_password_admin'])->name('change_password_pro_admin.api');
    Route::post('/change-password-pro',   [ApiAuthController::class, 'change_password'])->name('change_password_pro.api');
    Route::post('/change-password-patient-admin',   [PatientAuthController::class, 'change_password_admin'])->name('change_password_patient_admin.api');
    Route::post('/change-password-patient',   [PatientAuthController::class, 'change_password'])->name('change_password_patient.api');

    //
    Route::get('/show-record', [DatatableController::class, 'showRecord'])->name('show-record.api');
    Route::post('/update-datatable', [DatatableController::class, 'update'])->name('update-datatable.api');
    Route::post('/insert-datatable', [DatatableController::class, 'insert'])->name('insert-datatable.api');
    Route::get('/list-datatable', [DatatableController::class, 'tabledata'])->name('list-datatable.api');

 

    
});




Route::group(['middleware' => ['image.auth']], function () {
   

    Route::get('/images/{filename}', function ($filename) {
        $path = storage_path('app/public/fichier/' . $filename);
    
        if (file_exists($path)) {
            $response = new Response(file_get_contents($path), 200);

            $response->header('Content-Type', mime_content_type($path));
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET');
    
            return $response;
    
        } else {
            abort(404, 'Image not found');
        }
    
    });
});