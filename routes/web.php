<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\VnpayController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
//User
Route::get("/admin/user/list", [AdminUserController::class, "list"]);
Route::get("/admin/user/add", [AdminUserController::class, "add"]);
Route::post("/admin/user/store", [AdminUserController::class, "store"]);


// Cv Nhập Học
Route::get("/admin/cv", [CvController::class, "list"])->name("admin.cv.index");
// Test
Route::get("/admin/test", [VnpayController::class, "showReturn"]);
