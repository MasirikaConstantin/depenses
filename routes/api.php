<?php

use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\DepenseController;
use App\Http\Controllers\Api\GestionConnexion;
use App\Http\Controllers\Api\DepenseControllerApi;
use App\Http\Controllers\DepenseControllerStat;
use App\Http\Controllers\Api\EntreController;
use App\Http\Controllers\RecurringExpenseController;
use App\Models\RecurringExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [GestionConnexion::class, 'login']);
Route::post('/logout', [GestionConnexion::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [GestionConnexion::class, 'register']);
Route::put('/user', [GestionConnexion::class, 'update'])->middleware('auth:sanctum');
Route::put('/password', [GestionConnexion::class, 'updatePassword'])->middleware('auth:sanctum');
Route::post('/image/{user}', [GestionConnexion::class, 'updateImage'])->middleware('auth:sanctum');
Route::post('/imagedelete/{user}', [GestionConnexion::class, 'imagedeledata'])->middleware('auth:sanctum');
Route::get('/user/{user}', [GestionConnexion::class, 'show'])->middleware('auth:sanctum');
Route::delete('/user', [GestionConnexion::class, 'delete'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('depense', DepenseControllerApi::class);
    Route::get('/mesdepenses/{user}', [DepenseControllerApi::class,"mesdepenses"]);
    Route::get('/mesdepensesjournaliere/{user}', [DepenseControllerApi::class,"mesdepensesjournaliere"]);
    Route::get('/depenses-par-categorie/{user}', [DepenseControllerStat::class, 'getDepensesParCategorie']);
    Route::get('/depenses-par-jour/{user}', [DepenseControllerStat::class, 'getDepensesParJour']);
    Route::get('/depenses-par-mois/{user}', [DepenseControllerStat::class, 'getDepensesParMois']);
    Route::get('/depenses-par-mois/{user}', [DepenseControllerStat::class, 'getDepensesParMois']);
    Route::get('/depenses-par-semaine/{userId}', [DepenseControllerStat::class, 'getDepensesParSemaine']);
    Route::get('/moyenne-depenses-par-jour/{userId}', [DepenseControllerStat::class, 'getMoyenneDepensesParJour']);
    Route::get('/depenses-par-categorie/{userId}', [DepenseControllerStat::class, 'getDepensesParCategorie']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('recurring-expenses', RecurringExpenseController::class);
});
Route::apiResource('categorie', CategorieController::class)->middleware('auth:sanctum');
Route::apiResource('entres', EntreController::class);//->middleware('auth:sanctum');
Route::get('/mesentres/{user}', [EntreController::class,'mesentrees']);

Route::get('/mesdepensess/{user}', [DepenseControllerApi::class,"mesdepensess"]);
Route::get('/rec', function (){
    return RecurringExpense::all();
});