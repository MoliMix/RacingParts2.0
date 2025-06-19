<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas para autocompletado
Route::get('/empleados/autocomplete', [EmpleadoController::class, 'autocomplete'])->name('empleados.autocomplete');
Route::get('/proveedores/autocomplete', [ProveedorController::class, 'autocomplete'])->name('proveedores.autocomplete');

// Rutas para menús
Route::get('/empleados/menu', function () {
    return view('empleados.menu');
})->name('empleados.menu');

Route::get('/proveedores/menu', function () {
    return view('proveedores.menu');
})->name('proveedores.menu');

// Rutas de recursos (CRUD)
Route::resource('empleados', EmpleadoController::class);
Route::resource('proveedores', ProveedorController::class);