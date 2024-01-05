<?php

// phpinfo();

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RifaController;
use App\Http\Controllers\CompradorController;
use App\Http\Controllers\UserController;

//importação do controller
// use App\Http\Controllers\EventController;

//CRIE ESSAs ROTAs HOJE
Route::get('/home', [RifaController::class, 'home']);
Route::get('/rifas/create_rifa', [RifaController::class, 'create'])->middleware('auth');
Route::get('/', [RifaController::class, 'index']);

Route::get('/dashboard-minhas-rifas', [RifaController::class, 'dashboard_minhas_rifas'])->middleware('auth');

//metodo store recebe toda logica de adição de dados no BD
Route::post('/payment-fee-publication', [RifaController::class, 'store'])->middleware('auth');
//rota responsavel por retornar resposta da API onde é possível obter status da cobrança por qrcode
Route::get('/consult-qrcode', [RifaController::class, 'consultQrCode'])->middleware('auth');

//Rota para termos de uso
Route::get('/rifas/terms_of_use', [RifaController::class, 'terms_of_use']);
//Rota para politicas de privacidade
Route::get('/rifas/policy', [RifaController::class, 'policy']);
//Rota acessada depois de fazer o login

//Rodas do lado do usuário comprador de bilhetes
Route::get('/comprar-bilhetes/{id}', [RifaController::class, 'mostrarPaginaCompra']);
//Route::post('/comprar-bilhetes', [RifaController::class, 'comprarBilhetes']);

//Route::get('/processar',  [RifaController::class, 'processarSelecao'])->name('processarSelecao');
Route::get('/rifas/{id}/bilhetes/{pagina}', [RifaController::class, 'getMoreBilhetes']);

//Novas rotas para processar compra dos bilhetes da sorte
Route::get('/compradores/processar-compra-bilhetes',  [CompradorController::class, 'processarCompraBilhetes'])->name('compradores.processar-compra-bilhetes');
Route::post('/compradores/store', [CompradorController::class, 'store'])->name('compradores.store');

//Rota para obter números escolhidos pelo usuário e deixar celulas verdes que já foram selecionadas
Route::get('/compradores/obter-numeros-escolhidos', [CompradorController::class, 'obterNumerosEscolhidos'])->name('compradores.obter-numeros-escolhidos');

//Rota responsavel por processar pagamento bilhetes
Route::post('/payment-purchased-tickets', [CompradorController::class, 'store'])->middleware('auth');

//Route::post('/atualizar-status-cobranca', [RifaController::class, 'atualizarStatusCobranca']);
//Route::post('/atualizar-status-cobranca', 'RifaController@atualizarStatusCobranca');

Route::get('/dashboard-minhas-configuracoes', [RifaController::class, 'dashboard_minhas_configuracoes'])->middleware('auth');

//ROTAS PARA EDITAR DADOS DOS USUÁRIOS
Route::get('/users/{id}', [UserController::class, 'show'])->name('rifas.dashboard-minhas-configuracoes');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');





//ROAS ABAIXO COMPOEM O CRUD DO PROJETO HDCEVENTS
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

