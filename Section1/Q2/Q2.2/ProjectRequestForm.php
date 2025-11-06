<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    
    public function rules(): array
    {
        return [
            'projects' => 'required|array|min:1',                      // array of objects with project_id and role to assign and check if at least one project is assigned
            'projects.*.project_id' => 'required|exists:projects,id',  // check if project exists in projects table through project_id
            'projects.*.role' => 'required|string|max:100',            // check if role is a string
            'projects.*.start_date' => 'required|date',                // check if start_date is a valid date
        ];
    }

    public function messages(): array
    {
        return [
            'projects.required' => 'Must assign at least one project.',
            'projects.*.project_id.exists' => 'Project does not exist.',
        ];
    }
}
