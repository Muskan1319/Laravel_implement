<?php

use App\Http\Controllers\EmployeeController;
// use App\Http\Controllers\auth\ResetPasswordController;
// use App\Http\Controllers\auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotResetPasswordController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
//middleware implementation
Route::middleware('adminAccess')->group(function(){
Route::get('/employees',[EmployeeController::class,'index'])->name('employees.index');
Route::get('/employees/create',[EmployeeController::class,'create'])->name('employees.create');
Route::post('/employees',[EmployeeController::class,'store'])->name('employees.store');
Route::get('/employees/{employee}/edit',[EmployeeController::class,'edit'])->name('employees.edit');
Route::put('/employees/{employee}',[EmployeeController::class,'update'])->name('employees.update');
Route::get('/employees/{employee}',[EmployeeController::class,'destroy'])->name('employees.destroy')->withTrashed();
Route::get('/archive',[EmployeeController::class,'archive'])->name('employees.archive');
Route::get('/restore/{id?}',[EmployeeController::class,'restore'])->name('employees.restore')->withTrashed();
Route::get('/export-employee',[EmployeeController::class,'exportEmployee'])->name('export.employee');

Route::get('/user',[UserController::class,'index'])->name('user.index');
Route::get('/status-update/{id}',[UserController::class,'status_update']);
});



Route::get('forget-password', [ForgotResetPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotResetPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotResetPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotResetPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');









