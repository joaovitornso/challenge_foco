<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('rooms')->group(function () {
    Route::post('/', [RoomController::class, 'store']); // Criar um novo quarto
    Route::get('/', [RoomController::class, 'index']); // Listar todos os quartos
    Route::get('/{id}', [RoomController::class, 'show']); // Obter um quarto específico
    Route::put('/{id}', [RoomController::class, 'update']); // Atualizar um quarto
    Route::delete('/{id}', [RoomController::class, 'destroy']); // Excluir um quarto
});
