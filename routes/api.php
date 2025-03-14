<?php

use App\Http\Controllers\api\PaysController;
use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('pays',[PaysController::class,'index']);
Route::post('pays/save',[PaysController::class,'store']);
Route::put('pays/update/{id}',[PaysController::class,'update']);
Route::delete('pays/delete/{id}',[PaysController::class,'delete']);


Route::post('pays/update/{id}/flag', [PaysController::class, 'updateFlag']);
Route::get('pays/update/{id}/flag', [PaysController::class, 'showImages']);

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('/logout', [AuthController::class,"logout"])->middleware("auth:sanctum");


// Route::post('register',[AuthController::class,'register']);
