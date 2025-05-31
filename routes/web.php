<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\VoertuigController;

Route::get('/', [InstructeurController::class, 'index'])->name('home');
Route::get('/instructeurs', [InstructeurController::class, 'index'])->name('instructeur.index');
Route::get('/instructeurs/{id}/voertuigen', [InstructeurController::class, 'voertuigen'])->name('instructeur.voertuigen');
Route::get('/voertuig/{pivot_id}/edit', [VoertuigController::class, 'edit'])->name('voertuig.edit');
Route::put('/voertuig/{pivot_id}/update', [VoertuigController::class, 'update'])->name('voertuig.update');

// New routes for Scenario 3
Route::get('/instructeur/{instructeurId}/available-vehicles', [VoertuigController::class, 'available'])->name('voertuig.available');
Route::get('/voertuig/{voertuigId}/edit-unassigned/{instructeurId}', [VoertuigController::class, 'editUnassigned'])->name('voertuig.edit-unassigned');
Route::put('/voertuig/{voertuigId}/update-unassigned/{instructeurId}', [VoertuigController::class, 'updateUnassigned'])->name('voertuig.update-unassigned');
