<?php

use App\Http\Controllers\AdmissionsRegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VnpayController;
use App\Models\Aspiration;
use App\Models\CombinationSubjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

// JWT LOGIN 
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, "login"]);
    Route::post('logout', [AuthController::class, "logout"]);
    Route::post('refresh', [AuthController::class, "refresh"]);
    Route::post('me', [AuthController::class, "me"]);
});

/*************************************************************/

// Show Region - District - Ward
Route::get("/region/show", [AdmissionsRegisterController::class, 'showRegion']);
Route::get("/district/show/{id}", [AdmissionsRegisterController::class, 'showDistrict']);
Route::get("/ward/show/{id}", [AdmissionsRegisterController::class, 'showWard']);
// Show Nguyện vọng
Route::get("/aspirations/show", function () {
    $aspiratons = Aspiration::all();
    return $aspiratons;
});
Route::get("/combinate-subjects/show/{id}", function ($id) {
    $combinationSubjects = Aspiration::find($id)->combinationSubjects;
    return $combinationSubjects;
});


// PDF
Route::get("/test/pdf", [AdmissionsRegisterController::class, 'pdf']);

// IPN Vnpay
Route::post("/vnpay_payment/ipn", [VnpayController::class, "ipn"]);
// Create Cv Hồ Sơ với PDF
Route::post("/cv/store", [AdmissionsRegisterController::class, 'store']);
// Update Cv
Route::post("/cv/update", [AdmissionsRegisterController::class, 'update']);
// Check unique Cv
Route::get("/cv/{param}", [AdmissionsRegisterController::class, 'showCvByCCCD']);
