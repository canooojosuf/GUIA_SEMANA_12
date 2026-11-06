<?php

use App\Http\Controllers\ComercioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaccionController;
use App\Http\Requests\GuardarTransaccionRequest;


use App\Http\Controllers\AuthController;

// Rutas accesibles únicamente para invitados (sin sesión)
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.store');

    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

// Rutas protegidas que exigen iniciar sesión
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ... aquí van TODAS las rutas existentes de comercios y transacciones 
    /*
|--------------------------------------------------------------------------
| Web Routes — TaskBoard (Pasarela de Pagos)
|--------------------------------------------------------------------------
| Semana 5 · Routing y Controladores
|
| Cada ruta conecta una URL + verbo HTTP con una acción del controlador.
| El controlador coordina; nunca contiene HTML ni SQL crudo.
*/

    Route::get('/', function () {
        return redirect()->route('comercios.index');
    });

    Route::get('/comercios', [ComercioController::class, 'index'])
        ->name('comercios.index');

    Route::get('/comercios/{comercio}', [ComercioController::class, 'show'])
        ->name('comercios.show');


    Route::get('/practica/formulario-demo', function () {
        return view('practica.formulario_demo');
    });


    Route::post('/practica/enviar', function (GuardarTransaccionRequest $request) {
        return '¡Formulario validado con éxito! Datos: ' . json_encode($request->validated());
    });


    Route::get(
        '/comercios/{comercio}/transacciones/nueva',
        [TransaccionController::class, 'create']
    )->name('transacciones.create');

    Route::post(
        '/transacciones',
        [TransaccionController::class, 'store']
    )->name('transacciones.store');
});
