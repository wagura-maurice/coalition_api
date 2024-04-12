<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use Spatie\QueryBuilder\AllowedFilter;
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
            AllowedFilter::exact('name')
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
