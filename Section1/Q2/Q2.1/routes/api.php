<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeProjectController;

Route::post('/employees/{employee}/projects', [EmployeeProjectController::class, 'createProject']);
