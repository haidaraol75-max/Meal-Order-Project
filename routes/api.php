<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\MenuItemController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//Route::post('create_employee',[UserController::class,'create_employee'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(
    function () 
    {
        Route::post('create_employee',[UserController::class,'create_employee']);
    } 
);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');



Route::get('menu-items', [MenuItemController::class, 'index']); // done 
Route::get('menu-items/{menuItem}',[MenuItemController::class,'show']); // done 
Route::post('menu-items', [MenuItemController::class,'store']);// done
Route::put('menu-items/{menuItem}', [MenuItemController::class, 'update']); // done
Route::delete('menu-items/{menuItem}', [MenuItemController::class,'destroy']);// done 
Route::patch('menu-items/{menuItem}/status', [MenuItemController::class, 'updateStatus']);
