<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\CompanyController;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('/email/verification', [RegisterController::class, 'emailVerification']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('password/code/check', [PasswordController::class, 'passwordCodeCheck']);
Route::post('password/email', [PasswordController::class, 'passwordEmail']);
Route::post('reset/password', [PasswordController::class, 'passwordReset']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    //Company Routes
    Route::get('/edit_company', [CompanyController::class, 'editCompany']);
    Route::post('/update_company/{id}', [CompanyController::class, 'updateCompany']);
    Route::post('details', [PasswordController::class, 'test']);
    Route::post('/logout', [RegisterController::class, 'logout']);
    Route::post('password/update', [PasswordController::class, 'updatePassword']);


});
