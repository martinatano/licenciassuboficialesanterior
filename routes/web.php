<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TablaController;
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

Route::get('/', [TablaController::class, 'index']);
Route::get('/tabla', [TablaController::class, 'envio']);
Route::post('procesar-form', [TablaController::class,'pocesarForm']);
