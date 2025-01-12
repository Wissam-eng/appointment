<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomsClassController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\passportAuthController;
use App\Http\Controllers\ClientAdvertisementController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategorysController;
use App\Http\Controllers\FQAController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;
// Default route



Route::get('/', function () {
    return view('login_reg');
    // return view('login');
    // return view('welcome');
});



Route::get('/welcome', function () {
    return view('welcome');
});



Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');


Auth::routes(['verify' => true]);


Route::resource('categories', CategorysController::class);

// appointments routes

Route::get('/appointments/trash', [AppointmentsController::class, 'trash'])->name('appointments.trash');
Route::resource('appointments', AppointmentsController::class);
Route::post('/appointments/{id}/restore', [AppointmentsController::class, 'restore'])->name('appointments.restore');
Route::delete('/appointments/{id}/delete', [AppointmentsController::class, 'delete'])->name('appointments.delete');

// Auth::routes();

Route::post('/force-logout', [LoginController::class, 'forceLogout'])->name('forceLogout');


// Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');
Route::get('/home', [HomeController::class, 'index'])->name('home');


// Route::get('/home', [HospitalController::class, 'index2'])->name('home');


//clientAdvertisements
Route::get('clientAdvertisements/trash', [ClientAdvertisementController::class, 'trash'])->name('clientAdvertisements.trash');
Route::post('clientAdvertisements/{id}/restore', [ClientAdvertisementController::class, 'restore'])->name('clientAdvertisements.restore');
Route::delete('clientAdvertisements/{id}/force-delete', [ClientAdvertisementController::class, 'forceDelete'])->name('clientAdvertisements.forceDelete');
Route::resource('clientAdvertisements', ClientAdvertisementController::class);



//rooms_type
Route::resource('rooms_type', RoomTypeController::class);
Route::get('rooms_type/trash', [RoomTypeController::class, 'trash'])->name('clientAdvertisements.trash');
Route::post('rooms_type/{id}/restore', [RoomTypeController::class, 'restore'])->name('clientAdvertisements.restore');
Route::delete('rooms_type/{id}/force-delete', [RoomTypeController::class, 'forceDelete'])->name('clientAdvertisements.forceDelete');






// RoomsClass routes
Route::resource('roomsClass', RoomsClassController::class);
Route::get('/roomsClass/trash', [RoomsClassController::class, 'trash'])->name('roomsClass.trash');
Route::post('/roomsClass/{id}/restore', [RoomsClassController::class, 'restore'])->name('roomsClass.restore');
Route::delete('/roomsClass/{id}/delete', [RoomsClassController::class, 'delete'])->name('roomsClass.delete');




// Specialization routes
Route::get('/specializations/trash', [SpecializationController::class, 'trash'])->name('specializations.trash');
Route::resource('specializations', SpecializationController::class);
Route::post('/specializations/{id}/restore', [SpecializationController::class, 'restore'])->name('specializations.restore');
Route::delete('/specializations/{id}/delete', [SpecializationController::class, 'delete'])->name('specializations.delete');








// analysis routes

Route::get('/analysis/trash', [AnalysisController::class, 'trash'])->name('analysis.trash');
Route::post('/analysis/{id}/restore', [AnalysisController::class, 'restore'])->name('analysis.restore');
Route::delete('/analysis/{id}/delete', [AnalysisController::class, 'delete'])->name('analysis.delete');
Route::resource('analysis', AnalysisController::class);





// operations routes


Route::get('/operations/trash', [OperationsController::class, 'trash'])->name('operations.trash');
Route::post('/operations/{id}/restore', [OperationsController::class, 'restore'])->name('operations.restore');
Route::delete('/operations/{id}/delete', [OperationsController::class, 'delete'])->name('operations.delete');
Route::resource('operations', OperationsController::class);



// Room routes
Route::get('/rooms/trash', [RoomController::class, 'trash'])->name('rooms.trash');
Route::post('/rooms/{id}/restore', [RoomController::class, 'restore'])->name('rooms.restore');
Route::delete('/rooms/{id}/delete', [RoomController::class, 'delete'])->name('rooms.delete');
Route::resource('rooms', RoomController::class);

// Doctor routes
Route::get('/doctors.show_doctors/{id}', [DoctorsController::class, 'showDoctors'])->name('doctors.show_doctors');
Route::get('/doctors/trash', [DoctorsController::class, 'trash'])->name('doctors.trash');
Route::post('/doctors/{id}/restore', [DoctorsController::class, 'restore'])->name('doctors.restore');
Route::delete('/doctors/{id}/delete', [DoctorsController::class, 'delete'])->name('doctors.delete');
Route::patch('/doctors/{doctor}', [DoctorsController::class, 'update'])->name('doctors.update');
Route::resource('doctors', DoctorsController::class);




