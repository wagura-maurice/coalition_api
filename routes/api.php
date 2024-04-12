<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskCatalogController;
use App\Http\Controllers\TaskCategoryController;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::group(['prefix' => '/coalition'], function () {
    Route::apiResource('/task/category', TaskCategoryController::class, ['as' => 'task']);
    Route::apiResource('/task/catalog', TaskCatalogController::class, ['as' => 'task']);
});
