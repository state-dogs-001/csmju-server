<?php

use Illuminate\Support\Facades\Route;

//? Import Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CheckSigninController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\PersonnelController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\SubjectResidualController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\CvController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AlumnusController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MaterialDisbursalController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\ComplainController;

//? Auth route
Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/signin', [AuthController::class, 'signin']);

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

//? Metarial disbursal route
Route::get('/materials/disbursals', [MaterialDisbursalController::class, 'index']); //? Paginate
Route::get('/material/disbursal/search/{keyword}', [MaterialDisbursalController::class, 'search']); //? Paginate
Route::get('/material/disbursal/filter/{citizen_id}', [MaterialDisbursalController::class, 'filterByCitizenId']);
Route::post('/material/disbursal/new', [MaterialDisbursalController::class, 'store']);
Route::post('/material/disbursal/delete/{id}', [MaterialDisbursalController::class, 'delete']);

//? Equipment borrow route

//? Maintenance route

//? Middleware group
Route::middleware('auth:sanctum')->group(function () {
    //? Auth middleware route
    Route::get('/auth/user', [AuthController::class, 'show']);
    Route::post('/auth/signout', [AuthController::class, 'signout']);

    //? CheckSignin route
    Route::get('/checksignin/users', [CheckSigninController::class, 'index']); //? Paginate
    Route::post('/checksignin/new', [CheckSigninController::class, 'store']);

    //? Personnel route
    Route::get('/personnels', [PersonnelController::class, 'index']); //? Paginate
    Route::get('/personnels/all', [PersonnelController::class, 'indexAll']); //? Personnels status work = 1
    Route::get('/personnel/show/{id}', [PersonnelController::class, 'show']);
    Route::get('/personnel/show/update/{id}', [PersonnelController::class, 'showUpdate']);
    Route::post('/personnel/new', [PersonnelController::class, 'store']);
    Route::post('/personnel/update/{id}', [PersonnelController::class, 'update']);
    Route::get('/personnel/search/{keyword}', [PersonnelController::class, 'search']); //? Paginate
    Route::get('/personnel/filter/teacher', [PersonnelController::class, 'filterTeacher']);
    Route::get('/personnel/filter/staff', [PersonnelController::class, 'filterStaff']);
    Route::get('/personnel/search/citizen-id/{citizenId}', [PersonnelController::class, 'citizenSearch']);
    Route::get('/personnel/status', [PersonnelController::class, 'personnelStatus']);
    Route::post('/personnel/delete/{id}', [PersonnelController::class, 'delete']);

    //? Student route
    Route::get('/students', [StudentController::class, 'index']); //? Paginate
    Route::get('/student/show/{id}', [StudentController::class, 'show']);
    Route::post('/student/new', [StudentController::class, 'store']);
    Route::post('/student/update/{id}', [StudentController::class, 'update']);
    Route::get('/student/search/{keyword}', [StudentController::class, 'search']); //? Paginate
    Route::get('/student/search/citizen-id/{citizenId}', [StudentController::class, 'citizenSearch']);
    Route::post('/student/delete/{id}', [StudentController::class, 'delete']);
    Route::get('/student/count', [StudentController::class, 'count']);

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
    Route::get('/subject/count', [SubjectController::class, 'count']);

    //? Residual route
    Route::get('/residuals', [SubjectResidualController::class, 'index']); //? Paginate
    Route::post('/residual/new', [SubjectResidualController::class, 'store']);
    Route::post('/residual/update/status/{id}', [SubjectResidualController::class, 'updateStatus']);
    Route::get('/residual/show/update/{id}', [SubjectResidualController::class, 'residualForUpdate']);
    Route::get('/residual/show/{id}', [SubjectResidualController::class, 'residualForShow']);
    Route::get('/residual/personnel/{citizenId}', [SubjectResidualController::class, 'searchByPersonnelCitizenId']);
    Route::get('/residual/student/{citizenId}', [SubjectResidualController::class, 'searchByStudentCitizenId']);
    Route::post('/residual/datesfilter', [SubjectResidualController::class, 'datesFilter']);
    Route::post('/residual/search', [SubjectResidualController::class, 'searchByKeyword']);

    //? Room route
    Route::get('/rooms', [RoomController::class, 'index']); //? Paginate
    Route::get('/rooms/all', [RoomController::class, 'indexAll']); //? Use for select
    Route::get('/room/show/{id}', [RoomController::class, 'show']); //? Show Read
    Route::get('/room/show/update/{id}', [RoomController::class, 'showUpdate']); //? Show Update
    Route::get('/room/search/{keyword}', [RoomController::class, 'search']); //? Paginate
    Route::get('/room/lab', [RoomController::class, 'labRoom']);
    Route::get('/room/lecture', [RoomController::class, 'lectureRoom']);
    Route::post('/room/new', [RoomController::class, 'store']);
    Route::post('/room/update/{id}', [RoomController::class, 'update']);
    Route::post('/room/delete/{id}', [RoomController::class, 'delete']);
    Route::get('/room/type', [RoomController::class, 'typeRoom']); //? Use for select
    Route::get('/room/building', [RoomController::class, 'building']); //? Use for select

    //? Equipment route
    Route::get('/equipments', [EquipmentController::class, 'index']); //? Paginate
    Route::get('/equipment/show/{id}', [EquipmentController::class, 'show']); //? Show Read
    Route::get('/equipment/show/update/{id}', [EquipmentController::class, 'showUpdate']); //? Show Update
    Route::post('/equipment/search', [EquipmentController::class, 'search']); //? Paginate
    Route::get('/equipment/status', [EquipmentController::class, 'equipmentStatus']);
    Route::post('/equipment/new', [EquipmentController::class, 'store']);
    Route::post('/equipment/update/{id}', [EquipmentController::class, 'update']);
    Route::post('/equipment/delete/{id}', [EquipmentController::class, 'delete']);

    //? Project library route
    Route::get('/projects', [ProjectController::class, 'index']); //? Paginate
    Route::get('/project/show/{id}', [ProjectController::class, 'show']); //? Show for update
    Route::get('/project/show/read/{id}', [ProjectController::class, 'showRead']); //? Show for read
    Route::post('/project/new', [ProjectController::class, 'store']);
    Route::post('/project/update/{id}', [ProjectController::class, 'update']);
    Route::post('/project/search', [ProjectController::class, 'search']); //? Paginate
    Route::post('/project/delete/{id}', [ProjectController::class, 'delete']);

    //? Banners route
    Route::get('/banners', [BannerController::class, 'indexPublic']); //? Public
    Route::get('/banners/private', [BannerController::class, 'index']); //? Private (Paginate)
    Route::get('/banner/show/{id}', [BannerController::class, 'show']);
    Route::post('/banner/new', [BannerController::class, 'store']);
    Route::post('/banner/update/{id}', [BannerController::class, 'update']);
    Route::post('/banner/delete/{id}', [BannerController::class, 'delete']);
    Route::get('/banner/count', [BannerController::class, 'count']);

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
    Route::get('/news/search/all/{keyword}', [InformationController::class, 'searchAll']);

    //? Official Document route
    Route::get('/documents', [DocumentController::class, 'index']); //? Public (Paginate)
    Route::get('/documents/private', [DocumentController::class, 'indexPrivate']); //? Private (Paginate)
    Route::get('/document/show/{id}', [DocumentController::class, 'show']); //? Private (For dashboard)
    Route::post('/document/new', [DocumentController::class, 'store']);
    Route::post('/document/update/{id}', [DocumentController::class, 'update']);
    Route::post('/document/search/{keyword}', [DocumentController::class, 'search']); //? Public (Paginate)
    Route::post('/document/search/private/{keyword}', [DocumentController::class, 'searchPrivate']); //? Private (Paginate)
    Route::post('/document/delete/{id}', [DocumentController::class, 'delete']);

    //? Complain route
    Route::get('/complains', [ComplainController::class, 'index']); //? Paginate
    Route::get('/complain/show/{id}', [ComplainController::class, 'show']);
    Route::post('/complain/new', [ComplainController::class, 'store']);
    Route::post('/complain/delete/{id}', [ComplainController::class, 'delete']);

    //? CV route
    Route::get('/cv/search/citizen-id/{citizenId}', [CvController::class, 'citizenSearch']);
    Route::post('/cv/new', [CvController::class, 'store']);
    Route::post('/cv/update/{id}', [CvController::class, 'update']);

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
});
