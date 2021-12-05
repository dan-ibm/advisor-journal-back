<?php

use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [LoginController::class, 'register']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/refresh', [LoginController::class, 'refresh']);
    Route::get('/user-profile', [LoginController::class, 'userProfile']);
});

Route::group(['prefix' => 'admin'], function ($router) {
    Route::post('teacher/create', [AdvisorController::class, 'register']);
    Route::get('teacher/{id}', [AdvisorController::class, 'getTeacher']);

    Route::group(['prefix' => 'departments'], function ($router) {
        Route::get('', [DepartmentController::class, 'index']);
        Route::post('create', [DepartmentController::class, 'create']);
    });

});

Route::group(['prefix' => 'students'], function ($router) {
    Route::get('', [StudentController::class, 'index']);
    Route::post('create', [StudentController::class, 'create']);
});

Route::get('cache-write', [StudentController::class, 'writeCache']);
Route::get('cache-test', [StudentController::class, 'testCache']);



