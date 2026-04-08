<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // auth handled by middleware
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'due_date'    => ['required', 'date', 'after_or_equal:today'],
            'status'      => ['required', 'in:pending,in_progress,completed'],
            'subject_id'  => ['nullable', 'exists:subjects,id'],
            'priority_id' => ['nullable', 'exists:priorities,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'A task title is required.',
            'title.min'             => 'Title must be at least 3 characters.',
            'due_date.required'     => 'Please set a due date.',
            'due_date.after_or_equal' => 'Due date must be today or in the future.',
            'status.in'             => 'Invalid status selected.',
        ];
    }
}
