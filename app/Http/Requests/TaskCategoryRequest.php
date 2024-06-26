<?php

namespace App\Http\Requests;

use App\Models\TaskCategory;
use Illuminate\Foundation\Http\FormRequest;

class TaskCategoryRequest extends FormRequest
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
        $rules = TaskCategory::createRules();

        if (request()->method == 'PUT' || request()->method == 'PATCH') {
            $rules = array_merge($rules, TaskCategory::updateRules((int) request()->route()->originalParameters()['category']));
        }

        return $rules;
    }
}
