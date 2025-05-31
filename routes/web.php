<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\VoertuigController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/instructeurs', [InstructeurController::class, 'index'])->name('instructeur.index');
Route::get('/instructeurs/{id}/voertuigen', [InstructeurController::class, 'voertuigen'])->name('instructeur.voertuigen');
Route::get('/voertuig/{pivot_id}/edit', [VoertuigController::class, 'edit'])->name('voertuig.edit');
Route::put('/voertuig/{pivot_id}/update', [VoertuigController::class, 'update'])->name('voertuig.update');
