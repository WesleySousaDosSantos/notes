<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogger;
use Illuminate\Support\Facades\Route;
use Psy\VersionUpdater\Checker;


//checar se o usuário não está logado
Route::middleware([CheckIsNotLogger::class])->group(function() {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSave', [AuthController::class, 'loginSave']);
});

//checar se o usuário está logado
Route::middleware([CheckIsLogged::class])->group(function(){
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('novo');

    //editar nota
    Route::get('/edit/{id}', [MainController::class, 'editNote'])->name('edit');
    //deletar nota
    Route::get('/editNote/{id}', [MainController::class, 'deletNote'])->name('delete');

    Route::get('/logout', [AuthController::class, 'logout'])->name('sair');
});