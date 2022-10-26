<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DeveloperController;
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
//company registration
Route::post('register', [RegisterController::class, 'register']);
//twofactor email verification.
Route::post('/email/verification', [RegisterController::class, 'emailVerification']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('password/code/check', [PasswordController::class, 'passwordCodeCheck']);
Route::post('password/email', [PasswordController::class, 'passwordEmail']);
Route::post('reset/password', [PasswordController::class, 'passwordReset']);
//Developer registration.
Route::post('/register/developer', [RegisterController::class, 'registerDeveloper']);

Route::group(['middleware' => 'auth:api'], function () {
   //General
    Route::post('password/update', [PasswordController::class, 'updatePassword']);
    //Company Routes
    Route::get('/edit_company', [CompanyController::class, 'editCompany']);
    Route::post('/update_company/{id}', [CompanyController::class, 'updateCompany']);
    Route::post('details', [PasswordController::class, 'test']);
    Route::post('/logout', [RegisterController::class, 'logout']);
    // Developer Routes
    Route::get('/edit_developer', [DeveloperController::class, 'editDeveloper']);
    Route::post('/update_developer/{id}', [DeveloperController::class, 'updateDeveloper']);


});
