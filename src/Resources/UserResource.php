<?php


namespace Woodoocoder\LaravelDialogs\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

/**
 *   @OA\Schema(
 *   schema="DialogUser",
 *   type="object",
 *   allOf={
 *       @OA\Schema(
 *           @OA\Property(property="id", format="integer", type="integer"),
 *           @OA\Property(property="middlename", format="string", type="string"),
 *           @OA\Property(property="lastname", format="string", type="string"),
 *           @OA\Property(property="avatar_url", format="string", type="string"),
 *           @OA\Property(property="last_activity", format="date-time", type="string")
 *       )
 *   }
 * )
 */
class UserResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'avatar_url' => Storage::url('avatars/'.$this->id.'/'.$this->avatar),
            'last_activity' => $this->last_activity,
        ];
    }
}
