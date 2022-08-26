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
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\CvController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AlumnusController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MaterialDisbursalController;

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
Route::get('/cv/search/citizen-id/{citizenId}', [CvController::class, 'citizenSearch']);
Route::post('/cv/new', [CvController::class, 'store']);
Route::post('/cv/update/{id}', [CvController::class, 'update']);

//? Alumni route
Route::get('/alumnus', [AlumnusController::class, 'index']); //? Paginate
Route::get('/alumni/show/{id}', [AlumnusController::class, 'show']);
Route::post('/alumni/new', [AlumnusController::class, 'store']);
Route::post('/alumni/update/{id}', [AlumnusController::class, 'update']);
Route::get('/alumni/search/{keyword}', [AlumnusController::class, 'search']); //? Paginate
Route::post('/alumni/delete/{id}', [AlumnusController::class, 'delete']);

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

//? News route for web and mobile app
Route::get('/news/show/{id}', [InformationController::class, 'show']); //? For public
Route::get('/news/limit/{number}', [InformationController::class, 'newsLimit']); //? Limit

//? News route for web
Route::get('/news', [InformationController::class, 'index']); //? Paginate (For public)
Route::get('/news/private', [InformationController::class, 'indexPrivate']); //? Paginate (For private)
Route::get('/news/show/private/{id}', [InformationController::class, 'showPrivate']); //? For private for dashboard
Route::get('/news/search/{keyword}', [InformationController::class, 'search']); //? Paginate (For public)
Route::get('/news/search/private/{keyword}', [InformationController::class, 'searchPrivate']); //? Paginate (For private for dashboard)
Route::post('/news/new', [InformationController::class, 'store']);
Route::post('/news/update/{id}', [InformationController::class, 'update']);
Route::post('/news/delete/{id}', [InformationController::class, 'delete']);

//? News route for mobile app
Route::get('/news/all', [InformationController::class, 'indexAll']); //? Get all
Route::get('/news/search/all/{keyword}', [InformationController::class, 'searchAll']); //? Get all

//? Official Document route
Route::get('/documents', [DocumentController::class, 'index']); //? Public (Paginate)
Route::get('/documents/private', [DocumentController::class, 'indexPrivate']); //? Private (Paginate)
Route::get('/document/show/{id}', [DocumentController::class, 'show']); //? Private (For dashboard)
Route::post('/document/new', [DocumentController::class, 'store']);
Route::post('/document/update/{id}', [DocumentController::class, 'update']);
Route::get('/document/search/{keyword}', [DocumentController::class, 'search']); //? Public (Paginate)
Route::get('/document/search/private/{keyword}', [DocumentController::class, 'searchPrivate']); //? Private (Paginate)
Route::post('/document/delete/{id}', [DocumentController::class, 'delete']);

//? Activity route
Route::get('/activities', [ActivityController::class, 'index']); //? Public (Paginate)
Route::get('/activities/private', [ActivityController::class, 'indexPrivate']); //? Private (Paginate)
Route::get('/activity/limit/{number}', [ActivityController::class, 'limit']); //? Limit
Route::get('/activity/show/{id}', [ActivityController::class, 'showRead']); //? For Read
Route::get('/activity/show/update/{id}', [ActivityController::class, 'showUpdate']); //? For update
Route::get('/activity/search/{keyword}', [ActivityController::class, 'search']); //? Public (Paginate)
Route::get('/activity/search/private/{keyword}', [ActivityController::class, 'searchPrivate']); //? Private (Paginate)
Route::post('/activity/new', [ActivityController::class, 'store']);
Route::post('/activity/update/{id}', [ActivityController::class, 'update']);
Route::post('/activity/delete/{id}', [ActivityController::class, 'delete']);

//? Classroom route
Route::get('/classrooms', [ClassroomController::class, 'index']); //? Paginate
Route::get('/classroom/show/{id}', [ClassroomController::class, 'show']);
Route::post('/classroom/new', [ClassroomController::class, 'store']);
Route::post('/classroom/update/{id}', [ClassroomController::class, 'update']);
Route::get('/classroom/search/{keyword}', [ClassroomController::class, 'search']); //? Paginate
Route::get('/classroom/filter/room-type/{roomType}', [ClassroomController::class, 'filterRoomType']); //? Show on public pages
Route::post('/classroom/delete/{id}', [ClassroomController::class, 'delete']);

//? Material route
Route::get('/materials', [MaterialController::class, 'index']); //? Paginate (Public)
Route::get('/materials/private', [MaterialController::class, 'indexPrivate']); //? Paginate (Private)
Route::get('/material/show/{id}', [MaterialController::class, 'show']); //? Show material in stock
Route::get('/material/show/update/{id}', [MaterialController::class, 'showUpdate']); //? Show for update
Route::get('/material/search/{keyword}', [MaterialController::class, 'search']); //? Paginate (Public)
Route::get('/material/search/private/{keyword}', [MaterialController::class, 'searchPrivate']); //? Paginate (Private)
Route::post('/material/new', [MaterialController::class, 'store']);
Route::post('/material/update/{id}', [MaterialController::class, 'update']);
Route::post('/material/delete/{id}', [MaterialController::class, 'delete']);

//? Metarial disbursal route
Route::get('/materials/disbursals', [MaterialDisbursalController::class, 'index']); //? Paginate
Route::get('/material/disbursal/search/{keyword}', [MaterialDisbursalController::class, 'search']); //? Paginate
Route::get('/material/disbursal/filter/{citizen_id}', [MaterialDisbursalController::class, 'filterByCitizenId']);
Route::post('/material/disbursal/new', [MaterialDisbursalController::class, 'store']);
Route::post('/material/disbursal/delete/{id}', [MaterialDisbursalController::class, 'delete']);

//? Project library route
Route::get('/projects', [ProjectController::class, 'index']); //? Paginate
Route::get('/project/show/{id}', [ProjectController::class, 'show']); //? Show for update
Route::get('/project/show/read/{id}', [ProjectController::class, 'showRead']); //? Show for read
Route::post('/project/new', [ProjectController::class, 'store']);
Route::post('/project/update/{id}', [ProjectController::class, 'update']);
Route::get('/project/search/{keyword}', [ProjectController::class, 'search']); //? Paginate
Route::post('/project/delete/{id}', [ProjectController::class, 'delete']);

//? Equipment route

//? Equipment borrow route

//? Maintenance route

//? Middleware group
Route::middleware('auth:sanctum')->group(function () {
    //? Auth middleware route
    Route::get('/auth/user', [AuthController::class, 'show']);
    Route::post('/auth/signout', [AuthController::class, 'signout']);
});
