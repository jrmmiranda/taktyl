<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Score extends JsonResource
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
            'scores' => $this->scores,
            'creation_date' => $this->creation_date,
            'creation_time' => $this->creation_time
        ];
    }
}
