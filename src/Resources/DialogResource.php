<?php

namespace Woodoocoder\LaravelDialogs\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


class DialogResource extends JsonResource {

    use ApiResourceTrait;
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
        ];
    }
}