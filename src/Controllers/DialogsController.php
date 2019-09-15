<?php

namespace Woodoocoder\LaravelDialogs\Controllers;

use Illuminate\Http\Request;

use Woodoocoder\LaravelHelpers\Api\Controller;
use Woodoocoder\LaravelDialogs\Response\ApiMessage;
use Woodoocoder\LaravelDialogs\Response\ApiStatus;
use Woodoocoder\LaravelDialogs\Requests\Dialog\CreateRequest;
use Woodoocoder\LaravelDialogs\Requests\Dialog\UpdateRequest;
use Woodoocoder\LaravelDialogs\Repository\DialogRepository;
use Woodoocoder\LaravelDialogs\Repository\MessageRepository;
use Woodoocoder\LaravelDialogs\Resources\DialogResource;
use Woodoocoder\LaravelDialogs\Resources\MessageResource;
use Woodoocoder\LaravelDialogs\Model\Dialog;

class DialogsController extends Controller {

    private $dialogRepo;
    private $messageRepo;

    public function __construct(DialogRepository $dialogRepo,
                                MessageRepository $messageRepo) {
        $this->dialogRepo = $dialogRepo;
        $this->messageRepo = $messageRepo;
    }
    
    /**
     * @OA\Get(
     *     path="/api/dialogs",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Dialogs list",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Dialog")
     *              )
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     )
     * )
     */
    public function index(Request $request) {
        $userId = $request->user()->id;

        return DialogResource::collection($this->dialogRepo->paginateByUserId($userId));
    }
    
    /**
     * @OA\Post(
     *     path="/api/dialogs",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Create Dialog",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", format="string", type="string"),
     *              @OA\Property(property="data", type="object",
     *                  allOf={
     *                      @OA\JsonContent(ref="#/components/schemas/Dialog")
     *                  }
     *              )
     *          )
     *     )
     * )
     */
    public function store(CreateRequest $request) {
        $data = $request->all();
        $userId = $request->user()->id;

        $dialog = $this->dialogRepo->createDialog($userId, $data);
        
        $messageData = [
            'dialog_id' => $dialog->id,
            'user_id' => $userId,
            'message' => $data['message']
        ];
        $this->messageRepo->create($messageData);

        return new DialogResource($this->dialogRepo->find($dialog->id));
    }

    /**
     * @OA\Get(
     *     path="/api/dialogs/{dialogId}",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Get Dialog",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", format="string", type="string"),
     *              @OA\Property(property="data", type="object",
     *                  allOf={
     *                      @OA\JsonContent(ref="#/components/schemas/Dialog")
     *                  }
     *              )
     *          )
     *     )
     * )
     */
    public function show(Request $request, Dialog $dialog) {
        $userId = $request->user()->id;
        return new DialogResource($this->dialogRepo->findDialog($userId, $dialog->id));
    }
    
    /**
     * @OA\Put(
     *     path="/api/dialogs/{dialogId}",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Update Dialog",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", format="string", type="string"),
     *              @OA\Property(property="data", type="object",
     *                  allOf={
     *                      @OA\JsonContent(ref="#/components/schemas/Dialog")
     *                  }
     *              )
     *          )
     *     )
     * )
     */
    public function update(UpdateRequest $request, Dialog $dialog) {
        $isUpdated = $this->dialogRepo->update($request->all(), $dialog->id);
        $dialog = $this->dialogRepo->find($dialog->id);
        
        if($isUpdated) {
            return new DialogResource($dialog);
        }
        else {
            return new DialogResource($dialog, ApiStatus::ERROR);
        }
        
    }
    
    /**
     * @OA\Delete(
     *     path="/api/dialogs/{dialogId}",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Delete Dialog"
     *     )
     * )
     */
    public function destroy(Dialog $dialog) {
        if($dialog->delete()) {
            return new ApiMessage();
        }
        else {
            return new ApiMessage(ApiStatus::ERROR);
        }
    }
}
