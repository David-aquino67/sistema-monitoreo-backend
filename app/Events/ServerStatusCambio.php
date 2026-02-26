<?php
class ServerStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public function broadcastOn()
    {
        return new Channel('status-channel');
    }

    public function broadcastAs()
    {
        return 'server.updated';
    }
}
