<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\passportAuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\RoomsClassController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ClientAdvertisementController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategorysController;
use App\Http\Controllers\FQAController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
| API routes for the application.
*/

Route::post('register', [passportAuthController::class, 'register']);
Route::post('login', [passportAuthController::class, 'login']);
Route::post('logout', [passportAuthController::class, 'logout'])->middleware('auth:api');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/email/verify', [VerificationController::class, 'verifyEmail']);


Route::middleware(['auth:api'])->group(function () {



    //rate
    Route::post('home', [HomeController::class, 'index_api'])->name('home');

    Route::post('patients', [HomeController::class, 'patients'])->name('patients');

    Route::post('/rate', [RateController::class, 'store_api']);


    Route::post('/review', [ReviewController::class, 'store']);


    // categories
    Route::post('get_categories', [CategorysController::class, 'index_api']);
    Route::post('categories', [CategorysController::class, 'store_api']);
    Route::get('categories/{id}', [CategorysController::class, 'show_api']);
    Route::post('categories/{id}', [CategorysController::class, 'update_api']);
    Route::delete('categories/{id}', [CategorysController::class, 'destroy_api']);





    // Appointments
    Route::get('/appointments/trash', [AppointmentsController::class, 'trash_api']);
    Route::post('/appointments/appointments_facility', [AppointmentsController::class, 'appointments_facility']);
    Route::post('/appointments/my_appointments', [AppointmentsController::class, 'my_appointments']);
    Route::get('/appointments/user', [AppointmentsController::class, 'index_api']);
    Route::post('/appointments', [AppointmentsController::class, 'store_api']);
    Route::post('/appointments_history', [AppointmentsController::class, 'history']);
    Route::get('/appointments/{id}', [AppointmentsController::class, 'show_api']);
    Route::put('/appointments/{id}', [AppointmentsController::class, 'update_api']);
    Route::delete('/appointments/{id}', [AppointmentsController::class, 'destroy_api']);
    Route::post('/appointments/{id}/restore', [AppointmentsController::class, 'restore_api']);
    Route::delete('/appointments/{id}/force-delete', [AppointmentsController::class, 'delete_api']);



    // rooms_type
    Route::get('rooms_type2', [RoomTypeController::class, 'test']);
    Route::post('get_rooms_type', [RoomTypeController::class, 'index_api']);
    Route::post('rooms_type', [RoomTypeController::class, 'store_api']);
    Route::post('rooms_type/{id}', [RoomTypeController::class, 'update_api']);
    Route::delete('rooms_type/{id}', [RoomTypeController::class, 'destroy_api']);



    // Client Advertisements
    Route::get('clientAdvertisements', [ClientAdvertisementController::class, 'index_api']);
    Route::post('clientAdvertisements', [ClientAdvertisementController::class, 'store_api']);
    Route::get('clientAdvertisements/trash', [ClientAdvertisementController::class, 'trash_api']);
    Route::post('clientAdvertisements/{id}/restore', [ClientAdvertisementController::class, 'restore_api']);
    Route::delete('clientAdvertisements/{id}/force-delete', [ClientAdvertisementController::class, 'forceDelete_api']);
        Route::put('clientAdvertisements/{id}', [ClientAdvertisementController::class, 'update_api']);




    // Rooms Class
    Route::get('/roomsClass/trash', [RoomsClassController::class, 'trash_api']);
    Route::post('/get_roomsClass', [RoomsClassController::class, 'index_api']);
    Route::post('/roomsClass', [RoomsClassController::class, 'store_api']);
    Route::get('/roomsClass/{id}', [RoomsClassController::class, 'show_api']);
    Route::put('/roomsClass/{id}', [RoomsClassController::class, 'update_api']);
    Route::delete('/roomsClass/{id}', [RoomsClassController::class, 'destroy_api']);
    Route::post('/roomsClass/{id}/restore', [RoomsClassController::class, 'restore_api']);
    Route::delete('/roomsClass/{id}/force-delete', [RoomsClassController::class, 'delete_api']);

    // Rooms
    Route::get('/rooms/trash', [RoomController::class, 'trash_api']);
    Route::get('/room_type', [RoomController::class, 'room_type_api']);
    Route::put('/rooms/{id}', [RoomController::class, 'update_api']);
    Route::get('/rooms', [RoomController::class, 'index_api']);
    Route::post('/rooms', [RoomController::class, 'store_api']);
    Route::get('/rooms/{id}', [RoomController::class, 'show_api']);
    Route::delete('/rooms/{id}', [RoomController::class, 'delete_api']);
    Route::post('/rooms/{id}/restore', [RoomController::class, 'restore_api']);

    // Hospitals
    Route::get('/hospitals/trash', [HospitalController::class, 'trash_api']);
    Route::get('/hospitals', [HospitalController::class, 'index_api']);
    Route::post('/hospitals', [HospitalController::class, 'store_api']);
    Route::get('/hospitals/{id}', [HospitalController::class, 'show_api']);
    Route::put('/hospitals/{id}', [HospitalController::class, 'update_api']);
    Route::delete('/hospitals/{id}', [HospitalController::class, 'destroy_api']);
    Route::post('/hospitals/{id}/restore', [HospitalController::class, 'restore_api']);
    Route::delete('/hospitals/{id}/force-delete', [HospitalController::class, 'delete_api']);

    // Doctors
    Route::get('/doctors/trash', [DoctorsController::class, 'trash_api']);
    Route::post('/get_doctors', [DoctorsController::class, 'index_api']);
    Route::post('/doctors', [DoctorsController::class, 'store_api']);
    Route::post('/get_doctors/{id}', [DoctorsController::class, 'show_api']);
    Route::post('/doctors/{id}', [DoctorsController::class, 'update_api']);
    Route::delete('/doctors/{id}', [DoctorsController::class, 'destroy_api']);
    Route::post('/doctors/{id}/restore', [DoctorsController::class, 'restore_api']);
    Route::delete('/doctors/{id}/force-delete', [DoctorsController::class, 'delete_api']);



    // profiles
    Route::get('/profile/trash', [ProfileController::class, 'trash_api']);
    Route::get('/profile', [ProfileController::class, 'index_api']);
    Route::post('/profile', [ProfileController::class, 'store_api']);
    Route::get('/profile/{id}', [ProfileController::class, 'show_api']);
    Route::post('/profile/{id}', [ProfileController::class, 'update_api']);
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy_api']);
    Route::post('/profile/{id}/restore', [ProfileController::class, 'restore_api']);
    Route::delete('/profile/{id}/force-delete', [ProfileController::class, 'delete_api']);



    // cart
    Route::get('/cart/trash', [CartController::class, 'trash_api']);
    Route::get('/cart/user/{id}', [CartController::class, 'index_api']);
    Route::post('/cart/facility', [CartController::class, 'index_api_facility']);
    Route::post('/cart/get_my_orders', [CartController::class, 'get_my_orders']);
    Route::post('/cart/get_my_orders_user', [CartController::class, 'get_my_orders_user']);
    Route::post('/cart', [CartController::class, 'store_api']);
    Route::get('/cart/{id}', [CartController::class, 'show_api']);
    Route::put('/cart/{id}', [CartController::class, 'update_api']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy_api']);
    Route::post('/cart/{id}/restore', [CartController::class, 'restore_api']);
    Route::delete('/cart/{id}/force-delete', [CartController::class, 'delete_api']);


    // Specializations
    Route::get('/specializations/trash', [SpecializationController::class, 'trash_api']);
    Route::post('/get_specializations', [SpecializationController::class, 'index_api']);
    Route::post('/specializations', [SpecializationController::class, 'store_api']);
    Route::get('/specializations/{id}', [SpecializationController::class, 'show_api']);
    Route::delete('/specializations/{id}', [SpecializationController::class, 'destroy_api']);
    Route::post('/specializations/{id}', [SpecializationController::class, 'update_api']);
    Route::post('/specializations/{id}/restore', [SpecializationController::class, 'restore_api']);
    Route::delete('/specializations/{id}/force-delete', [SpecializationController::class, 'delete_api']);

    // Analyses
    Route::get('/analysis/trash', [AnalysisController::class, 'trash_api']);
    Route::post('/get_analysis', [AnalysisController::class, 'index_api']);
    Route::post('/analysis', [AnalysisController::class, 'store_api']);
    Route::get('/analysis/{id}', [AnalysisController::class, 'show_api']);
    Route::post('/analysis/{id}', [AnalysisController::class, 'update_api']);
    Route::delete('/analysis/{id}', [AnalysisController::class, 'destroy_api']);
    Route::post('/analysis/{id}/restore', [AnalysisController::class, 'restore_api']);
    Route::delete('/analysis/{id}/force-delete', [AnalysisController::class, 'delete_api']);



    // operations
    Route::get('/operations/trash', [OperationsController::class, 'trash_api']);
    Route::post('/get_operations', [OperationsController::class, 'index_api']);
    Route::post('/operations', [OperationsController::class, 'store_api']);
    Route::get('/operations/{id}', [OperationsController::class, 'show_api']);
    Route::post('/operations/{id}', [OperationsController::class, 'update_api']);
    Route::delete('/operations/{id}', [OperationsController::class, 'destroy_api']);
    Route::post('/operations/{id}/restore', [OperationsController::class, 'restore_api']);
    Route::delete('/operations/{id}/force-delete', [OperationsController::class, 'delete_api']);

    

    // Employees
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy_api']);
    Route::get('/employees/trash', [EmployeeController::class, 'trash_api']);
    Route::get('/employees', [EmployeeController::class, 'index_api']);
    Route::post('/employees', [EmployeeController::class, 'store_api']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show_api']);
    Route::put('/employees/{employee}', [EmployeeController::class, 'update_api']);
    Route::post('/employees/{id}/restore', [EmployeeController::class, 'restore_api']);
    Route::delete('/employees/{id}/force-delete', [EmployeeController::class, 'delete_api']);





    // FQA

    Route::get('/FQA/index/', [FQAController::class, 'index_api']);

    Route::post('/FQA', [FQAController::class, 'store_api']);
    Route::get('/FQA/{id}', [FQAController::class, 'show_api']);
    Route::put('/FQA/{id}', [FQAController::class, 'update_api']);
    Route::get('/FQA/trash', [FQAController::class, 'trash_api']);
    Route::delete('/FQA/{id}', [FQAController::class, 'destroy_api']);
    Route::post('/FQA/{id}/restore', [FQAController::class, 'restore_api']);
    Route::delete('/FQA/{id}/force-delete', [FQAController::class, 'delete_api']);



    // Stocks


    Route::get('/stocks/trash', [StockController::class, 'trash_api']);
    Route::get('/stocks/prodcut_facility', [StockController::class, 'prodcut_facility']);
    Route::post('/stocks', [StockController::class, 'store_api']);
    Route::get('/stocks/{id}', [StockController::class, 'show_api']);
    Route::put('/stocks/{id}', [StockController::class, 'update_api']);
    Route::delete('/stocks/{id}', [StockController::class, 'destroy_api']);
    Route::get('/stocks/index/{id}', [StockController::class, 'index_api']);
    Route::post('/stocks/{id}/restore', [StockController::class, 'restore_api']);
    Route::delete('/stocks/{id}/force-delete', [StockController::class, 'delete_api']);




    // Departments
    Route::get('/departments/trash', [DepartmentController::class, 'trash_api']);
    Route::get('/departments', [DepartmentController::class, 'index_api']);
    Route::post('/departments', [DepartmentController::class, 'store_api']);
    Route::get('/departments/{id}', [DepartmentController::class, 'show_api']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update_api']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy_api']);
    Route::post('/departments/{id}/restore', [DepartmentController::class, 'restore_api']);
    Route::delete('/departments/{id}/force-delete', [DepartmentController::class, 'delete_api']);

    // Facilities
    Route::get('/facilities/{id}/list', [FacilityController::class, 'apiIndex'])->name('facilities.apiIndex');
    Route::get('/facilities/{id}', [FacilityController::class, 'apiShow'])->name('facilities.show');
    Route::post('/facilities', [FacilityController::class, 'apiStore'])->name('facilities.store');
    Route::put('/facilities/{id}', [FacilityController::class, 'apiUpdate'])->name('facilities.update');
    Route::delete('/facilities/{id}', [FacilityController::class, 'apiDelete'])->name('facilities.delete');
});
