<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\V2\CategoryBlueprintController;
use App\Http\Controllers\Api\V2\CategoryController as V2CategoryController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('v1')->group(function () {
//     Route::apiResource('category', CategoryController::class);
// });

Route::prefix('v2')->group(function () {
    // Route::get('category/blueprint', CategoryBlueprintController::class);
    Route::apiResource('category', V2CategoryController::class);
});
