<?php

// phpinfo();

use Illuminate\Support\Facades\Route;

//importação do controller
use App\Http\Controllers\EventController;

//vai utilizar o controller e tambem a rota ou action index
//URL, CONTROLLER E ACTION
Route::get('/', [EventController::class, 'index']);
Route::get('/events/create', [EventController::class, 'create']);
Route::get('/events/contact', [EventController::class, 'contact']);
Route::get('/events/product', [EventController::class, 'product']);

// Rota com parâmetro opcional por causa do sinal ?
// Route::get('/produtos_teste/{id?}', function ($id = null) {
//     // Mandar array com id para a view
//     return view('product', ['id' => $id]);
// });