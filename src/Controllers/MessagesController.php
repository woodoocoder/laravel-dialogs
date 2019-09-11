<?php

namespace Woodoocoder\LaravelDialogs\Controllers;

use Illuminate\Http\Request;

use Woodoocoder\LaravelDialogs\Response\ApiMessage;
use Woodoocoder\LaravelDialogs\Response\ApiStatus;
use Woodoocoder\LaravelDialogs\Requests\Message\CreateRequest;
use Woodoocoder\LaravelDialogs\Requests\Message\UpdateRequest;
use Woodoocoder\LaravelDialogs\Repository\MessageRepository;
use Woodoocoder\LaravelDialogs\Resources\MessageResource;
use Woodoocoder\LaravelDialogs\Model\Dialog;
use Woodoocoder\LaravelDialogs\Model\Message;

class MessagesController extends Controller {

    private $messageRepo;

    public function __construct(MessageRepository $messageRepo) {
        $this->messageRepo = $messageRepo;
    }

    
    /**
     * @OA\Get(
     *     path="/api/dialogs/{dialogId}/messages",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Messages list",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Message")
     *              )
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     )
     * )
     */
    public function index(Request $request, Dialog $dialog) {
        $userId = $request->user()->id;
        return MessageResource::collection($this->messageRepo->paginateByDialog($userId, $dialog));
    }

    /**
     * @OA\Post(
     *     path="/api/dialogs/{dialogId}/messages",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Create Message",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Message")
     *              )
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     )
     * )
     */
    public function store(CreateRequest $request, Dialog $dialog) {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $message = new MessageResource($this->messageRepo->create($data));

        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  Message  $message
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message) {
        return new MessageResource($message);
    }

    
    /**
     * @OA\Put(
     *     path="/api/dialogs/{dialogId}/messages/{messageId}",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Update Message",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/Message")
     *              )
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     )
     * )
     */
    public function update(UpdateRequest $request, Dialog $dialog, Message $message) {
        $isUpdated = $this->messageRepo->update($request->all(), $message->id);
        $message = $this->messageRepo->find($message->id);
        
        if($isUpdated) {
            return new MessageResource($message);
        }
        else {
            return new MessageResource($message, ApiStatus::ERROR);
        }
        
    }

    /**
     * @OA\Delete(
     *     path="/api/dialogs/{dialogId}/messages/{messageId}",
     *     tags={"Dialogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Delete Message"
     *     )
     * )
     */
    public function destroy(Dialog $dialog, Message $message) {
        if($message->delete()) {
            return new ApiMessage();
        }
        else {
            return new ApiMessage(ApiStatus::ERROR);
        }
    }
}
