<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;

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



Route::post('login','App\Http\Controllers\UserController@login');
Route::post('register','App\Http\Controllers\UserController@register');


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('author', 'App\Http\Controllers\AuthorController');
    Route::get('/author/{id}', [AuthorController::class, 'show']);
    Route::GET('author/search/{term}', 'App\Http\Controllers\AuthorController@search');

    Route::post('logout', 'App\Http\Controllers\UserController@logout');

    Route::apiResource('book', 'App\Http\Controllers\BookController');

    });


