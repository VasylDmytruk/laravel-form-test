<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        $parent = parent::toArray($request);
//        unset($parent['form_id']);
//
//        $merged = array_merge($parent, [
//            'forms' => FormResource::collection($this->whenLoaded('forms')),
//        ]);

        return [
            'title' => $this->title,
            'form' => $this->form,
        ];
    }
}
