<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CoreQueryBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractController extends Controller
{
    protected $model;
    protected $queryBuilder;

    public function __construct()
    {
        $this->model = $this->getModelInstance();
        $this->queryBuilder = new CoreQueryBuilder(
            $this->model,
            $this->getAllowedFilters(),
            $this->getAllowedIncludes(),
            $this->getDefaultSort(),
            $this->getAllowedSorts()
        );
    }

    protected function getModelInstance(): Model
    {
        $modelClass = $this->getModel();
        return new $modelClass;
    }

    public function index(Request $request)
    {
        return $this->queryBuilder->read($this->model->newQuery(), true);
    }

    public function store()
    {
        $storeRequestClass = $this->model::getRequestClass();
        $storeRequest = app($storeRequestClass);
        $validatedData = $storeRequest->validated();
        return $this->queryBuilder->create($validatedData);
    }

    public function show(Request $request, $id)
    {
        return $this->queryBuilder->read($this->model->newQuery()->whereKey($id), false);
    }

    public function update($id)
    {
        $updateRequestClass = $this->model::getRequestClass();
        $updateRequest = app($updateRequestClass);
        $validatedData = $updateRequest->validated();

        return $this->queryBuilder->update($validatedData, $id);
    }

    public function destroy($id)
    {
        return $this->queryBuilder->destroy($id);
    }

    abstract protected function getModel(): string;
    abstract protected function getAllowedFilters(): array;
    abstract protected function getAllowedIncludes(): array;
    abstract protected function getDefaultSort(): string;
    abstract protected function getAllowedSorts(): array;
}
