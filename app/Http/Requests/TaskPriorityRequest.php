<?php

namespace App\Http\Requests;

use App\Models\TaskPriority;
use Illuminate\Foundation\Http\FormRequest;

class TaskPriorityRequest extends FormRequest
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
        $rules = TaskPriority::createRules();

        if (request()->method == 'PUT' || request()->method == 'PATCH') {
            $rules = array_merge($rules, TaskPriority::updateRules((int) request()->route()->originalParameters()['priority']));
        }

        return $rules;
    }
}
