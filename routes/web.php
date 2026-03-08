<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Admin\RutaController as AdminRutaController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\RutaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ruta/{slug}', [RutaController::class, 'show'])->name('ruta.show');
Route::get('/api/rutas/search', [RutaController::class, 'search'])->name('api.rutas.search');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Rutas CRUD
        Route::get('/rutas', [AdminRutaController::class, 'index'])->name('rutas.index');
        Route::post('/rutas', [AdminRutaController::class, 'store'])->name('rutas.store');
        Route::get('/rutas/{ruta}', [AdminRutaController::class, 'show'])->name('rutas.show');
        Route::put('/rutas/{ruta}', [AdminRutaController::class, 'update'])->name('rutas.update');
        Route::delete('/rutas/{ruta}', [AdminRutaController::class, 'destroy'])->name('rutas.destroy');

        // Horarios CRUD + CSV
        Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
        Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
        Route::put('/horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
        Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');
        Route::post('/horarios/import-csv', [HorarioController::class, 'importCsv'])->name('horarios.importCsv');

        // Features CRUD
        Route::get('/features', [FeatureController::class, 'index'])->name('features.index');
        Route::post('/features', [FeatureController::class, 'store'])->name('features.store');
        Route::put('/features/{feature}', [FeatureController::class, 'update'])->name('features.update');
        Route::delete('/features/{feature}', [FeatureController::class, 'destroy'])->name('features.destroy');
    });
});
