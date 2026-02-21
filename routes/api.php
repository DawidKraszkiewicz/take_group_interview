<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('movies', \App\Http\Controllers\Api\MovieController::class)->only(['index', 'show']);
Route::apiResource('series', \App\Http\Controllers\Api\SerieController::class)->only(['index', 'show']);
Route::apiResource('genres', \App\Http\Controllers\Api\GenreController::class)->only(['index', 'show']);
