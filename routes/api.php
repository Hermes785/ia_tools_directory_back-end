<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\PictureController;

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

Route::post('/register',[AuthentificationController::class ,'store']);
Route::post('/login',[AuthentificationController::class ,'login']);

Route::get('/pictures',[PictureController::class,'search']);

Route::delete('/pictures/delete/{id}',[PictureController::class,'destroy']);
Route::delete('/pictures/update/{id}',[PictureController::class,'update']);

Route::post('/postpictures',[PictureController::class,'store'])->middleware('App\Http\Middleware\React');
Route::get('/pictures/show/{id}',[PictureController::class,'show'])->middleware('App\Http\Middleware\React');


Route::get('/pictures/showlike/{id}',[PictureController::class, 'checklike'])->middleware('App\Http\Middleware\React');;

Route::delete('/pictures/handlelike/{id}',[PictureController::class, 'handlelike'])->middleware('App\Http\Middleware\React');

Route::post('/pictures/handlelike/{id}',[PictureController::class, 'handlelike'])->middleware('App\Http\Middleware\React');






/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
