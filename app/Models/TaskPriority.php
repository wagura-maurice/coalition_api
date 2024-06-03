<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\TaskPriorityRequest;
use App\Http\Resources\TaskPriorityResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskPriority extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected function getRequestClass(): string
    {
        return TaskPriorityRequest::class;
    }

    protected function getResourceClass(): string
    {
        return TaskPriorityResource::class;
    }

    public static function createRules()
    {
        return [
            'name' => ['required', 'string', Rule::unique('task_priorities', 'name')],
            'color' => ['required', 'string', Rule::unique('task_priorities', 'color')],
            'description' => 'nullable|string'
        ];
    }

    public static function updateRules(int $id)
    {
        return [
            'name' => ['nullable', 'string', Rule::unique('task_priorities', 'name')->ignore($id)],
            'color' => ['nullable', 'string', Rule::unique('task_priorities', 'color')->ignore($id)],
            'description' => 'nullable|string'
        ];
    }

    public function catalogs(): HasMany
    {
        return $this->hasMany(TaskCatalog::class, 'id', 'priority_id');
    }
}
