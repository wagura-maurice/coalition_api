<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\TaskCategoryRequest;
use App\Http\Resources\TaskCategoryResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    protected function getRequestClass(): string
    {
        return TaskCategoryRequest::class;
    }

    protected function getResourceClass(): string
    {
        return TaskCategoryResource::class;
    }

    public static function createRules()
    {
        return [
            'name' => 'required|string|unique:task_categories',
            'description' => 'nullable|string'
        ];
    }

    public static function updateRules(int $id)
    {
        return [
            'name' => 'nullable|string|' . Rule::unique('task_categories', 'name')->ignore($id),
            'description' => 'nullable|string'
        ];
    }

    public function catalogs(): HasMany
    {
        return $this->hasMany(TaskCatalog::class, 'id', 'category_id');
    }
}
