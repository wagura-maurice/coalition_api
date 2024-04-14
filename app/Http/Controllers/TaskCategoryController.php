<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use Illuminate\Support\Carbon;
use App\Rules\DueDateRangeFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AbstractController;

class TaskCategoryController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModel(): string
    {
        return TaskCategory::class;
    }

    protected function getAllowedFilters(): array
    {
        return [
            'name',
            'description',
            AllowedFilter::callback('search_text', function ($query, $value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('description', 'like', "%{$value}%");
            }),
            AllowedFilter::callback('created_at_date_range', function ($query, $value) {
                // Validate the value using the DueDateRangeFormat rule
                $validator = Validator::make(['created_at_date_range' => $value], [
                    'created_at_date_range' => ['required', new DueDateRangeFormat],
                ]);

                // Check if validation fails
                if ($validator->fails()) {
                    // Handle validation failure (e.g., throw an exception or return a response)
                    // For simplicity, let's assume we throw an exception
                    throw new \InvalidArgumentException('Invalid created_at_date_range format: ' . $validator->errors()->first('created_at_date_range'));
                }

                // If validation passes, proceed with filtering
                $dates = explode('\\', $value);
                if (count($dates) === 2) {
                    $start = Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay();

                    $query->whereBetween('created_at', [$start, $end]);
                }
            }),
        ];
    }

    protected function getAllowedIncludes(): array
    {
        return [
            'catalogs'
        ];
    }

    protected function getDefaultSort(): string
    {
        return '-id';
    }

    protected function getAllowedSorts(): array
    {
        return [
            'name'
        ];
    }
}
