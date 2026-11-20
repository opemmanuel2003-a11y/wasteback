<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Agent;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Household;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public website
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/services', 'services')->name('services');
    Route::get('/prices', 'prices')->name('prices');
    Route::get('/how-it-works', 'howItWorks')->name('how');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendMessage')->middleware('throttle:5,1')->name('contact.send');
});

// Authentication
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->middleware('throttle:10,1');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', fn () => redirect()->route(auth()->user()->homeRoute()))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
});

// Household (seller) portal
Route::middleware(['auth', 'role:household'])->prefix('household')->name('household.')->group(function () {
    Route::get('/', [Household\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pickups', [Household\PickupController::class, 'index'])->name('pickups.index');
    Route::get('/pickups/new', [Household\PickupController::class, 'create'])->name('pickups.create');
    Route::post('/pickups', [Household\PickupController::class, 'store'])->name('pickups.store');
    Route::get('/pickups/{pickup}', [Household\PickupController::class, 'show'])->name('pickups.show');
    Route::patch('/pickups/{pickup}/cancel', [Household\PickupController::class, 'cancel'])->name('pickups.cancel');
    Route::get('/wallet', [Household\WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/withdraw', [Household\WalletController::class, 'withdraw'])->name('wallet.withdraw');
});

// Field agent portal
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/', [Agent\PickupController::class, 'index'])->name('dashboard');
    Route::get('/history', [Agent\PickupController::class, 'history'])->name('history');
    Route::get('/pickups/{pickup}', [Agent\PickupController::class, 'show'])->name('pickups.show');
    Route::post('/pickups/{pickup}/collect', [Agent\PickupController::class, 'collect'])->name('pickups.collect');
});

// Administrator dashboard
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pickups', [Admin\PickupController::class, 'index'])->name('pickups.index');
    Route::get('/pickups/{pickup}', [Admin\PickupController::class, 'show'])->name('pickups.show');
    Route::patch('/pickups/{pickup}/assign', [Admin\PickupController::class, 'assign'])->name('pickups.assign');
    Route::patch('/pickups/{pickup}/cancel', [Admin\PickupController::class, 'cancel'])->name('pickups.cancel');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/new', [Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/toggle', [Admin\UserController::class, 'toggle'])->name('users.toggle');

    Route::get('/materials', [Admin\MaterialController::class, 'index'])->name('materials.index');
    Route::post('/materials', [Admin\MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/edit', [Admin\MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{material}', [Admin\MaterialController::class, 'update'])->name('materials.update');

    Route::get('/inventory', [Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/dispatch', [Admin\InventoryController::class, 'dispatch'])->name('inventory.dispatch');
    Route::post('/inventory/partners', [Admin\InventoryController::class, 'storePartner'])->name('inventory.partners.store');

    Route::get('/transactions', [Admin\TransactionController::class, 'index'])->name('transactions.index');

    Route::get('/messages', [Admin\MessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}/read', [Admin\MessageController::class, 'markRead'])->name('messages.read');
});
