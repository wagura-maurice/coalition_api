<?php

namespace App\Http\Requests;

use App\Models\TaskCatalog;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TaskCatalogRequest extends FormRequest
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
        $rules = TaskCatalog::createRules();

        if (request()->method == 'PUT' || request()->method == 'PATCH') {
            $rules = array_merge($rules, TaskCatalog::updateRules((int) request()->route()->originalParameters()['catalog']));
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if(request()->route()->originalParameters()) {
            $catalog = TaskCatalog::find((int) request()->route()->originalParameters()['catalog']);

            $this->merge(array_filter([
                'due_date' => optional($this)->due_date ? Carbon::parse($this->due_date)->toDateTimeString() :  Carbon::now()->toDateTimeString(),
                '_status' => optional($this)->_status ? $this->_status : ($catalog->_status ?? NULL)
            ]));
        } else {
            $UUID = generateUID(TaskCatalog::class, rand(5, 9));

            $this->merge(array_filter([
                '_uid' => "TASK/CATALOG/" . $UUID,
                'slug' => strtoupper(Str::slug($this->title, '_') . '_' . $UUID . '_' . Carbon::now()->format('YmdHis')),
                'due_date' => optional($this)->due_date ? Carbon::parse($this->due_date)->toDateTimeString() :  Carbon::now()->toDateTimeString(),
                '_status' => optional($this)->_status ? $this->_status : NULL
            ]));
        }
    }
}
