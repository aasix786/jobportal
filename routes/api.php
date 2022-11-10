<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DeveloperController;
use App\Http\Controllers\Api\StackController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectHoursController;
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
//twoFactor email verification.
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
    Route::post('/logout', [RegisterController::class, 'logout']);
    Route::get('/companies', [CompanyController::class, 'companies']);
    Route::get('/company/detail/{id}', [CompanyController::class, 'companyDetails']);
    // Developer Routes
    Route::get('/edit_developer', [DeveloperController::class, 'editDeveloper']);
    Route::post('/update_developer/{id}', [DeveloperController::class, 'updateDeveloper']);
    Route::post('/create/developerskills/{id}', [DeveloperController::class, 'createDeveloperSkills']);
    Route::get('/developer/skills/{id}', [DeveloperController::class, 'developerSkills']);
    Route::post('/create/developerstacks/{id}', [DeveloperController::class, 'createDeveloperStacks']);
    Route::post('assign/developer/project/{id}', [DeveloperController::class, 'assignDeveloperProject']);
    // Project Hours Routes
    Route::post('/developer/checkin/project/{id}', [ProjectHoursController::class, 'developerCheckin']);
    Route::post('/developer/break/project/{id}', [ProjectHoursController::class, 'developerBreak']);
    Route::post('/developer/checkout/project/{id}', [ProjectHoursController::class, 'developerCheckout']);
    Route::post('/developer/project/hours/bydate',[ProjectHoursController::class, 'developerDaliyHours']);
    // Stack Routes
    Route::get('/stacks', [StackController::class, 'index']);
    Route::post('/create/stack', [StackController::class, 'createStack']);
    Route::get('/edit/stack/{id}', [StackController::class, 'editStack']);
    Route::post('/update/stack/{id}', [StackController::class, 'updateStack']);
    Route::post('/delete/stack/{id}', [StackController::class, 'deleteStack']);
    // Skills Routes
    Route::get('/skills', [SkillController::class, 'index']);
    Route::post('/create/skill', [SkillController::class, 'createSkill']);
    Route::get('/edit/skill/{id}', [SkillController::class, 'editSkill']);
    Route::post('/update/skill/{id}', [SkillController::class, 'updateSkill']);
    Route::post('/delete/skill/{id}', [SkillController::class, 'deleteSkill']);
    // Project Routes
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/create/project', [ProjectController::class, 'createProject']);
    Route::post('/project/files/{id}', [ProjectController::class, 'projectFiles']);
    Route::post('/project/stacks/create/{id}', [ProjectController::class, 'projectStacks']);
    Route::get('/project/{id}', [ProjectController::class, 'project']);
    Route::post('/update/project/{id}', [ProjectController::class, 'updateProject']);
    Route::post('/delete/project/{id}', [ProjectController::class, 'deleteProject']);


    Route::group(['middleware' => ['admin']], function () {

    });
    Route::group(['middleware' => ['company']], function () {
        //Company Routes
        Route::get('/edit_company', [CompanyController::class, 'editCompany']);
        Route::post('/update_company/{id}', [CompanyController::class, 'updateCompany']);
        Route::post('details', [PasswordController::class, 'test']);
    });

});
