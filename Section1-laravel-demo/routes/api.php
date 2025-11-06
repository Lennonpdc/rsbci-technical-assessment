<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TimeEntryController;

Route::post('/employees/{employee}/projects', [EmployeeProjectController::class, 'createProject']);
Route::post('/new-employee', [EmployeeProjectController::class, 'createEmployee']);
Route::post('/new-department', [EmployeeProjectController::class, 'createDepartment']);

Route::get('/employees', [EmployeeController::class, 'getAllEmployees']);
Route::get('/employees/active-projects', [EmployeeController::class, 'getActiveProjects']);

//API routes for time entries
Route::post('/time-entries', [TimeEntryController::class, 'createTimeEntry']);
Route::get('/employees/{employee}/time-entries', [TimeEntryController::class, 'getTimeEntry']);