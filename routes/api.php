<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\StockController;
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

Route::get('/recipes-possible', [RecipeController::class,'displayPossibleRecipes']);
Route::resource('/stock',StockController::class);
Route::match(['get','post'],'/valid-recipe',[RecipeController::class,'validRecipe'])->name('recipe.store');

