<?php

use Illuminate\Support\Facades\Route;

//? Import Models
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckSigninController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\PersonnelController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\SubjectResidualController;

//? Auth route
Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/signin', [AuthController::class, 'signin']);

//? CheckSignin route
Route::get('/checksignin/users', [CheckSigninController::class, 'index']); //? Paginate
Route::post('/checksignin/new', [CheckSigninController::class, 'store']);

//? Student route
Route::get('/students', [StudentController::class, 'index']); //? Paginate
Route::get('/student/show/{id}', [StudentController::class, 'show']);
Route::post('/student/new', [StudentController::class, 'store']);
Route::post('/student/update/{id}', [StudentController::class, 'update']);
Route::get('/student/search/{keyword}', [StudentController::class, 'search']); //? Paginate
Route::post('/student/delete/{id}', [StudentController::class, 'delete']);

//? Personnel route
Route::get('/personnels', [PersonnelController::class, 'index']); //? Paginate
Route::get('/personnel/show/{id}', [PersonnelController::class, 'show']);
Route::post('/personnel/new', [PersonnelController::class, 'store']);
Route::post('/personnel/update/{id}', [PersonnelController::class, 'update']);
Route::get('/personnel/search/{keyword}', [PersonnelController::class, 'search']); //? Paginate
Route::post('/personnel/delete/{id}', [PersonnelController::class, 'delete']);

//? CV route

//? Alumni route

//? Subject route
Route::get('/subjects', [SubjectController::class, 'index']); //? Paginate
Route::get('/subject/show/{id}', [SubjectController::class, 'show']);
Route::post('/subject/new', [SubjectController::class, 'store']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/search/{keyword}', [SubjectController::class, 'search']); //? Paginate
Route::get('/subject/filter/term/{term}', [SubjectController::class, 'termFilter']);
Route::get('/subject/filter/detail/{detail}', [SubjectController::class, 'detailFilter']);
Route::post('/subject/delete/{id}', [SubjectController::class, 'delete']);

//? Residual route
Route::get('/residuals', [SubjectResidualController::class, 'index']); //? Paginate
Route::post('/residual/new', [SubjectResidualController::class, 'store']);
Route::post('/residual/update/status/{id}', [SubjectResidualController::class, 'updateStatus']);
Route::get('/residual/show/update/{id}', [SubjectResidualController::class, 'residualForUpdate']);
Route::get('/residual/show/{id}', [SubjectResidualController::class, 'residualForShow']);

//? Banners route
Route::get('/banners', [BannerController::class, 'indexPublic']); //? Public
Route::get('/banners/private', [BannerController::class, 'index']); //? Private (Paginate)
Route::get('/banner/show/{id}', [BannerController::class, 'show']);
Route::post('/banner/new', [BannerController::class, 'store']);
Route::post('/banner/update/{id}', [BannerController::class, 'update']);
Route::post('/banner/delete/{id}', [BannerController::class, 'delete']);

//? News route

//? News route for mobile app

//? Activity route

//? Project research route

//? Middleware group
Route::middleware('auth:sanctum')->group(function () {
    //? Auth middleware route
    Route::get('/auth/user', [AuthController::class, 'show']);
    Route::post('/auth/signout', [AuthController::class, 'signout']);
});
