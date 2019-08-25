<?php

namespace Woodoocoder\LaravelDialogs\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


class MessageResource extends JsonResource {

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
            'dialog_id' => $this->dialog_id,
            'user_id' => $this->user_id,
            'message' => $this->message,
        ];
    }
}