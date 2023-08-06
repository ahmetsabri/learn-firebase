<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\FirestoreController;
use Illuminate\Http\Request;
use Illuminate\Queue\Connectors\DatabaseConnector;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

//update
Route::put('user',[AuthController::class,'update']);

// Enable/Disble
Route::post('disable',[AuthController::class,'disable']);
Route::post('enable',[AuthController::class,'enable']);

// All users
Route::get('users',[AuthController::class,'index']);

// Single User
Route::get('user',[AuthController::class,'show']);

// Delete User
Route::delete('user',[AuthController::class,'delete']);

Route::prefix('real-db')->group(function(){
    Route::post('/', [DatabaseController::class, 'store']);
    Route::get('/', [DatabaseController::class, 'index']);
    Route::put('/', [DatabaseController::class, 'update']);
    Route::delete('/', [DatabaseController::class, 'delete']);
});


Route::prefix('firestore')->group(function(){
    Route::post('/', [FirestoreController::class, 'store']);
    Route::get('/', [FirestoreController::class, 'index']);
    Route::put('/', [FirestoreController::class, 'update']);
    Route::delete('/', [FirestoreController::class, 'destroy']);
});

