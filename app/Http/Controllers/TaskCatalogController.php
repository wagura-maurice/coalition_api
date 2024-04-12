<?php

namespace App\Http\Controllers;

use App\Models\TaskCatalog;
use Illuminate\Support\Carbon;
use App\Rules\DueDateRangeFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AbstractController;

class TaskCatalogController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModel(): string
    {
        return TaskCatalog::class;
    }

    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::callback('category_id', function ($query, $value) {
                $query->where('category_id', '=', $value);
            }),
            AllowedFilter::callback('title', function ($query, $value) {
                $query->where('title', 'like', "%{$value}%");
            }),
            AllowedFilter::callback('slug', function ($query, $value) {
                $query->where('slug', 'like', "%{$value}%");
            }),
            AllowedFilter::callback('description', function ($query, $value) {
                $query->where('description', 'like', "%{$value}%");
            }),
            AllowedFilter::callback('due_date_range', function ($query, $value) {
                // Validate the value using the DueDateRangeFormat rule
                $validator = Validator::make(['due_date_range' => $value], [
                    'due_date_range' => ['required', new DueDateRangeFormat],
                ]);

                // Check if validation fails
                if ($validator->fails()) {
                    // Handle validation failure (e.g., throw an exception or return a response)
                    // For simplicity, let's assume we throw an exception
                    throw new \InvalidArgumentException('Invalid due_date_range format: ' . $validator->errors()->first('due_date_range'));
                }

                // If validation passes, proceed with filtering
                $dates = explode('\\', $value);
                if (count($dates) === 2) {
                    $start = Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay();

                    $query->whereBetween('due_date', [$start, $end]);
                }
            }),
            AllowedFilter::exact('_status'),
            AllowedFilter::callback('category_name', function ($query, $value) {
                $query->whereHas('category', function($query) use ($value) {
                    $query->where('name', 'like', "%{$value}%");
                });
            }),
        ];
    }

    protected function getAllowedIncludes(): array
    {
        return [
            'category'
        ];
    }

    protected function getDefaultSort(): string
    {
        return '-id';
    }

    protected function getAllowedSorts(): array
    {
        return [
            '_uid',
            'category_id',
            'title',
            'slug',
            'description',
            'due_date',
            '_priority',
            '_status'
        ];
    }
}
