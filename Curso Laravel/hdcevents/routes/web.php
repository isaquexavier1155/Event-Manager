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


Route::get('/events/contact', [EventController::class, 'contact']);
// Rout::get('/contact', function () {
//     return view('contact');
// });
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
