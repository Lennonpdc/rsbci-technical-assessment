$employees = Employee::with(['projects' => function ($query) {
    $query->wherePivotNull('end_date'); // only active projects
}])->get();


example json response:

[
  {
    "id": 1,
    "first_name": "Lennon",
    "last_name": "Cabrera",
    "projects": [
      {
        "id": 2,
        "name": "HR Revamp",
        "pivot": {
          "role": "Frontend Developer",
          "start_date": "2025-11-04",
          "end_date": null
        }
      }
    ]
  }
]
