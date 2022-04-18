<?php

use App\Http\Controllers\OrderController;
use App\Imports\OrdersImport;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [OrderController::class, 'index']);

Route::post('store', [OrderController::class, 'store']);

//Route::get('show', [OrderController::class, 'show']);
