<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoneStepResource extends JsonResource
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
            'form_data_value' => $this->form_data_value,
            'spent_time' => $this->spent_time,
            'step' => $this->step,
        ];
    }
}
