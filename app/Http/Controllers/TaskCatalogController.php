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
            '_uid',
            'title',
            'slug',
            'description',
            '_priority',
            '_status',
            AllowedFilter::callback('search', function ($query, $value) {
                $query->where('_uid', 'like', "%{$value}%")
                    ->orWhere('title', 'like', "%{$value}%")
                    ->orWhere('slug', 'like', "%{$value}%")
                    ->orWhere('description', 'like', "%{$value}%");
            }),
            AllowedFilter::callback('category_name', function ($query, $value) {
                $query->whereHas('category', function($query) use ($value) {
                    $query->where('name', 'like', "%{$value}%");
                });
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

                    // \Log::info(print_r([$start, $end], true));
                    // \Log::info(print_r($query->get()->toArray(), true));
                }
            }),
            AllowedFilter::exact('_status')
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
