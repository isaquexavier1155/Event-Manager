<?php

// phpinfo();

// routes/web.php
use App\Http\Controllers\PixController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RifaController;

//importação do controller
// use App\Http\Controllers\EventController;

//CRIE ESSAs ROTAs HOJE
Route::get('/home', [RifaController::class, 'home']);
Route::get('/rifas/create_rifa', [RifaController::class, 'create'])->middleware('auth');
Route::get('/', [RifaController::class, 'index']);

Route::get('/dashboard', [RifaController::class, 'dashboard'])->middleware('auth');


//metodo store recebe toda logica de adição de dados no BD
Route::post('/rifas', [RifaController::class, 'store']);

//Rota adiciconada
Route::get('/showQrCode', [PixController::class, 'showQrCode']);

//URL, CONTROLLER E ACTION
//Route::get('/', [EventController::class, 'index']);
//Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');
//Route::get('/events/{id}', [EventController::class, 'show']);
// //metodo store recebe toda logica de adição de dados no BD
// Route::post('/events', [EventController::class, 'store']);
// Route::delete('/events/{id}', [EventController::class, 'destroy']);
// Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');
// Route::put('events/update/{id}', [EventController::class, 'update' ])->middleware('auth');
// Route::get('/events/contact', [EventController::class, 'contact']);
// Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');
// Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');
// Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');

