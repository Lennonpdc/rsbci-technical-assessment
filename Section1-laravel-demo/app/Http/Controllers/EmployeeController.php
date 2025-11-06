<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function getAllEmployees(Request $request)
    {
        $query = Employee::query();

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Sort by name
        $sort = $request->get('sort', 'asc');
        $query->orderBy('last_name', $sort)->orderBy('first_name', $sort);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $employees = $query->paginate($perPage);

        $data = $employees->map(fn($e) => [
            'id' => $e->id,
            'name' => "{$e->first_name} {$e->last_name}",
            'department' => $e->department?->name,
            'email' => $e->email,
        ]);

        // Return JSON in a format frontend expects
        return response()->json([
            'data' => $data,
            'total' => $employees->total(),
        ]);
    }

    public function getActiveProjects(): JsonResponse
    {
        $employees = Employee::with(['projects' => function ($query) {
            $query->wherePivotNull('end_date');
        }])->get();

        return response()->json([
            'message' => 'Employees with active projects retrieved successfully.',
            'data' => $employees
        ]);
    }
}
