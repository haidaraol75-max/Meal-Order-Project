<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\MenuItemController; 
use App\Http\Controllers\OrderController; 

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::middleware('auth:sanctum')->group(
    function () 
    {
        Route::post('create_employee',[UserController::class,'create_employee']);
        Route::get('users', [UserController::class, 'index']);
        Route::put('users/{user}', [UserController::class, 'update_employee']);
        Route::delete('users/{user}', [UserController::class, 'destroy_employee']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::post('logout',[UserController::class,'logout']);

    } 
);

Route::post('login',[UserController::class,'login']);




Route::get('menu-items', [MenuItemController::class, 'index']); // done 
Route::get('menu-items/{menuItem}',[MenuItemController::class,'show']); // done 
Route::post('menu-items', [MenuItemController::class,'store']);// done
Route::put('menu-items/{menuItem}', [MenuItemController::class, 'update']); // done
Route::delete('menu-items/{menuItem}', [MenuItemController::class,'destroy']);// done 
Route::patch('menu-items/{menuItem}/status', [MenuItemController::class, 'updateStatus']);
//___________________________menuitems + login => sended___________________________

// === Routes for Orders ===
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders', [OrderController::class, 'index']); 
    Route::get('orders/{order_id}', [OrderController::class, 'show']);
    Route::get('orders/{table_id}/table', [OrderController::class, 'getOrdersByTable']);
    Route::patch('orders/{order_id}/status', [OrderController::class, 'updateStatus']);
    Route::post('orders/{order}/pay', [OrderController::class, 'processPayment']); 
 
//___________________________ order creation => sended___________________________


Route::get('invoices', [InvoiceController::class, 'index']);         
Route::get('invoices/{invoice}', [InvoiceController::class, 'show']);
//___________________________ invoice creation => sended___________________________


?>
