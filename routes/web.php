<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/projects/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