// profile routes
Route::get('/profile.myprofile/{id}', [ProfileController::class, 'myprofile'])->name('profile.myprofile');

Route::get('/profile.show_doctors/{id}', [ProfileController::class, 'showprofile'])->name('profile.show_profile');
Route::post('/profile/{id}/restore', [ProfileController::class, 'restore'])->name('profile.restore');
Route::delete('/profile/{id}/delete', [ProfileController::class, 'delete'])->name('profile.delete');
Route::patch('/profile/{doctor}', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/trash', [ProfileController::class, 'trash'])->name('profile.trash');
Route::resource('profile', ProfileController::class);


// cart routes
Route::post('/cart/{id}/restore', [CartController::class, 'restore'])->name('cart.restore');
Route::delete('/cart/{id}/delete', [CartController::class, 'delete'])->name('cart.delete');
Route::patch('/cart/{doctor}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/trash', [CartController::class, 'trash'])->name('cart.trash');
Route::resource('cart', CartController::class);


//FQA routes
// Route::get('/FQA.show_doctors/{id}', [FQAController::class, 'showprofile'])->name('FQA.show_profile');
Route::get('/FQA/trash', [FQAController::class, 'trash'])->name('FQA.trash');
Route::post('/FQA/{id}/restore', [FQAController::class, 'restore'])->name('FQA.restore');
Route::delete('/FQA/{id}/delete', [FQAController::class, 'delete'])->name('FQA.delete');
Route::patch('/FQA/{doctor}', [FQAController::class, 'update'])->name('FQA.update');
Route::resource('FQA', FQAController::class);


// stock routes
Route::get('/stock.show_doctors/{id}', [StockController::class, 'showprofile'])->name('stock.show_profile');
Route::post('/stock/{id}/restore', [StockController::class, 'restore'])->name('stock.restore');
Route::delete('/stock/{id}/delete', [StockController::class, 'delete'])->name('stock.delete');
Route::patch('/stock/{doctor}', [StockController::class, 'update'])->name('stock.update');
Route::get('/stock/trash', [StockController::class, 'trash'])->name('stock.trash');
Route::resource('stock', StockController::class);







// Hospital routes
Route::post('/hospitals/{id}/restore', [HospitalController::class, 'restore'])->name('hospitals.restore');
Route::delete('/hospitals/{id}/delete', [HospitalController::class, 'delete'])->name('hospitals.delete');
Route::get('/hospitals/trash', [HospitalController::class, 'trash'])->name('hospitals.trash');
Route::resource('hospitals', HospitalController::class);



Route::resource('review', ReviewController::class);




// facility routes
Route::get('/pharmacys/trash', [FacilityController::class, 'trash_pharmacys'])->name('facilities.trash_pharmacys');
Route::get('/facilities/injured', [FacilityController::class, 'injured'])->name('facilities.injured');
Route::get('/pharmacys', [FacilityController::class, 'pharmacys'])->name('facilities.pharmacys');
Route::get('/facilities/centers', [FacilityController::class, 'centers'])->name('facilities.centers');
Route::get('/facilities.hospitals', [FacilityController::class, 'hospitals'])->name('facilities.hospitals');
Route::get('/facilities.clinics', [FacilityController::class, 'clinics'])->name('facilities.clinics');
Route::get('/facilities.company', [FacilityController::class, 'company'])->name('facilities.company');
Route::get('/facilities/pharmacies', [FacilityController::class, 'pharmacies'])->name('facilities.pharmacies');


Route::get('facilities/trash', [FacilityController::class, 'trashed_hospital'])->name('facilities.trashed_hospital');
Route::post('/facilities/{id}/restore', [FacilityController::class, 'restore'])->name('facilities.restore');
Route::delete('/facilities/{id}/delete', [FacilityController::class, 'delete'])->name('facilities.delete');
Route::get('facilities.trash', [FacilityController::class, 'trash'])->name('facilities.trash');
Route::resource('facilities', FacilityController::class);




// Clinic routes
Route::get('/clinics/trash', [ClinicController::class, 'trash'])->name('clinics.trash');
Route::post('/clinics/{id}/restore', [ClinicController::class, 'restore'])->name('clinics.restore');
Route::delete('/clinics/{id}/delete', [ClinicController::class, 'delete'])->name('clinics.delete');
Route::resource('clinics', ClinicController::class);




// Employee routes
Route::resource('employees', EmployeeController::class);
Route::get('/employees/trash', [EmployeeController::class, 'trash'])->name('employees.trash');
Route::post('/employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::delete('/employees/{id}/delete', [EmployeeController::class, 'delete'])->name('employees.delete');

// Auth::routes();
