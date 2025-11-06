<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\ProjectRequestForm;

class EmployeeProjectController extends Controller
{
    //Assign multiple projects to an employee
    public function createProject(ProjectRequestForm $request, Employee $employee)
    {
        $validatedData = $request->validated();

        // Attach new projects with pivot data
        foreach ($validatedData['projects'] as $project) {
            $employee->projects()->attach($project['project_id'], [
                'role' => $project['role'],
                'start_date' => $project['start_date'],
            ]);
        }

        // Load the assigned projects (with pivot info)
        $employee->load('projects');

        return response()->json([
            'message' => 'Projects successfully assigned to employee.',
            'data' => $employee,
        ], 201);
    }
}
