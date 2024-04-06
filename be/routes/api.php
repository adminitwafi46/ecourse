<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\babController;
use App\Http\Controllers\materiController;
use App\Http\Controllers\kuisController;
use App\Http\Controllers\jawabanController;
use App\Http\Controllers\paymentController;

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

//prefix auth
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    //user information
    Route::get('user', [AuthController::class, 'user']);
    //save user information
    Route::post('save_user', [AuthController::class, 'save_user']);
    //save password
    Route::post('save_password', [AuthController::class, 'save_password']);
});

//prefix course
Route::prefix('course')->group(function () {
    Route::get('index', [courseController::class, 'index']);
    Route::post('store', [courseController::class, 'store']);
    Route::get('show/{id}', [courseController::class, 'show']);
    Route::put('update/{id}', [courseController::class, 'update']);
    Route::delete('destroy/{id}', [courseController::class, 'destroy']);

    //my_courses
    Route::get('my_courses', [courseController::class, 'my_courses']);
    //learn now id course
    Route::get('learn_now/{id}', [courseController::class, 'learn_now']);
    //dataCourse (materi) by id
    Route::get('dataCourse/{id}', [courseController::class, 'dataCourse']);

});

//prefix bab
Route::prefix('bab')->group(function () {
    Route::post('store', [babController::class, 'store']);
    Route::post('index', [babController::class, 'index']);
    Route::get('show/{id}', [babController::class, 'show']);
    Route::put('update/{id}', [babController::class, 'update']);
    Route::delete('destroy/{id}', [babController::class, 'destroy']);
});

//prefix materi
Route::prefix('materi')->group(function () {
    Route::post('store', [materiController::class, 'store']);
    //list materi by bab_id
    Route::get('index/{bab_id}', [materiController::class, 'index']);
    //show materi by id
    Route::get('show/{id}', [materiController::class, 'show']);
    //update materi by id
    Route::post('update/{id}', [materiController::class, 'update']);
    //delete materi by id
    Route::delete('destroy/{id}', [materiController::class, 'destroy']);
});

//prefix kuis
Route::prefix('kuis')->group(function () {
    Route::post('store', [kuisController::class, 'store']);
    Route::get('index/{materi_id}', [kuisController::class, 'index']);
    //show 1 soal kuis
    Route::get('show/{id}', [kuisController::class, 'show']);
    //update kuis (post )
    Route::post('update/{id}', [kuisController::class, 'update']);
    //delete kuis
    Route::delete('destroy/{id}', [kuisController::class, 'destroy']);
});

//prefix jawaban
Route::prefix('jawaban')->group(function () {
    Route::post('store', [jawabanController::class, 'store']);
    Route::get('index/{kuis_id}', [jawabanController::class, 'index']);
    //ubah ke benar
    Route::get('benar/{id}', [jawabanController::class, 'benar']);
    //destroy jawaban
    Route::delete('destroy/{id}', [jawabanController::class, 'destroy']);
});

//prefix payment
Route::prefix('payment')->group(function () {
    Route::post('store', [paymentController::class, 'store']);
    Route::get('tagihan', [paymentController::class, 'tagihan']);
    //invoice view
    Route::get('invoice/{invoice}', [paymentController::class, 'invoice']);
    Route::get('index/{id}', [paymentController::class, 'index']);
    Route::get('show/{id}', [paymentController::class, 'show']);
    Route::post('update/{id}', [paymentController::class, 'update']);
    Route::delete('destroy/{id}', [paymentController::class, 'destroy']);
});

