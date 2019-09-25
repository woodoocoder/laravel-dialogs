<?php

namespace Woodoocoder\LaravelDialogs\Repository;

use Woodoocoder\LaravelHelpers\DB\Repository;
use Woodoocoder\LaravelDialogs\Model\Message;
use Woodoocoder\LaravelDialogs\Model\Dialog;
use Woodoocoder\LaravelDialogs\Model\Message\Actions;
use Woodoocoder\LaravelDialogs\Events\NewMessage;
use Woodoocoder\LaravelDialogs\Events\NewDialog;
use Woodoocoder\LaravelDialogs\Events\MessageEdited;

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

        $message->actions()->save(new Actions([
                'message_id' => $message->id,
                'user_id' => $attributes['user_id'],
                'seen' => true
            ]));

        broadcast(new NewMessage($message))->toOthers();

        foreach($message->dialog->users as $user) {
            if(auth()->guard('api')->user()->id != $user->id) {
                $user->pivot->increment('unread_messages');
                broadcast(new NewDialog(Dialog::find($message->dialog->id), $user))->toOthers();
            }
        }

        return $message;
    }

    /**
     * @param array $attributes
     * @param int $id
     * 
     * @return bool
     */
    public function update(array $attributes, int $id): bool {
        $item = $this->find($id)->update($attributes);

        broadcast(new MessageEdited($this->find($item->id)))->toOthers();

        return $item;
    }

    public function markReedAll($userId, $dialogId) {
        $dialog = Dialog::find($dialogId);
        
        foreach($dialog->users as $user) {
            if($user->id == $userId) {
                $user->pivot->unread_messages = 0;
                $user->pivot->save();
            }
        }

        return true;
    }
}
