<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\OrderController;
/*categories
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'index'])->name('login');
 

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('products', [ProductController::class, 'index']);
    Route::get('categories', [CategoriesController::class, 'index']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('new-orders', [OrderController::class, 'newOrders']);
    Route::post('order', [OrderController::class, 'delOrders']);
     
});