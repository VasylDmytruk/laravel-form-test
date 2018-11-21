<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StepTimeResource extends JsonResource
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
            'id' => $this->id,
            'step' => $this->step ?? ['title' => ''],
            'user' => $this->user ?? ['name' => ''],
            'spent_time' => $this->spent_time,
            'created_at' => $this->created_at,
        ];
    }
}
