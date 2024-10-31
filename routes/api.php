<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TestimonyController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/dashboard', DashboardController::class);
Route::apiResource('/services', ServiceController::class);
Route::apiResource('/clients', ClientController::class);
Route::apiResource('/projects', ProjectController::class);
Route::apiResource('/teams', TeamController::class);
Route::apiResource('/testimonies', TestimonyController::class);
