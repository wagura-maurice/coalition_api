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

    // priority
    const URGENT = 0;
    const HIGH = 1;
    const MEDIUM = 2;
    const LOW = 3;
    const CRITICAL = 4;
    const NORMAL = 5;
    const EMERGENCY = 6;
    const DEFERRED = 7;
    const OPTIONAL = 8;
    const ROUTINE = 9;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_uid',
        'category_id',
        'title',
        'slug',
        'description',
        'due_date',
        '_priority',
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
    
    public static function createRules()
    {
        return [
            '_uid' => 'required|string|unique:task_catalogs',
            'category_id' => 'required|integer',
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|integer',
            'due_date' => 'required|date',
            '_priority' => 'nullable|integer',
            '_status' => 'nullable|integer'
        ];
    }

    public static function updateRules(int $id)
    {
        return [
            '_uid' => 'nullable|string|' . Rule::unique('task_catalogs', '_uid')->ignore($id),
            'category_id' => 'nullable|integer',
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|integer',
            'due_date' => 'nullable|date',
            '_priority' => 'nullable|integer',
            '_status' => 'nullable|integer'
        ];
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class, 'category_id', 'id');
    }
}
