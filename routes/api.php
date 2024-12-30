<?php

use App\Http\Controllers\Api\DepenseController;
use App\Http\Controllers\Api\GestionConnexion;
use App\Http\Controllers\Api\DepenseControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [GestionConnexion::class, 'login']);
Route::post('/logout', [GestionConnexion::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [GestionConnexion::class, 'register']);
Route::put('/user', [GestionConnexion::class, 'update'])->middleware('auth:sanctum');
Route::delete('/user', [GestionConnexion::class, 'delete'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('depense', DepenseControllerApi::class);
    Route::get('/mesdepenses/{user}', [DepenseControllerApi::class,"mesdepenses"]);
});

Route::get('/mesdepensess/{user}', [DepenseControllerApi::class,"mesdepensess"]);