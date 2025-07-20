<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuhController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('posts',PostController::class);
Route::post("/register",[AuhController::class ,"register"]);
Route::post("/login",[AuhController::class ,"login"]);
