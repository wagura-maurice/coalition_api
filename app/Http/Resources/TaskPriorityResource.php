<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskPriorityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
    
    public function with(Request $request)
    {
        return [
            'throwable' => array_filter([
                'status' => optional($request)->status,
                'message' => optional($request)->message
            ])
        ];
    }
    
    public function withResponse(Request $request, $response)
    {
        $response->header('Accept', 'application/json');
    }
}
