<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeProjectController;
use App\Http\Controllers\EmployeeController;

Route::post('/employees/{employee}/projects', [EmployeeProjectController::class, 'createProject']);
Route::post('/new-employee', [EmployeeProjectController::class, 'createEmployee']);
Route::post('/new-department', [EmployeeProjectController::class, 'createDepartment']);

Route::get('/employees', [EmployeeController::class, 'getAllEmployees']);
Route::get('/employees/active-projects', [EmployeeController::class, 'getActiveProjects']);