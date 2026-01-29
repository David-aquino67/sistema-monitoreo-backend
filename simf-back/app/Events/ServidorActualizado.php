<?php

class ServidorActualizado implements ShouldBroadcast
{
use Dispatchable, InteractsWithSockets, SerializesModels;

public $servidor;

public function __construct($servidor)
{
$this->servidor = $servidor;
}

public function broadcastOn(): array
{
return [new Channel('monitoreo-global')];
}

public function broadcastAs(): string
{
return 'servidor.cambio';
}
}
