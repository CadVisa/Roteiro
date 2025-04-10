<?php

use App\Http\Controllers\externo\ConsentController;
use App\Http\Controllers\externo\ContatoController;
use App\Http\Controllers\Externo\EstabelecimentoController;
use App\Http\Controllers\Externo\HomeController;
use App\Http\Controllers\Externo\LoginController;
use App\Http\Controllers\Interno\AdministradorController;
use App\Http\Controllers\interno\CardController;
use App\Http\Controllers\Interno\CnaeController;
use App\Http\Controllers\interno\ConfigurationController;
use App\Http\Controllers\interno\ContactsController;
use App\Models\Configuration;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/politica_privacidade', [HomeController::class,'politicaPrivacidade'])->name('politica_privacidade');
Route::get('/termos_uso', [HomeController::class,'termosUso'])->name('termos_uso');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

Route::post('/consent', [ConsentController::class, 'store'])->name('consent.store');

Route::post('/consultar_cnpj', [EstabelecimentoController::class, 'store'])->name('estabelecimento.store');
Route::get('/{estabelecimento}/{resultado}/dados_empresa', [EstabelecimentoController::class, 'show'])->name('estabelecimento.show');
Route::get('/{estabelecimento}/{resultado}/gerar_roteiro', [EstabelecimentoController::class, 'gerarRoteiro'])->name('estabelecimento.gerarRoteiro');

Route::get('/contato', [ContatoController::class, 'index'])->name('contato.index');
Route::post('/contato', [ContatoController::class, 'store'])->name('contato.store');



// ROTAS PROTEGIDAS
Route::group(['middleware' => 'auth'], function () {

    Route::get('/administrador', [AdministradorController::class, 'index'])->name('administrador.index');

    Route::get('/administrador/cnaes', [CnaeController::class, 'index'])->name('cnae.index');
    Route::get('/administrador/cnaes/novo_cnae', [CnaeController::class, 'create'])->name('cnae.create');
    Route::post('/administrador/cnaes/novo_cnae', [CnaeController::class, 'store'])->name('cnae.store');
    Route::get('/administrador/cnaes/{cnae}/visualizar_cnae', [CnaeController::class, 'show'])->name('cnae.show');
    Route::get('/administrador/cnaes/{cnae}/editar_cnae', [CnaeController::class, 'edit'])->name('cnae.edit');
    Route::post('/administrador/cnaes/{cnae}/editar_cnae', [CnaeController::class, 'update'])->name('cnae.update');
    Route::get('/administrador/cnaes/{cnae}/editar_notas', [CnaeController::class, 'editNotas'])->name('cnae.edit-notas');
    Route::post('/administrador/cnaes/{cnae}/editar_notas', [CnaeController::class, 'updateNotas'])->name('cnae.update-notas');
    Route::get('/administrador/cnaes/{cnae}/nova_pergunta', [CnaeController::class, 'createQuestion'])->name('cnae.create-question');
    Route::post('/administrador/cnaes/{cnae}/nova_pergunta', [CnaeController::class, 'storeQuestion'])->name('cnae.store-question');
    Route::get('/administrador/cnaes/{pergunta}/editar_pergunta', [CnaeController::class, 'editQuestion'])->name('cnae.edit-question');
    Route::post('/administrador/cnaes/{pergunta}/editar_pergunta', [CnaeController::class, 'updateQuestion'])->name('cnae.update-question');
    Route::delete('/administrador/cnaes/{cnae}/excluir_cnae', [CnaeController::class, 'destroy'])->name('cnae.destroy');
    Route::delete('/administrador/cnaes/{pergunta}/excluir_pergunta', [CnaeController::class, 'destroyQuestion'])->name('cnae.destroy-question');

    Route::get('/administrador/configuracao', [ConfigurationController::class, 'index'])->name('configuration.index');
    Route::get('/administrador/configuracao/editar_configuracao', [ConfigurationController::class, 'edit'])->name('configuration.edit');
    Route::post('/administrador/configuracao/editar_configuracao', [ConfigurationController::class, 'update'])->name('configuration.update');
    Route::post('/administrador/configuracao/{configuration}/ativa_sistema', [ConfigurationController::class, 'ativar'])->name('configuration.ativar');
    Route::post('/administrador/configuracao/{configuration}/suspender_sistema', [ConfigurationController::class, 'suspender'])->name('configuration.suspender');

    Route::get('/administrador/cards', [CardController::class, 'index'])->name('card.index');
    Route::get('/administrador/cards/novo_card', [CardController::class, 'create'])->name('card.create');
    Route::post('/administrador/cards/novo_card', [CardController::class, 'store'])->name('card.store');
    Route::get('/administrador/cards/{card}/visualizar_card', [CardController::class, 'show'])->name('card.show');
    Route::get('/administrador/cards/{card}/editar_card', [CardController::class, 'edit'])->name('card.edit');
    Route::post('/administrador/cards/{card}/editar_card', [CardController::class, 'update'])->name('card.update');
    Route::delete('/administrador/cards/{card}/excluir_card', [CardController::class, 'destroy'])->name('card.destroy');

    Route::get('/administrador/contatos', [ContactsController::class, 'index'])->name('contact.index');

    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});


