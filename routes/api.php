<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// User Create
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/revoke-all-tokens', [AuthController::class, 'revokeAllTokens']);
    Route::get('/list-tokens', [AuthController::class, 'listTokens']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


Route::get('login', function () {
    return response()->json([
        'message' => 'Login failed'
    ], 401);
})->name('login');
