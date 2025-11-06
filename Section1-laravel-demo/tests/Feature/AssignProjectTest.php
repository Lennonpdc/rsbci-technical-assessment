<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{Employee, Project, Department};

class AssignProjectTest extends TestCase
{
    // use RefreshDatabase;

    protected $employee;
    protected $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(); // <-- Disable auth/CSRF for testing

        $this->employee = \App\Models\Employee::factory()->create();
        $this->project = \App\Models\Project::factory()->create();

        // Create sample data
        $dept = Department::factory()->create(['name' => 'Engineering']);
        $this->employee = Employee::factory()->create([
            'department_id' => $dept->id,
        ]);
        $this->project = Project::factory()->create([
            'name' => 'CRM Upgrade'
        ]);
    }

    // Test if required fields are present ENSURING VALIDATION
    /** @test */
    public function it_requires_required_fields()
    {
        $response = $this->postJson('/api/employees/' . $this->employee->id . '/projects', []);

        $response->assertStatus(422);
    }

    // Test if project is successfully assigned SUCCESSFUL CREATION of project
    /** @test */
    public function it_assigns_a_project_successfully()
    {
        $payload = [
            'projects' => [
                [
                    'project_id' => $this->project->id,
                    'role' => 'Backend Developer',
                    'start_date' => now()->toDateString(),
                ]
            ]
        ];

        $response = $this->postJson('/api/employees/' . $this->employee->id . '/projects', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('employee_projects', [
            'employee_id' => $this->employee->id,
            'project_id' => $this->project->id,
            'role' => 'Backend Developer'
        ]);
    }

    // Test if employee is already assigned to the project DUPLICATE ASSIGNMENT PREVENTION
    /** @test */
    public function it_prevents_duplicate_assignments()
    {
        $this->employee->projects()->attach($this->project->id, [
            'role' => 'Backend Developer',
            'start_date' => now(),
        ]);

        $payload = [
            'projects' => [
                [
                    'project_id' => $this->project->id,
                    'role' => 'Backend Developer',
                    'start_date' => now()->toDateString(),
                ]
            ]
        ];

        $response = $this->postJson('/api/employees/' . $this->employee->id . '/projects', $payload);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Employee is already assigned to this project.'
            ]);
    }
}
