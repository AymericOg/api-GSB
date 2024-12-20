<?php

use App\Http\Controllers\FraisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/visiteur/initpwds', [VisiteurController::class, "initPasswords"]);

Route::post('/visiteur/login', [VisiteurController::class, "login"]);

Route::get('/visiteur/logout', [VisiteurController::class, "logout"])->middleware('auth:sanctum');

Route::get('/visiteur/unauth',[VisiteurController::class,"unauthorized"])->name('login');

Route::get('/frais/{idFrais}',[FraisController::class,"getFrais"]);

Route::post('/frais/ajout',[FraisController::class,"ajoutFrais"]);

Route::post('/frais/modif',[FraisController::class,"modif"]);

Route::DELETE('/frais/supp',[FraisController::class,"supprimerFrais"]);

Route::get('/frais/liste/{idVisiteur}',[FraisController::class,"getlistefrais"]);
