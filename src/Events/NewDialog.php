<?php

namespace Woodoocoder\LaravelDialogs\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Woodoocoder\LaravelDialogs\Resources\DialogResource;

class NewDialog implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $userId;
    public $data;

    public function __construct($dialog, $user) {
        $this->userId = $user->id;
        $this->data = (new DialogResource($dialog))->userId($user->id);
    }

    public function broadcastOn() {
        return new PrivateChannel('dialogs.'.$this->userId);
    }

    public function broadcastAs() {
        return 'new-dialog';
    }

    public function broadcastWith() {
        return ['data' => $this->data, 'user' => $this->userId];
    }

    
}