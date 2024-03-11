<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
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

Route::post('login',[LoginController::class,'loginUser']);

Route::group(['middleware' => 'auth:api'],function (){
   Route::get('students',[StudentController::class,'index']);
   Route::post('add-student',[StudentController::class,'addStudent']);
   Route::delete('students/{id}',[StudentController::class,'deleteStudent']);

   Route::get('logout',[LoginController::class,'logout']);
});