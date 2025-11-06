<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Models\Employee;
use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    // Create a new time entry
    public function createTimeEntry(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'employee_id' => 'required|exists:employees,id',
            'hours' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $timeEntry = TimeEntry::create($validated);

        return response()->json(['data' => $timeEntry], 201);
    }

    // Get time entries for an employee between two dates
    public function getTimeEntry(Employee $employee, Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $entries = TimeEntry::where('employee_id', $employee->id)
            ->whereBetween('date', [$request->from, $request->to])
            ->with('project')
            ->get();

        return response()->json(['data' => $entries]);
    }
}
