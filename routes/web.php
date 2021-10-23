<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('{any}', function () {
//     return view('home');
// })->where('any', '.*');

//make all routes accessible after login


Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	// Route::get('/api/campaigns', [App\Http\Controllers\CampaignController::class, 'index']);
	// Route::post('/api/campaigns', [App\Http\Controllers\CampaignController::class, 'store']);
	// Route::put('/api/campaigns/{id}', [App\Http\Controllers\CampaignController::class, 'update']);
	// Route::get('/api/campaigns/{id}', [App\Http\Controllers\CampaignController::class, 'destroy']);
   
});


