<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    return ['message' => "Api's working fine."];
});

Route::group(['prefix' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('users', [UserController::class, 'index']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::get('users/{user}', [UserController::class, 'show']);

        Route::get('todos', [TodoController::class, 'index']);
        Route::post('todos', [TodoController::class, 'store']);
        Route::put('todos/{todo}', [TodoController::class, 'update']);
        Route::get('todos/{todo}', [TodoController::class, 'show']);
        Route::delete('todos/{todo}', [TodoController::class, 'destroy']);
    });
});
