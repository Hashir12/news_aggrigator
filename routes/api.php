<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\AuthorController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('test-route',[\App\Http\Controllers\NewsController::class,'fetchNews']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/articles', [NewsController::class, 'index']);
Route::get('/categories-list', [CategoryController::class, 'CategoriesList']);
Route::get('/sources-list', [SourceController::class, 'SourcesList']);
Route::get('/authors-list', [AuthorController::class, 'AuthorList']);
