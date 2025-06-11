<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\EmpleadoController;

Route::get('/empleados/crear', [EmpleadoController::class, 'create'])->name('empleados.create');
Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');

Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');

Route::get('/empleados/{empleado}/editar', [EmpleadoController::class, 'edit'])->name('empleados.edit');

Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update'])->name('empleados.update');

Route::get('/empleados/{empleado}', [EmpleadoController::class, 'show'])->name('empleados.show');
