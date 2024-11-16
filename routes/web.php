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
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');

    //editar nota
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::post('/editNoteSubmit', [MainController::class, 'editNoteSubmit'])->name('editNoteSubmit');
    //deletar nota
    Route::get('/deletNote/{id}', [MainController::class, 'deletNote'])->name('delete');
    Route::get('/deletNoteConfirm/{id}', [MainController::class, 'deletNoteConfirm'])->name('deleteConfirm');

    Route::get('/logout', [AuthController::class, 'logout'])->name('sair');
});