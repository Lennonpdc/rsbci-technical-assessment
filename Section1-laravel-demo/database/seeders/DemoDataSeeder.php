<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Department, Employee, Project};

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $dept = Department::create(['name' => 'Engineering']);

        $emp = Employee::create([
            'department_id' => $dept->id,
            'first_name' => 'Lennon',
            'last_name' => 'Cab',
            'email' => 'lennon@example.com',
            'date_hired' => now(),
        ]);

        $proj = Project::create(['name' => 'HR System Upgrade']);

        $emp->projects()->attach($proj->id, [
            'role' => 'Backend Developer',
            'start_date' => now(),
            'end_date' => null,
        ]);
    }
}
