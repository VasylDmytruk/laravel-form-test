<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StepProcedureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => $this->user ?? ['id' => null, 'name' => ''],
            'total_spent_time' => $this->total_spent_time,
            'created_at' => $this->created_at,
            'done_steps' => $this->doneSteps,
        ];
    }
}
