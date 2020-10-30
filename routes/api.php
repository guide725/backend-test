<?php

use App\Http\Controllers\Api\CreatorController;
use App\Http\Controllers\Api\PostController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware(['auth:api']) -> group(function() {
Route::middleware(['api']) -> group(function() {
    Route::post('login', [CreatorController::class,'login']);
    Route::get('logout', [CreatorController::class,'logout']);
    Route::get('refresh', [CreatorController::class,'refresh']);
    Route::resource('/posts', PostController::class);
    Route::get('/posts/{id}/publish', [PostController::class , 'published']);
});
