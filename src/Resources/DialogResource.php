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
 *           @OA\Property(property="count_messages", type="integer"),
 *           @OA\Property(property="latest_message", type="object",
 *              allOf={
 *                  @OA\JsonContent(ref="#/components/schemas/Message")
 *              }
 *           ),
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
        $userId = $request->user()->id;

        // Dialog subject
        $subject = $this->subject;
        if(!$subject) {
            foreach($this->participants as $participant) {
                if($participant->user_id == $userId) {
                    $subject = $participant->subject;
                }
            }
        }

        return [
            'id' => $this->id,
            'count_messages' => $this->messages->count(),
            'latest_message' => new MessageResource($this->latestMessage()),
            'participants' => ParticipantResource::collection($this->participants),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}