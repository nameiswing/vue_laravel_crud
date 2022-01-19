<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/add-product', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/search-products/{name}', [ProductController::class, 'show']);
Route::get('/sorted-products', [ProductController::class, 'sorted']);
Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);
Route::patch('/edit-product/{id}', [ProductController::class, 'edit']);


Route::post('/set-limit/{limit}', [ProductController::class, 'setLimit']);
Route::get('/get-limit', [ProductController::class, 'getLimit']);