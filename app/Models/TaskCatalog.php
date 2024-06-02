<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\TaskCatalogRequest;
use App\Http\Resources\TaskCatalogResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskCatalog extends Model
{
    use HasFactory, SoftDeletes;

    // status
    const PENDING = 0;
    const PROCESSING = 1;
    const PROCESSED = 2;
    const COMPLETED = 3;
    const CANCELLED = 4;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_uid',
        'category_id',
        'priority_id',
        'title',
        'slug',
        'description',
        'due_date',
        '_status'
    ];

    protected function getRequestClass(): string
    {
        return TaskCatalogRequest::class;
    }

    protected function getResourceClass(): string
    {
        return TaskCatalogResource::class;
    }
    
    public static function createRules(): array
    {
        return [
            '_uid' => ['required', 'string', Rule::unique('task_catalogs', '_uid')],
            'category_id' => 'required|integer|exists:task_categories,id',
            'priority_id' => 'required|integer|exists:task_priorities,id',
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            '_status' => 'nullable|integer'
        ];
    }

    public static function updateRules(int $id): array
    {
        return [
            '_uid' => ['nullable', 'string', Rule::unique('task_catalogs', '_uid')->ignore($id)],
            'category_id' => 'nullable|integer|exists:task_categories,id',
            'priority_id' => 'nullable|integer|exists:task_priorities,id',
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            '_status' => 'nullable|integer'
        ];
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class, 'category_id', 'id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(TaskPriority::class, 'priority_id', 'id');
    }
}
