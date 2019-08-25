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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return DialogResource::collection($this->dialogRepo->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request) {
        return new DialogResource($this->dialogRepo->create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  Dialog  $dialog
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Dialog $dialog) {
        return new DialogResource($dialog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Dialog  $dialog
     * 
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  Dialog  $dialog
     * 
     * @return \Illuminate\Http\Response
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
