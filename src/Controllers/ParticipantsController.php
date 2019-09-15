<?php

namespace Woodoocoder\LaravelDialogs\Controllers;

use Illuminate\Http\Request;

use Woodoocoder\LaravelHelpers\Api\Controller;
use Woodoocoder\LaravelDialogs\Repository\ParticipantRepository;
use Woodoocoder\LaravelDialogs\Resources\ParticipantResource;
use Woodoocoder\LaravelDialogs\Model\Dialog;

class ParticipantsController extends Controller {

    private $participantRepo;

    public function __construct(ParticipantRepository $participantRepo) {
        $this->participantRepo = $participantRepo;
    }
    
    /**
     * @OA\Get(
     *     path="/api/dialogs/{dialogId}/participants",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Participants List",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Participant")
     *              )
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     )
     * )
     */
    public function index(Dialog $dialog) {
        return ParticipantResource::collection($this->participantRepo->getByDialog($dialog));
    }

}
