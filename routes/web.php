<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PayModeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/template', function () {
    return view('app.template');
})->name('template');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('agents',AgentController::class);
Route::resource('users',UserController::class);
Route::resource('payMode',PayModeController::class);
Route::get('users.profile',[UserController::class,'profile'])->name('users.profile');
Route::post("communeOfProvince", [AgentController::class, "getCommuneOfProvince"])->name('getCommuneOfProvince');
Route::post("quartierOfCommune", [AgentController::class, "quartierOfCommune"])->name('quartierOfCommune');
Route::post("getAgent", [AgentController::class, "getAgent"])->name('getAgent');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
