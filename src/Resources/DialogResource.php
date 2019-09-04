<?php

namespace Woodoocoder\LaravelDialogs\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


/**
 *   @OA\Schema(
 *   schema="Dialog",
 *   type="object",
 *   allOf={
 *       @OA\Schema(
 *           @OA\Property(property="id", format="integer", type="integer"),
 *           @OA\Property(property="subject", type="string"),
 *           @OA\Property(property="count_users", type="integer"),
 *           @OA\Property(property="count_messages", type="integer"),
 *           @OA\Property(property="created_at", type="datetime"),
 *       )
 *   }
 * )
 */
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
            'count_users' => $this->users->count(),
            'count_messages' => $this->messages->count(),
            'latest_message' => $this->latestMessage(),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}