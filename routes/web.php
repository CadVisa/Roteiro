<?php

use App\Http\Controllers\externo\ConsentController;
use App\Http\Controllers\Externo\EstabelecimentoController;
use App\Http\Controllers\Externo\HomeController;
use App\Http\Controllers\Externo\LoginController;
use App\Http\Controllers\Interno\AdministradorController;
use App\Http\Controllers\Interno\CnaeController;
use App\Http\Controllers\interno\ConfigurationController;
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



// ROTAS PROTEGIDAS
Route::group(['middleware' => 'auth'], function () {

    Route::get('/administrador', [AdministradorController::class, 'index'])->name('administrador.index');

    Route::get('/administrador/cnaes', [CnaeController::class, 'index'])->name('cnae.index');
    Route::get('/administrador/novo_cnae', [CnaeController::class, 'create'])->name('cnae.create');
    Route::post('/administrador/novo_cnae', [CnaeController::class, 'store'])->name('cnae.store');
    Route::get('/administrador/{cnae}/visualizar_cnae', [CnaeController::class, 'show'])->name('cnae.show');
    Route::get('/administrador/{cnae}/editar_cnae', [CnaeController::class, 'edit'])->name('cnae.edit');
    Route::post('/administrador/{cnae}/editar_cnae', [CnaeController::class, 'update'])->name('cnae.update');
    Route::get('/administrador/{cnae}/editar_notas', [CnaeController::class, 'editNotas'])->name('cnae.edit-notas');
    Route::post('/administrador/{cnae}/editar_notas', [CnaeController::class, 'updateNotas'])->name('cnae.update-notas');
    Route::get('/administrador/{cnae}/nova_pergunta', [CnaeController::class, 'createQuestion'])->name('cnae.create-question');
    Route::post('/administrador/{cnae}/nova_pergunta', [CnaeController::class, 'storeQuestion'])->name('cnae.store-question');
    Route::get('/administrador/{pergunta}/editar_pergunta', [CnaeController::class, 'editQuestion'])->name('cnae.edit-question');
    Route::post('/administrador/{pergunta}/editar_pergunta', [CnaeController::class, 'updateQuestion'])->name('cnae.update-question');
    Route::delete('/administrador/{cnae}/excluir_cnae', [CnaeController::class, 'destroy'])->name('cnae.destroy');
    Route::delete('/administrador/{pergunta}/excluir_pergunta', [CnaeController::class, 'destroyQuestion'])->name('cnae.destroy-question');

    Route::get('/administrador/configuracao', [ConfigurationController::class, 'index'])->name('configuration.index');
    Route::get('/administrador/configuracao/editar_configuracao', [ConfigurationController::class, 'edit'])->name('configuration.edit');
    Route::post('/administrador/configuracao/editar_configuracao', [ConfigurationController::class, 'update'])->name('configuration.update');
    Route::post('/administrador/configuracao/{configuration}/ativa_sistema', [ConfigurationController::class, 'ativar'])->name('configuration.ativar');
    Route::post('/administrador/configuracao/{configuration}/suspender_sistema', [ConfigurationController::class, 'suspender'])->name('configuration.suspender');

    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});


