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

Route::get('/empleados/menu', function () {
    return view('empleados.menu');
})->name('empleados.menu');

Route::get('/proveedores/menu', function () {
    return view('proveedores.menu');
})->name('proveedores.menu');

Route::resource('empleados', EmpleadoController::class);
Route::resource('proveedores', ProveedorController::class);
