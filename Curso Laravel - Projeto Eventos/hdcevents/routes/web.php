<?php

// phpinfo();

use Illuminate\Support\Facades\Route;

//importação do controller
use App\Http\Controllers\EventController;

//vai utilizar o controller e tambem a rota ou action index
//URL, CONTROLLER E ACTION
Route::get('/', [EventController::class, 'index']);
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');
Route::get('/events/{id}', [EventController::class, 'show']);
//metodo store recebe toda logica de adição de dados no BD
Route::post('/events', [EventController::class, 'store']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);
Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');
Route::put('events/update/{id}', [EventController::class, 'update' ])->middleware('auth');

Route::get('/events/contact', [EventController::class, 'contact']);
// Rout::get('/contact', function () {
//     return view('contact');
// });

Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');

Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');

Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');

