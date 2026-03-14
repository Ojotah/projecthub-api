<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',

            'project_id' => 'sometimes|exists:projects,id',

            'assigned_to' => 'nullable|exists:users,id',

            'status' => 'sometimes|in:todo,in_progress,done',

            'due_date' => 'nullable|date',
        ];
    }
}
