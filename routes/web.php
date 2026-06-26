<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\MyMiddleware;
use App\Http\Controllers\MyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;




//Route::get('/userpage', [DashboardController::class, 'index']);

Route::any("/adminpage", "App\Http\Controllers\MyController@ProsesAdmin");


Route::middleware(["mymiddleware:admin"])->group(function(){
	Route::view("/main","mainpage");
    
    // --- ADMIN ROUTES ---
    Route::get('/admin/services', [\App\Http\Controllers\AdminController::class, 'manageDevices']);
    Route::post('/admin/services/add', [\App\Http\Controllers\AdminController::class, 'addDevice']);
    Route::post('/admin/services/delete/{id}', [\App\Http\Controllers\AdminController::class, 'deleteDevice']);
    
    // --- ADMIN MANAGE USERS ---
    Route::get('/manageuser', [\App\Http\Controllers\AdminController::class, 'manageUsers']);
    Route::post('/admin/users/role/{id}', [\App\Http\Controllers\AdminController::class, 'updateUserRole']);
    Route::post('/admin/users/delete/{id}', [\App\Http\Controllers\AdminController::class, 'deleteUser']);
    
    Route::get('/admin/manage-iot', [\App\Http\Controllers\AdminController::class, 'iotDataLog']);
    Route::get('/admin/reports', [\App\Http\Controllers\AdminController::class, 'systemReports']);
    	
});

Route::middleware(["mymiddleware:user"])->group(function(){
	//Route::view("/main","mainpage");
	Route::get('/userpage', [DashboardController::class, 'index']);
	Route::view("/userprofile","user/profile");
	Route::view("/picture","user/picture"); 
	
    Route::get('/dashboard/live-data', [DashboardController::class, 'liveData']);
    
    Route::post('/save-profile', [AuthController::class, 'saveProfile']);
    Route::post('/picture/upload', [\App\Http\Controllers\AuthController::class, 'uploadPicture']);
    Route::post('/picture/delete/{id}', [\App\Http\Controllers\AuthController::class, 'deletePicture']);
    Route::get('/location', [\App\Http\Controllers\GpsController::class, 'showLocationMap']);
    // --- USER HISTORY ROUTE ---
Route::get('/history', [\App\Http\Controllers\DashboardController::class, 'historyLog']);
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route to show the visual "Are you sure?" logout screen
Route::view('/logout-confirm', 'logout');


/*
Route::post("/login-proses", 
"App\Http\Controllers\MyController@ProsesLogin");

Route::get("/logout", function(){
	Session::forget("username");
});

Route::get("/login", function(){
    return view("login");
});

// Add these for Registration:
Route::get('/register', [MyController::class, 'register']);
Route::post('/register-proses', [MyController::class, 'registerProses']);

// 1. Route to show the "Are you sure?" page
Route::get('/logout', [MyController::class, 'logoutConfirm']);

// 2. Route to actually destroy the session
Route::get('/logout-perform', [MyController::class, 'logoutPerform']);


//
Route::get('/student/{name?}', function ($name="") {
	return view("modul1/studentpage",[
		"studentname" => $name
	]);
});

//Route::get('/logout', [MyController::class, 'logout']);
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('aboutpage');
});

Route::get('/service', function () {
    return view('servicepage');
});

Route::view('/contact', 'contactpage');

