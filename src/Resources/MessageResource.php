<?php

namespace Woodoocoder\LaravelDialogs\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


/**
 *   @OA\Schema(
 *   schema="Message",
 *   type="object",
 *   allOf={
 *       @OA\Schema(
 *           @OA\Property(property="id", format="integer", type="integer"),
 *           @OA\Property(property="dialog_id", type="integer"),
 *           @OA\Property(property="user_id", type="integer"),
 *           @OA\Property(property="message", type="string"),
 *       )
 *   }
 * )
 */
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