<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'sometimes|string|min:3|max:100',
            'status' => 'required|string|in:pending,in_progress,done',
            'priority' => 'required|string|in:low,medium,high',
            'due_date' => 'requried|date',
            'project_id' => 'requried|integer|exists:project,id'
        ];
    }
}
