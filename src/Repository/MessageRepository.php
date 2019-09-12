<?php

namespace Woodoocoder\LaravelDialogs\Repository;

use Woodoocoder\LaravelDialogs\Model\Message;
use Woodoocoder\LaravelDialogs\Model\Dialog;
use Woodoocoder\LaravelDialogs\Events\NewMessage;
use Woodoocoder\LaravelDialogs\Events\NewDialog;

class MessageRepository extends Repository {
    
    /**
     * MessageRepository constructor.
     * 
     * @param Message $message
     */
    public function __construct(Message $message) {
        parent::__construct($message);
    }


    /**
     * @param int $perPage
     * 
     * @return LengthAwarePaginator
     */
    public function paginateByDialog(int $userId, Dialog $dialog, int $perPage = 20, string $orderBy = 'id', string $sortBy = 'desc') {
        return $this->model->where('dialog_id', $dialog->id)
            ->orderBy($orderBy, $sortBy)->paginate($perPage);
    }

    /**
     * @param array $attributes
     * 
     * @return mixed
     */
    public function create(array $attributes) {
        $message = $this->model->create($attributes);
        $message->dialog->touch();

        
        broadcast(new NewMessage($message))->toOthers();

        foreach($message->dialog->users as $user) {
            if(auth()->guard('api')->user()->id != $user->id) {
                broadcast(new NewDialog($message->dialog, $user))->toOthers();
            }
        }

        return $message;
    }
}
