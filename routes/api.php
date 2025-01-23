<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReceivestockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
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

Route::apiResource('orders', OrderController::class);
Route::get('orderForm', [OrderController::class, 'orderForm'])->name('orders.orderForm');
Route::get('/getOrders', [OrderController::class, 'getOrders'])->name('orders.getOrders');
Route::get('orderView', [OrderController::class, 'orderView'])->name('orders.orderView');
Route::get('orderReceived', [OrderController::class, 'orderReceived'])->name('orders.orderReceived');
Route::get('/orders/update-status/{id}/{status}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::apiResource('addresses', AddressController::class);
Route::get('/getAddresses', [AddressController::class, 'getAddresses'])->name('addresses.getAddresses');

Route::resource('receivedstocks', ReceivestockController::class);
Route::get('/getReceivedstocks', [ReceivestockController::class, 'getReceivedstocks'])->name('receivedstocks.getReceivedstocks');

Route::apiResource('inventories', InventoryController::class);
Route::get('/getInventories', [InventoryController::class, 'getInventories'])->name('inventories.getInventories');
Route::post('inventories/bulk-update', [InventoryController::class, 'bulkUpdate'])->name('inventories.bulkUpdate');
Route::get('/getWarehouseInventories', [InventoryController::class, 'getWarehouseInventories'])->name('inventories.getWarehouseInventories');