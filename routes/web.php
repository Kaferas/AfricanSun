<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PayModeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/template', function () {
//     return view('app.template');
// })->name('template');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::resource('customer',CustomerController::class);
    Route::resource('orders',OrdersController::class);
    Route::resource('service',ServiceController::class)->except(['show','create','edit']);
    Route::post('communeOfProvince',[AppController::class, 'getCommuneOfProvince'])->name('getCommuneOfProvince');
    Route::post('quartierOfCommune',[AppController::class, 'quartierOfCommune'])->name('quartierOfCommune');
    Route::post("getAgent", [AgentController::class, "getAgent"])->name('getAgent');
    Route::resource('agents',AgentController::class);
    Route::resource('users',UserController::class);
    Route::resource('payMode',PayModeController::class);
    Route::get('users.profile',[UserController::class,'profile'])->name('users.profile');

    Route::post('/order/pay', [OrdersController::class, 'validatePayment'])->name('order.pay');
    Route::get('/invoices', [OrdersController::class, 'indexInvoice'])->name('invoices.index');
    Route::get('/invoices/{order}', [OrdersController::class, 'showInvoice'])->name('invoices.show');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
require __DIR__.'/auth.php';
