<?php

use App\Http\Controllers\Controller;

use App\Http\Controllers\AppController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
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


// Route::get('/ping', function () {
//     return response()->json(['message' => 'pong']);
// });

Route::get('/ping', [AppController::class, 'ping']);

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'create']);
Route::get('/posts/{id}', [PostController::class, 'read']);
Route::patch('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'delete']);

Route::post('/posts/{postId}/comments', [CommentController::class, 'create']);
Route::delete('/posts/{postId}/comments/{id}', [CommentController::class, 'delete']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'create']);
Route::patch('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'delete']);