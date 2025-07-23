<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;


Route::resource('facturas', FacturaController::class);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Menús de sistema
Route::get('/empleados/menu', function () {
    return view('empleados.menu');
})->name('empleados.menu');

Route::get('/proveedores/menu', function () {
    return view('proveedores.menu');
})->name('proveedores.menu');

Route::get('/productos/menu', function () {
    return view('productos.menu');
})->name('productos.menu');

Route::get('/seleccionar-operacion', function () {
    return view('seleccion');
})->name('seleccion.operacion');

// Recursos
Route::resource('empleados', EmpleadoController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('productos', ProductoController::class);
Route::resource('facturas', FacturaController::class)->except(['edit', 'update', 'destroy']);
