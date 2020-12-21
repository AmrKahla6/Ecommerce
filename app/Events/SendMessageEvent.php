<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Message;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $message, $notifiable_id, $sender;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, $notifiable_id, $sender)
    {
        $this->notifiable_id    = $notifiable_id;        
        $this->message          = $message;        
        $this->sender           = $sender;        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->notifiable_id);
    }
    public function broadcastWith()
    {
        return ['message' => $this->message->message, 'name' => $this->notifiable_id == $this->message->chat()->firstOrFail()->starter_id ? $this->message->sender()->firstOrFail()->name : 'unknown', 'created_at' => $this->message->created_at, 'url' => route('chat', ['id' => $this->message->chat_id])];        
    }
}