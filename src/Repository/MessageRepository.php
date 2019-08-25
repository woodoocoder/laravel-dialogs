<?php

namespace Woodoocoder\LaravelDialogs\Repository;

use Woodoocoder\LaravelDialogs\Model\Message;

class MessageRepository extends Repository {
    
    /**
     * MessageRepository constructor.
     * 
     * @param Message $message
     */
    public function __construct(Message $message) {
        parent::__construct($message);
    }
}
