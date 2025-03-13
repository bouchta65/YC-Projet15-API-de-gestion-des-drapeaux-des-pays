<?php

use App\Http\Controllers\api\PaysController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('pays',[PaysController::class,'index']);
Route::post('pays/save',[PaysController::class,'store']);
Route::put('pays/update/{id}',[PaysController::class,'update']);
Route::delete('pays/delete/{id}',[PaysController::class,'delete']);


Route::post('pays/update/{id}/flag', [PaysController::class, 'updateFlag']);
Route::get('pays/update/{id}/flag', [PaysController::class, 'showImages']);

// Route::post('register',[AuthController::class,'register']);
