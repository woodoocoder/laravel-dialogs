<?php

namespace Woodoocoder\LaravelDialogs\Repository;

use Woodoocoder\LaravelDialogs\Model\Message;
use Woodoocoder\LaravelDialogs\Model\Dialog;

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
}
