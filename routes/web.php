<?php

use App\Http\Controllers\Externo\HomeController;
use App\Http\Controllers\Externo\LoginController;
use App\Http\Controllers\Interno\AdministradorController;
use App\Http\Controllers\Interno\CnaeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

// ROTAS PROTEGIDAS
Route::group(['middleware' => 'auth'], function () {

    Route::get('/administrador', [AdministradorController::class, 'index'])->name('administrador.index');

    Route::get('/administrador/cnaes', [CnaeController::class, 'index'])->name('cnae.index');

    Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
});


