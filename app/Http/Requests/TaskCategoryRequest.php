<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use App\Models\TaskCategory;
use Illuminate\Support\Carbon;
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

    protected function prepareForValidation()
    {
        if (request()->route()->originalParameters()) {
            $this->merge(array_filter([]));
        } else {
            $this->merge(array_filter([
                // 'slug' => Str::slug($this->name, '_') . '_' . Carbon::now()->format('YmdHis')
            ]));
        }
    }
}
