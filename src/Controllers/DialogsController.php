<?php

namespace Woodoocoder\LaravelDialogs\Controllers;

use Illuminate\Http\Request;

use Woodoocoder\LaravelDialogs\Response\ApiMessage;
use Woodoocoder\LaravelDialogs\Response\ApiStatus;
use Woodoocoder\LaravelDialogs\Requests\Dialog\CreateRequest;
use Woodoocoder\LaravelDialogs\Requests\Dialog\UpdateRequest;
use Woodoocoder\LaravelDialogs\Repository\DialogRepository;
use Woodoocoder\LaravelDialogs\Resources\DialogResource;
use Woodoocoder\LaravelDialogs\Model\Dialog;

class DialogsController extends Controller {

    private $dialogRepo;

    public function __construct(DialogRepository $dialogRepo) {
        $this->dialogRepo = $dialogRepo;
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
    public function index() {
        return DialogResource::collection($this->dialogRepo->paginate());
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
        return new DialogResource($this->dialogRepo->create($request->all()));
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
    public function show(Dialog $dialog) {
        return new DialogResource($dialog);
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
