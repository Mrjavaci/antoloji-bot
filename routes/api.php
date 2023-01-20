<?php

use App\Http\Controllers\GetPoemCountController;
use App\Http\Controllers\GetPoemOfWriterController;
use App\Http\Controllers\GetRandomPoemController;
use App\Http\Controllers\SearchByTitlePoemController;
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

Route::get('/count-of-poems', [GetPoemCountController::class, 'get']);
Route::get('/random-poem', [GetRandomPoemController::class, 'get']);
Route::get('/search-poem-by-title', [SearchByTitlePoemController::class, 'get']);

Route::post('/get-poem-of-writer', [GetPoemOfWriterController::class, 'get']);
