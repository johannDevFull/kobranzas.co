<?php

namespace App\Events;

use App\Models\TempMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTempMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $id;
    
    public function __construct(TempMessage $message,$id)
    {
        $this->message=$message;
        $this->id=$id;
    }

    public function broadcastOn()
    {
    
         return new Channel('tempChat.'.$this->message->to);
    }
    
}
