<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

Route::group(['prefix' => 'auth'], function () {
    // guest routes
    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
});

Route::middleware(['auth:api'])->group(function(){
    // auth routes
    Route::post('me', [AuthController::class,'me']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('logout', [AuthController::class,'logout']);

    // author routes
    Route::apiResource('authors', AuthorController::class);
    // search authors
    Route::get('/author/search', [AuthorController::class, 'search']);

    // book routes
    Route::apiResource('books', BookController::class);
    // search books
    Route::get('/book/search', [BookController::class, 'search'])->name('books.search'); 
    
});