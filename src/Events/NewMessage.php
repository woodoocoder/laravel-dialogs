<?php

namespace Woodoocoder\LaravelDialogs\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Woodoocoder\LaravelDialogs\Resources\MessageResource;

class NewMessage implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $dialogId;
    public $data;

    public function __construct($message) {
        $this->dialogId = $message['dialog_id'];
        $this->data = new MessageResource($message);
    }

    public function broadcastOn() {
        return new PrivateChannel('dialog_id.' . $this->dialogId);
    }

    public function broadcastAs() {
        return 'new-message';
    }

    public function broadcastWith() {
        return ['data' => $this->data];
    }

    
}