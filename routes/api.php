<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;

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

//Auth::routes();

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 // Route::get('/api/campaigns', [App\Http\Controllers\CampaignController::class, 'index']);
	// Route::post('/api/campaigns', [App\Http\Controllers\CampaignController::class, 'store']);
	// Route::put('/api/campaigns/{id}', [App\Http\Controllers\CampaignController::class, 'update']);
	// Route::get('/api/campaigns/{id}', [App\Http\Controllers\CampaignController::class, 'destroy']);
Route::middleware('api')->group(function () {
    //Route::resource('campaigns', CampaignController::class);
    Route::get('/campaigns', [App\Http\Controllers\CampaignController::class, 'index']);
	Route::post('/campaigns', [App\Http\Controllers\CampaignController::class, 'store']);
	Route::pATCH('/campaigns/{id}', [App\Http\Controllers\CampaignController::class, 'update']);
	Route::get('/campaigns/{id}', [App\Http\Controllers\CampaignController::class, 'destroy']);
});
