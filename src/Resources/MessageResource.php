<?php

namespace Woodoocoder\LaravelDialogs\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Woodoocoder\LaravelDialogs\Resources\UserResource;

/**
 *   @OA\Schema(
 *   schema="Message",
 *   type="object",
 *   allOf={
 *       @OA\Schema(
 *           @OA\Property(property="id", format="integer", type="integer"),
 *           @OA\Property(property="dialog_id", type="integer"),
 *           @OA\Property(property="user", type="object",
 *              allOf={
 *                  @OA\JsonContent(ref="#/components/schemas/DialogUser")
 *              }
 *           ),
 *           @OA\Property(property="message", type="string"),
 *           @OA\Property(property="created_at", type="datetime"),
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
            'user' => new UserResource($this->user),
            'message' => $this->message,
            'seen' => $this->seen,
            'created_at' => $this->created_at,
        ];
    }
}