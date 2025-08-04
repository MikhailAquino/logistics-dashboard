<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ProximityChecked implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $log;

    public function __construct($log) { $this->log = $log; }

    public function broadcastOn() { return new Channel('proximity'); }
    public function broadcastWith() { return ['log' => $this->log->toArray()]; }
}
