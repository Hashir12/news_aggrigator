<?php

use App\Http\Controllers\PreferenceController;
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

    Route::get('/user-categories', [CategoryController::class, 'userFavoriteCategories']);
    Route::post('/toggle-user-category/{id}',[CategoryController::class, 'toggleUserCategory']);
    Route::get('/user-authors', [AuthorController::class, 'userFavoriteAuthors']);
    Route::post('/toggle-user-author/{id}',[AuthorController::class, 'toggleUserAuthor']);
    Route::get('/user-sources', [SourceController::class, 'userFavoriteSources']);
    Route::post('/toggle-user-source/{id}',[SourceController::class, 'toggleUserSource']);

    //saving bulk preferences
    Route::post('/save-bulk-preferences',[PreferenceController::class, 'bulkSavePreferences']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/articles', [NewsController::class, 'index']);
Route::get('/categories-list', [CategoryController::class, 'CategoriesList']);
Route::get('/sources-list', [SourceController::class, 'SourcesList']);
Route::get('/authors-list', [AuthorController::class, 'AuthorList']);
