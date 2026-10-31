<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\ManagementController;
use Illuminate\Support\Facades\Route;

// Rutas públcas. Todos pueden verlas
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/properties', [CatalogController::class, 'index'])->name('properties');
Route::get('/properties/{property}', [CatalogController::class, 'show'])->name('properties.show');

// Rutas privadas
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    // Registro
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});
Route::middleware('auth')->group(function () {

    // Cerrar sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [ClientController::class, 'show'])->name('profile');

    Route::middleware('role:client')->prefix('client')->name('client.')->group(function () {
        // Ver visitas para clientes
        // Route::get('/visits', [ClientController::class, 'visits'])->name('visits');
        // Revisar y editar el perfil
        // Route::get('/profile/favorites', [ClientController::class, 'favorites'])->name('favorites');
        // Route::patch('/profile/edit', [ClientController::class, 'update']);

    });

    Route::middleware('role:commercial')->prefix('commercial')->name('commercial.')->group(function () {
        // Ver visitas para agentes
        // Route::get('/visits', [UserController::class, 'visits'])->name('visits');
        // Route::get('/visits/reject', [AgentController::class, 'reject']);
        // Route::get('/properties', [AgentController::class, 'properties'])->name('your-properties');
        // Route::get('/properties/{id}', [AgentController::class, 'show']);
        // Route::get('/sales', [AgentController::class, 'sales']);
        // Route::get('/comissions', [AgentController::class, 'commissions']);
        Route::get('/dashboard', [CommercialController::class, 'show'])->name('dashboard');

    });

    Route::middleware('role:financial')->prefix('financial')->name('financial.')->group(function () {
        // Route::get('/sales', [FinancialController::class, 'index']);
        // Route::get('/sales/{id}', [FinancialController::class, 'show']);
        // Route::patch('/sales/{id}/validate', [FinancialController::class, 'validate']);
        // Route::patch('/sales/{id}/reject', [FinancialController::class, 'destroy']);
        Route::get('/dashboard', [FinancialController::class, 'show'])->name('dashboard');

    });

    Route::middleware('role:management')->prefix('management')->name('management.')->group(function () {
        Route::get('/dashboard', [ManagementController::class, 'show'])->name('dashboard');
    });
});
